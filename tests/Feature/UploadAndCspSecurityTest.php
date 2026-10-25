<?php

namespace Tests\Feature;

use App\Models\MediaItem;
use App\Models\StoredFile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadAndCspSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): void
    {
        $this->actingAs(User::factory()->create(['username' => 'eslopezm', 'password' => 'Clave-De-Prueba-2026!', 'is_admin' => true]));
    }

    public function test_dangerous_files_are_rejected_as_gallery_images(): void
    {
        $this->admin();

        $bad = [
            UploadedFile::fake()->createWithContent('shell.php', '<?php system($_GET["c"]); ?>'),
            UploadedFile::fake()->createWithContent('shell.jpg', '<?php system($_GET["c"]); ?>'),
            UploadedFile::fake()->createWithContent('x.svg', '<svg xmlns="http://www.w3.org/2000/svg"><script>alert(1)</script></svg>'),
            UploadedFile::fake()->createWithContent('x.html', '<script>alert(1)</script>'),
            UploadedFile::fake()->create('big.png', 99999, 'image/png'),
        ];

        foreach ($bad as $file) {
            $this->post('/admin-develop/imagenes', ['images' => [$file]])->assertSessionHasErrors();
        }

        $this->assertSame(0, MediaItem::count());
        $this->assertSame(0, StoredFile::count());
    }

    public function test_valid_image_is_reencoded_and_served_safely(): void
    {
        $this->admin();
        $this->post('/admin-develop/imagenes', ['images' => [UploadedFile::fake()->image('ok.png', 600, 400)]])->assertSessionHasNoErrors();

        $item = MediaItem::first();
        $this->assertNotNull($item);
        $name = basename($item->path);
        $response = $this->get('/files/'.$name);

        $response->assertOk();
        $this->assertSame('image/webp', $response->headers->get('Content-Type'));
        $this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertStringContainsString('sandbox', $response->headers->get('Content-Security-Policy'));
    }

    public function test_file_endpoint_rejects_path_traversal_and_sql_in_name(): void
    {
        foreach (['../.env', '..%2F.env', "x' OR '1'='1", str_repeat('a', 40).'.php'] as $name) {
            $this->get('/files/'.$name)->assertNotFound();
        }
    }

    public function test_public_pages_send_csp_with_nonce_and_no_inline_handlers(): void
    {
        foreach (['/', '/contacto', '/blog', '/dcc', '/dcc/contacto'] as $path) {
            $response = $this->get($path)->assertOk();
            $csp = $response->headers->get('Content-Security-Policy');

            $this->assertNotNull($csp, "Sin CSP en {$path}");
            $this->assertStringContainsString("object-src 'none'", $csp);
            $this->assertStringNotContainsString("script-src 'self' 'unsafe-inline'", $csp);
            $this->assertStringNotContainsString('googleapis', $csp);
            $this->assertDoesNotMatchRegularExpression('/\son(click|error|load)=/i', $response->getContent(), "Handler inline en {$path}");
            $this->assertStringNotContainsString('fonts.googleapis.com', $response->getContent());
            $this->assertDoesNotMatchRegularExpression('/<(link|script)[^>]+jsdelivr/i', $response->getContent());
        }
    }

    public function test_inline_scripts_carry_the_request_nonce(): void
    {
        config(['services.recaptcha.site_key' => 'site-key-de-prueba']);
        $response = $this->get('/contacto')->assertOk();

        preg_match("/'nonce-([^']+)'/", $response->headers->get('Content-Security-Policy'), $m);
        $this->assertNotEmpty($m[1] ?? null);
        $this->assertStringContainsString('<script nonce="'.$m[1].'">', $response->getContent());
    }
}
