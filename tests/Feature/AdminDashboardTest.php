<?php

namespace Tests\Feature;

use App\Models\CalendarEvent;
use App\Models\MediaItem;
use App\Models\Message;
use App\Models\Post;
use App\Models\Project;
use App\Models\StackCategory;
use App\Models\User;
use App\Services\PortfolioContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create(['username' => 'eslopezm', 'name' => 'Eli Santiago López Mahecha', 'is_admin' => true]);
        $this->actingAs($user)->withSession(['admin_last_activity' => time()]);
        Storage::fake('uploads');
        PortfolioContent::flush();
    }

    private function postData(array $override = []): array
    {
        return $override + [
            'title' => 'Seguridad en Laravel', 'excerpt' => 'Buenas prácticas.', 'category' => 'Laravel',
            'content' => '<p>Hola <strong>mundo</strong></p><script>alert(1)</script><p onclick="x()">Texto</p>', 'published' => 1,
        ];
    }

    public function test_hub_and_both_areas_render(): void
    {
        foreach (['/admin', '/admin-dcc', '/admin-develop', '/admin-develop/tecnologias', '/admin-develop/proyectos', '/admin-develop/certificados',
            '/admin-develop/ajustes', '/admin-develop/mensajes', '/admin-develop/imagenes', '/admin-dcc/imagenes', '/admin-dcc/calendario',
            '/admin-dcc/blogs', '/admin-develop/blogs/nuevo', '/admin-dcc/blogs/nuevo', '/admin-dcc/calendario/nuevo'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_post_is_created_with_my_name_as_author_and_sanitized_content(): void
    {
        $this->post('/admin-develop/blogs', $this->postData())->assertRedirect();

        $post = Post::firstOrFail();
        $this->assertSame('Eli Santiago López Mahecha', $post->author);
        $this->assertStringNotContainsString('script', $post->content);
        $this->assertStringNotContainsString('onclick', $post->content);
        $this->assertStringContainsString('<strong>mundo</strong>', $post->content);
        $this->assertNotNull($post->published_at);
        $this->assertSame('seguridad-en-laravel', $post->slug);
    }

    public function test_sql_payloads_are_rejected_in_admin_forms_but_rich_content_is_allowed(): void
    {
        $this->post('/admin-develop/blogs', $this->postData(['title' => "x'; DROP TABLE posts;--"]))->assertSessionHasErrors('title');
        $this->assertSame(0, Post::count());

        $this->post('/admin-develop/blogs', $this->postData(['content' => '<p>Ejemplo: SELECT * FROM users</p>']))->assertRedirect();
        $this->assertSame(1, Post::count());
    }

    public function test_each_area_only_accepts_its_own_categories_and_posts(): void
    {
        $this->post('/admin-dcc/blogs', $this->postData())->assertSessionHasErrors('category');
        $this->post('/admin-dcc/blogs', $this->postData(['category' => 'dcc-evento']))->assertRedirect();

        $dcc = Post::first();
        $this->get("/admin-develop/blogs/{$dcc->id}/editar")->assertNotFound();
        $this->get("/admin-dcc/blogs/{$dcc->id}/editar")->assertOk();
    }

    public function test_video_url_must_be_youtube_or_vimeo(): void
    {
        $this->post('/admin-develop/blogs', $this->postData(['video_url' => 'https://evil.example/video']))->assertSessionHasErrors('video_url');
        $this->post('/admin-develop/blogs', $this->postData(['video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']))->assertRedirect();

        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', Post::first()->videoEmbedUrl());
    }

    public function test_seo_is_generated_automatically_from_the_post(): void
    {
        $this->post('/admin-develop/blogs', $this->postData(['title' => 'Arquitectura hexagonal en Laravel', 'excerpt' => 'Cómo separar dominio e infraestructura en proyectos Laravel.']));
        $post = Post::first();

        $this->assertSame('Arquitectura hexagonal en Laravel', $post->seoTitle());
        $this->assertStringContainsString('dominio', $post->seoDescription());
        $this->assertStringContainsString('laravel', $post->seoKeywords());

        $html = $this->get($post->publicUrl())->assertOk()->getContent();
        $this->assertStringContainsString('"@type":"BlogPosting"', $html);
        $this->assertStringContainsString('property="og:type" content="article"', $html);
        $this->assertStringContainsString('rel="canonical" href="'.$post->publicUrl().'"', $html);
        $this->get('/sitemap.xml')->assertSee($post->publicUrl(), false);
    }

    public function test_views_count_once_per_visitor_and_ignore_bots(): void
    {
        $this->post('/admin-develop/blogs', $this->postData());
        $post = Post::first();
        auth()->logout();

        $this->get($post->publicUrl());
        $this->get($post->publicUrl());
        $this->assertSame(1, $post->fresh()->views);

        $this->withHeader('User-Agent', 'Googlebot/2.1')->withServerVariables(['REMOTE_ADDR' => '9.9.9.9'])->get($post->publicUrl());
        $this->assertSame(1, $post->fresh()->views);
    }

    public function test_likes_toggle_per_visitor(): void
    {
        $this->post('/admin-develop/blogs', $this->postData());
        $post = Post::first();
        auth()->logout();

        $first = $this->postJson("/blog/{$post->slug}/like")->assertOk()->assertJson(['liked' => true, 'likes' => 1]);
        $cookie = $first->getCookie('liked_posts', false);

        $this->withCredentials()->withUnencryptedCookie('liked_posts', $cookie->getValue())->postJson("/blog/{$post->slug}/like")->assertJson(['liked' => false, 'likes' => 0]);
    }

    public function test_unpublished_posts_are_not_public(): void
    {
        $this->post('/admin-develop/blogs', $this->postData(['published' => 0]));
        $post = Post::first();

        $this->get($post->publicUrl())->assertNotFound();
        $this->postJson("/blog/{$post->slug}/like")->assertNotFound();
    }

    public function test_message_bulk_actions_support_multiple_statuses(): void
    {
        $messages = collect(range(1, 3))->map(fn ($i) => Message::create(['nombre' => "N$i", 'email' => "n$i@x.com", 'mensaje' => 'hola', 'statuses' => []]));
        $ids = $messages->pluck('id')->all();

        $this->post('/admin-develop/mensajes/masivo', ['ids' => $ids, 'action' => 'add', 'status' => 'contactado']);
        $this->post('/admin-develop/mensajes/masivo', ['ids' => [$ids[0]], 'action' => 'add', 'status' => 'negociacion']);
        $this->assertEqualsCanonicalizing(['contactado', 'negociacion'], $messages[0]->fresh()->statuses);

        $this->post('/admin-develop/mensajes/masivo', ['ids' => $ids, 'action' => 'remove', 'status' => 'contactado']);
        $this->assertSame(['negociacion'], array_values($messages[0]->fresh()->statuses));

        $this->post('/admin-develop/mensajes/masivo', ['ids' => [$ids[1]], 'action' => 'set', 'status' => 'spam']);
        $this->assertSame(['spam'], $messages[1]->fresh()->statuses);

        $this->post('/admin-develop/mensajes/masivo', ['ids' => [$ids[0], $ids[1]], 'action' => 'delete']);
        $this->assertSame(1, Message::count());

        $this->post('/admin-develop/mensajes/masivo', ['ids' => $ids, 'action' => 'add', 'status' => 'inventado'])->assertSessionHasErrors('status');
    }

    public function test_opening_a_message_marks_it_as_read(): void
    {
        $message = Message::create(['nombre' => 'Ana', 'email' => 'a@x.com', 'mensaje' => '<script>alert(1)</script>', 'statuses' => []]);

        $this->get("/admin-develop/mensajes/{$message->id}")->assertOk()->assertDontSee('<script>alert(1)</script>', false);
        $this->assertTrue($message->fresh()->hasStatus('leido'));
        $this->get('/admin-develop/mensajes?estado=leido')->assertOk()->assertSee('Ana');
    }

    public function test_reordering_and_hiding_projects_affect_the_public_site(): void
    {
        $this->assertGreaterThanOrEqual(3, Project::count());
        $ids = Project::ordered()->pluck('id')->reverse()->values()->all();

        $this->postJson('/admin-develop/orden/projects', ['ids' => $ids])->assertOk();
        $this->assertSame($ids, Project::ordered()->pluck('id')->all());

        $first = Project::ordered()->first();
        $this->post("/admin-develop/visible/projects/{$first->id}");
        $this->assertFalse($first->fresh()->visible);

        $this->get('/proyectos')->assertOk()->assertDontSee($first->title);
    }

    public function test_reorder_rejects_unknown_resources(): void
    {
        $this->postJson('/admin-develop/orden/users', ['ids' => [1]])->assertNotFound();
    }

    public function test_stack_items_can_be_added_moved_to_new_categories_and_marked_as_studying(): void
    {
        $this->post('/admin-develop/tecnologias/categorias', ['name' => 'DevOps', 'description' => 'Infra']);
        $category = StackCategory::where('slug', 'devops')->firstOrFail();

        $this->post('/admin-develop/tecnologias/items', [
            'stack_category_id' => $category->id, 'name' => 'Kubernetes', 'level' => 'estudio', 'icon_url' => 'https://cdn.example.com/k8s.svg',
        ])->assertRedirect();
        $this->post('/admin-develop/tecnologias/items', [
            'stack_category_id' => $category->id, 'name' => 'Mala', 'level' => 'dominio', 'icon_url' => 'javascript:alert(1)',
        ])->assertSessionHasErrors('icon_url');

        $this->get('/stack')->assertOk()->assertSee('DevOps')->assertSee('Kubernetes')->assertSee('En estudio');
    }

    public function test_settings_update_links_and_stats(): void
    {
        $stats = [['value' => '5+', 'label' => 'Años'], ['value' => '9', 'label' => 'Proyectos'], ['value' => '3', 'label' => 'Apps'], ['value' => '100%', 'label' => 'Entregados']];

        $this->put('/admin-develop/ajustes', ['github' => 'https://github.com/otro', 'linkedin' => 'https://linkedin.com/in/otro', 'stats' => $stats])->assertSessionDoesntHaveErrors();
        $this->put('/admin-develop/ajustes', ['github' => 'javascript:alert(1)', 'linkedin' => 'https://x.com', 'stats' => $stats])->assertSessionHasErrors('github');

        $content = PortfolioContent::get();
        $this->assertSame('https://github.com/otro', $content['github']);
        $this->assertSame('5+', $content['stats'][0]['value']);
    }

    public function test_image_uploads_accept_images_only(): void
    {
        $this->post('/admin-dcc/imagenes', ['images' => [UploadedFile::fake()->image('foto.jpg', 600, 400)]])->assertSessionDoesntHaveErrors();
        $this->post('/admin-dcc/imagenes', ['images' => [UploadedFile::fake()->create('shell.php', 10, 'application/x-php')]])->assertSessionHasErrors('images.0');
        $this->post('/admin-dcc/imagenes', ['images' => [UploadedFile::fake()->create('x.svg', 10, 'image/svg+xml')]])->assertSessionHasErrors('images.0');

        $item = MediaItem::firstOrFail();
        $this->assertSame('dcc', $item->scope);
        Storage::disk('uploads')->assertExists(substr($item->path, strlen('uploads/')));

        $this->get('/dcc')->assertOk()->assertSee($item->url(), false);
        $this->post("/admin-dcc/visible/media/{$item->id}");
        $this->get('/dcc')->assertDontSee($item->url(), false);

        $this->delete("/admin-develop/imagenes/{$item->id}")->assertNotFound(); // otra área
        $this->delete("/admin-dcc/imagenes/{$item->id}");
        Storage::disk('uploads')->assertMissing(substr($item->path, strlen('uploads/')));
    }

    public function test_calendar_events_show_on_the_dcc_page_and_can_be_hidden(): void
    {
        $this->post('/admin-dcc/calendario', ['title' => 'Reunión general', 'type' => 'reunion', 'starts_on' => now()->addDays(3)->toDateString(), 'visible' => 1])->assertRedirect();
        $event = CalendarEvent::firstOrFail();

        $this->get('/dcc')->assertSee('Reunión general');

        $this->post("/admin-dcc/visible/events/{$event->id}");
        $this->get('/dcc')->assertDontSee('Reunión general');

        $this->post('/admin-dcc/calendario', ['title' => 'x', 'type' => 'otro', 'starts_on' => 'no-fecha'])->assertSessionHasErrors(['type', 'starts_on']);
    }

    public function test_certificates_accept_pdf_only(): void
    {
        $this->post('/admin-develop/certificados', [
            'title' => 'Curso X', 'platform' => 'Platzi', 'year' => '2026', 'category' => 'curso',
            'pdf' => UploadedFile::fake()->create('c.exe', 10, 'application/octet-stream'),
        ])->assertSessionHasErrors('pdf');

        $this->post('/admin-develop/certificados', [
            'title' => 'Curso X', 'platform' => 'Platzi', 'year' => '2026', 'category' => 'destacado',
            'pdf' => UploadedFile::fake()->create('c.pdf', 50, 'application/pdf'),
        ])->assertSessionDoesntHaveErrors();

        $this->get('/')->assertSee('Curso X');
    }

    public function test_project_links_are_validated(): void
    {
        $data = ['title' => 'P', 'description' => 'D', 'tags' => 'Laravel, PHP'];

        $this->post('/admin-develop/proyectos', $data + ['links' => 'Sitio | javascript:alert(1)'])->assertSessionHasErrors('links');
        $this->post('/admin-develop/proyectos', $data + ['links' => 'Sitio | https://ok.example | destacado'])->assertSessionDoesntHaveErrors();

        $project = Project::where('title', 'P')->firstOrFail();
        $this->assertSame([['label' => 'Sitio', 'url' => 'https://ok.example', 'featured' => true]], $project->links);
        $this->assertSame(['Laravel', 'PHP'], $project->tags);
    }
}
