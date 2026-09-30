<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RecaptchaVerifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LoginController extends Controller
{
    private const FAILURE = 'Credenciales inválidas.';

    public function show(Request $request): View|RedirectResponse
    {
        if ($request->user()?->is_admin) {
            return redirect()->route('admin.index');
        }

        return view('auth.login');
    }

    public function store(Request $request, RecaptchaVerifier $recaptcha): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9._-]+$/'],
            'password' => ['required', 'string', 'max:200'],
            'website' => ['nullable', 'size:0'], // honeypot
        ], ['username.regex' => 'El usuario contiene caracteres no permitidos.']);

        $ip = $request->ip();
        $userKey = 'login:'.Str::lower($data['username']).'|'.$ip;
        $ipKey = 'login-ip:'.$ip;

        if (RateLimiter::tooManyAttempts($userKey, config('admin.max_attempts')) || RateLimiter::tooManyAttempts($ipKey, 20)) {
            $seconds = max(RateLimiter::availableIn($userKey), RateLimiter::availableIn($ipKey));

            return back()->withErrors(['username' => 'Demasiados intentos. Inténtalo de nuevo en '.ceil($seconds / 60).' min.'])
                ->onlyInput('username');
        }

        if (! $this->passesRecaptcha($request, $recaptcha)) {
            $this->registerFailure($userKey, $ipKey);

            return back()->withErrors(['username' => 'No pudimos verificar que eres humano. Recarga la página e inténtalo de nuevo.'])
                ->onlyInput('username');
        }

        $user = User::where('username', $data['username'])->where('is_admin', true)->first();

        // Se compara siempre contra un hash para no revelar por tiempos si el usuario existe.
        $valid = Hash::check($data['password'], $user->password ?? $this->dummyHash());

        if (! $user || ! $valid) {
            $this->registerFailure($userKey, $ipKey);
            Log::warning('Login de administrador fallido.', ['ip' => $ip, 'username' => Str::limit($data['username'], 50)]);

            return back()->withErrors(['username' => self::FAILURE])->onlyInput('username');
        }

        RateLimiter::clear($userKey);
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('admin_last_activity', time());

        Log::info('Login de administrador correcto.', ['user' => $user->username, 'ip' => $ip]);

        return redirect()->intended(route('admin.index'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function passesRecaptcha(Request $request, RecaptchaVerifier $recaptcha): bool
    {
        if ($recaptcha->bypassed()) {
            return true;
        }

        if (! $recaptcha->configured()) {
            // Sin claves solo se permite en local; en producción el login falla cerrado.
            return app()->environment('local', 'testing');
        }

        return $recaptcha->verify($request->input('g-recaptcha-response'), 'login', $request->ip())['ok'];
    }

    private function registerFailure(string $userKey, string $ipKey): void
    {
        RateLimiter::hit($userKey, config('admin.lockout_minutes') * 60);
        RateLimiter::hit($ipKey, config('admin.lockout_minutes') * 60);
    }

    private function dummyHash(): string
    {
        static $hash = null;

        return $hash ??= Hash::make(Str::random(32));
    }
}
