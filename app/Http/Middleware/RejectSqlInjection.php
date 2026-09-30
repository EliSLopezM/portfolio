<?php

namespace App\Http\Middleware;

use App\Services\SqlInjectionGuard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rechaza peticiones con cargas SQL en cualquier campo.
 * Uso: `sqlguard` o `sqlguard:content,otro_campo` para excluir campos de texto enriquecido
 * (ese contenido se sanitiza con HTMLPurifier y nunca se concatena en consultas).
 */
class RejectSqlInjection
{
    private const SKIP = ['_token', '_method', 'g-recaptcha-response', 'password', 'password_confirmation'];

    public function handle(Request $request, Closure $next, string ...$exempt): Response
    {
        if (! $request->isMethodSafe()) {
            $blockKey = 'sqli-block:'.$request->ip();

            if (RateLimiter::tooManyAttempts($blockKey, 3)) {
                abort(429, 'Demasiados intentos. Inténtalo más tarde.');
            }

            $field = SqlInjectionGuard::findInArray($request->except(array_merge(self::SKIP, $exempt)), self::SKIP);

            if ($field !== null) {
                RateLimiter::hit($blockKey, 900);
                Log::warning('Petición bloqueada por patrón SQL.', ['ip' => $request->ip(), 'path' => $request->path(), 'field' => $field]);

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'El contenido enviado no es válido.'], 422);
                }

                return back()->withInput($request->except(array_merge(self::SKIP, [$field])))
                    ->withErrors([$field => 'El contenido enviado no es válido.']);
            }
        }

        return $next($request);
    }
}
