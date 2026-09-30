<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\RejectSqlInjection;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetAdminArea;
use App\Services\PostEngagement;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Detrás de un proxy (Railway, Nginx, Cloudflare) para leer bien IP y https.
        if ($proxies = env('TRUSTED_PROXIES')) {
            $middleware->trustProxies(at: $proxies === '*' ? '*' : explode(',', $proxies));
        }

        // Solo contiene IDs de blogs ya marcados con «me gusta»: no es un dato sensible.
        $middleware->encryptCookies(except: [PostEngagement::LIKE_COOKIE]);

        $middleware->web(append: [SecurityHeaders::class]);

        $middleware->alias([
            'admin' => EnsureAdmin::class,
            'area' => SetAdminArea::class,
            'sqlguard' => RejectSqlInjection::class,
        ]);

        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
