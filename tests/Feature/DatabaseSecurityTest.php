<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/** Fuzzing de payloads SQL/XSS contra cada formulario que escribe en la base de datos. */
class DatabaseSecurityTest extends TestCase
{
    use RefreshDatabase;

    private const PAYLOADS = [
        "' OR '1'='1",
        "'; DROP TABLE messages; --",
        '1; DELETE FROM users',
        '" UNION SELECT username,password FROM users --',
        "admin'/*",
        "1' AND SLEEP(5)#",
        '<script>alert(1)</script>',
        '<img src=x onerror=alert(1)>',
        'javascript:alert(1)',
        '%27%20OR%201=1',
        "\x00",
    ];

    /** endpoint => [método, campos de texto] */
    private const ENDPOINTS = [
        '/admin-develop/proyectos' => ['post', ['title', 'company', 'url', 'github', 'description', 'tags', 'links']],
        '/admin-develop/certificados' => ['post', ['title', 'platform', 'year', 'category']],
        '/admin-develop/tecnologias/categorias' => ['post', ['name', 'description']],
        '/admin-develop/tecnologias/items' => ['post', ['name', 'type', 'level', 'icon_url', 'stack_category_id']],
        '/admin-develop/ajustes' => ['put', ['github', 'linkedin']],
        '/admin-develop/blogs' => ['post', ['title', 'slug', 'excerpt', 'content', 'category', 'video_url', 'meta_title', 'meta_description', 'keywords']],
        '/admin-dcc/blogs' => ['post', ['title', 'slug', 'excerpt', 'content', 'category', 'video_url', 'meta_title', 'meta_description', 'keywords']],
        '/admin-dcc/calendario' => ['post', ['title', 'description', 'type', 'starts_on', 'location']],
        '/admin-develop/mensajes/masivo' => ['post', ['ids', 'action', 'status']],
        '/admin-develop/blogs/seo' => ['post', ['title', 'content']],
    ];

    private function admin(): User
    {
        return User::factory()->create(['username' => 'eslopezm', 'password' => 'Clave-De-Prueba-2026!', 'is_admin' => true]);
    }

    private function assertSchemaIntact(): void
    {
        foreach (['users', 'messages', 'posts', 'projects', 'settings'] as $table) {
            $this->assertTrue(Schema::hasTable($table), "La tabla {$table} desapareció.");
        }
        $this->assertSame(1, User::count(), 'Cambió el número de usuarios.');
    }

    public function test_admin_forms_never_error_or_alter_schema_with_hostile_input(): void
    {
        $this->actingAs($this->admin());

        foreach (self::ENDPOINTS as $url => [$method, $fields]) {
            foreach (self::PAYLOADS as $payload) {
                $response = $this->from('/x')->{$method}($url, array_fill_keys($fields, $payload));

                $this->assertLessThan(500, $response->getStatusCode(), "500 en {$url} con payload: ".json_encode($payload));
                $this->assertSchemaIntact();
            }
        }
    }

    public function test_hostile_html_is_sanitized_before_it_is_stored(): void
    {
        $this->actingAs($this->admin());

        $this->post('/admin-develop/blogs', [
            'title' => 'Prueba XSS', 'excerpt' => 'x', 'category' => array_key_first(config('admin.post_categories.develop')), 'published' => 1,
            'content' => '<p>Hola</p><script>alert(1)</script><img src=x onerror=alert(1)><a href="javascript:alert(1)">x</a>',
        ]);

        $post = Post::first();
        $this->assertNotNull($post, 'El post debía crearse.');
        $this->assertStringNotContainsString('<script', strtolower($post->content));
        $this->assertStringNotContainsString('onerror', strtolower($post->content));
        $this->assertStringNotContainsString('javascript:', strtolower($post->content));
    }

    public function test_contact_form_rejects_every_sql_payload_and_stores_nothing(): void
    {
        foreach (self::PAYLOADS as $payload) {
            foreach (['nombre', 'asunto', 'mensaje', 'email', 'phone_number'] as $field) {
                $body = [
                    'nombre' => 'Ana', 'email' => 'ana@example.com', 'asunto' => 'Hola',
                    'phone_country_iso' => 'CO', 'phone_country_code' => '+57', 'phone_number' => '3001234567',
                    'mensaje' => 'Quiero cotizar un proyecto en Laravel.',
                ];
                $body[$field] = $payload;

                $this->assertLessThan(500, $this->post('/contacto', $body)->getStatusCode());
            }
        }

        $this->assertSame(0, Message::count(), 'Un payload hostil se guardó en la base de datos.');
        $this->assertTrue(Schema::hasTable('messages'));
    }

    public function test_contact_form_stores_legit_text_with_quotes_literally(): void
    {
        $this->post('/contacto', [
            'nombre' => "Santiago O'Brien", 'email' => 'ana@example.com', 'asunto' => 'Cotización',
            'phone_country_iso' => 'CO', 'phone_country_code' => '+57', 'phone_number' => '3001234567',
            'mensaje' => 'Necesito un sitio con login y base de datos, ¿cuánto cuesta? Gracias.',
        ])->assertSessionHas('success');

        $this->assertSame("Santiago O'Brien", Message::first()->nombre);
    }

    public function test_every_admin_write_endpoint_requires_authentication(): void
    {
        foreach (self::ENDPOINTS as $url => [$method]) {
            $this->{$method}($url, ['title' => 'x'])->assertRedirect('/login');
        }
    }

    public function test_login_fails_closed_without_recaptcha_in_production(): void
    {
        $this->admin();
        $this->withSession(['_token' => 't']);
        $this->app['env'] = 'production';
        config(['services.recaptcha.secret_key' => null, 'services.recaptcha.site_key' => null]);

        $this->from('/login')->post('/login', ['username' => 'eslopezm', 'password' => 'Clave-De-Prueba-2026!', '_token' => 't'])
            ->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_contact_fails_closed_without_recaptcha_in_production(): void
    {
        $this->withSession(['_token' => 't']);
        $this->app['env'] = 'production';
        config(['services.recaptcha.secret_key' => null, 'services.recaptcha.site_key' => null]);

        $r = $this->post('/contacto', [
            'nombre' => 'Ana', 'email' => 'ana@example.com', 'phone_country_iso' => 'CO', 'phone_country_code' => '+57',
            'phone_number' => '3001234567', 'mensaje' => 'Quiero cotizar un proyecto en Laravel.', '_token' => 't',
        ]);
        $r->assertSessionHasErrors('recaptcha');
        $this->assertSame(0, Message::count());
    }
}
