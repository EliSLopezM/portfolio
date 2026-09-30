<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class LoginSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['username' => 'eslopezm', 'password' => 'Clave-De-Prueba-2026!', 'is_admin' => true]);
    }

    private function attempt(array $override = [])
    {
        return $this->from('/login')->post('/login', $override + ['username' => 'eslopezm', 'password' => 'Clave-De-Prueba-2026!']);
    }

    public function test_login_page_has_security_headers_and_is_not_indexable(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $this->assertStringContainsString("frame-ancestors 'none'", $response->headers->get('Content-Security-Policy'));
    }

    public function test_guests_are_redirected_from_every_admin_area(): void
    {
        foreach (['/admin', '/admin-dcc', '/admin-develop', '/admin-develop/mensajes', '/admin-dcc/calendario'] as $path) {
            $this->get($path)->assertRedirect('/login');
        }
    }

    public function test_valid_credentials_open_the_dashboard(): void
    {
        $this->admin();

        $this->attempt()->assertRedirect('/admin');
        $this->get('/admin')->assertOk();
    }

    public function test_wrong_password_gives_a_generic_error(): void
    {
        $this->admin();

        $this->attempt(['password' => 'incorrecta'])->assertSessionHasErrors(['username' => 'Credenciales inválidas.']);
        $this->attempt(['username' => 'noexiste'])->assertSessionHasErrors(['username' => 'Credenciales inválidas.']);
        $this->assertGuest();
    }

    public function test_account_locks_after_too_many_failures(): void
    {
        $this->admin();

        for ($i = 0; $i < 5; $i++) {
            $this->attempt(['password' => 'mala']);
        }

        $this->attempt()->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_non_admin_users_cannot_log_in(): void
    {
        User::factory()->create(['username' => 'otro', 'password' => 'Clave-De-Prueba-2026!', 'is_admin' => false]);

        $this->attempt(['username' => 'otro'])->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_sql_payloads_are_rejected_in_the_login_fields(): void
    {
        $this->admin();

        foreach (["admin' OR '1'='1", "eslopezm'--", "x'; DROP TABLE users;--", 'a" UNION SELECT 1'] as $payload) {
            RateLimiter::clear('sqli-block:127.0.0.1');
            $this->attempt(['username' => $payload])->assertSessionHasErrors('username');
        }
        $this->assertGuest();
    }

    public function test_repeated_sql_payloads_get_the_ip_blocked_temporarily(): void
    {
        $this->admin();

        foreach (range(1, 3) as $_) {
            $this->attempt(['username' => "x' OR '1'='1"])->assertSessionHasErrors('username');
        }

        $this->attempt()->assertStatus(429);
    }

    public function test_honeypot_blocks_bots(): void
    {
        $this->admin();

        $this->attempt(['website' => 'http://spam'])->assertSessionHasErrors('website');
        $this->assertGuest();
    }

    public function test_recaptcha_is_enforced_when_configured(): void
    {
        $this->admin();
        config(['services.recaptcha.secret_key' => 'secret']);

        $reply = ['success' => true, 'score' => 0.1, 'action' => 'login'];
        Http::fake(function () use (&$reply) {
            return Http::response($reply);
        });

        $this->attempt(['g-recaptcha-response' => 'token'])->assertSessionHasErrors('username'); // puntaje bajo
        $this->attempt()->assertSessionHasErrors('username'); // sin token

        $reply = ['success' => true, 'score' => 0.9, 'action' => 'contact'];
        $this->attempt(['g-recaptcha-response' => 'token'])->assertSessionHasErrors('username'); // acción equivocada
        $this->assertGuest();

        $reply = ['success' => true, 'score' => 0.9, 'action' => 'login'];
        RateLimiter::clear('login:eslopezm|127.0.0.1');
        RateLimiter::clear('login-ip:127.0.0.1');
        $this->attempt(['g-recaptcha-response' => 'token'])->assertRedirect('/admin');
    }

    public function test_login_fails_closed_in_production_without_recaptcha_keys(): void
    {
        $this->admin();
        $this->app['env'] = 'production';

        $this->withoutMiddleware(ValidateCsrfToken::class)
            ->attempt()->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_session_expires_after_inactivity(): void
    {
        $this->actingAs($this->admin())->withSession(['admin_last_activity' => time() - 3600])
            ->get('/admin')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_logout_requires_post_and_ends_the_session(): void
    {
        $this->actingAs($this->admin())->withSession(['admin_last_activity' => time()]);

        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_contact_form_rejects_sql_payloads_and_stores_nothing(): void
    {
        $this->post('/contacto', [
            'nombre' => 'Mallory', 'email' => 'm@example.com', 'phone_country_iso' => 'CO', 'phone_country_code' => '+57',
            'phone_number' => '3001234567', 'mensaje' => "hola'; DROP TABLE messages; --",
        ])->assertSessionHasErrors('mensaje');

        $this->assertSame(0, Message::count());
    }

    public function test_valid_contact_message_is_stored_with_empty_statuses(): void
    {
        $this->post('/contacto', [
            'nombre' => 'Ana', 'email' => 'ana@example.com', 'phone_country_iso' => 'CO', 'phone_country_code' => '+57',
            'phone_number' => '3001234567', 'mensaje' => 'Hola, quiero cotizar un proyecto en Laravel.',
        ])->assertSessionHas('success');

        $this->assertTrue(Message::first()->isUnread());
    }
}
