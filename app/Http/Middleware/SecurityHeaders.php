<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    private const PRIVATE_PATHS = ['login', 'logout', 'admin', 'admin/*', 'admin-dcc', 'admin-dcc/*', 'admin-develop', 'admin-develop/*'];

    public function handle(Request $request, Closure $next): Response
    {
        $nonce = base64_encode(random_bytes(16));
        view()->share('cspNonce', $nonce);

        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        if (! $request->is(...self::PRIVATE_PATHS) && ! $request->is('files/*')) {
            $response->headers->set('Content-Security-Policy', implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'nonce-{$nonce}' https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/",
                "frame-src 'self' https://www.google.com/recaptcha/ https://recaptcha.google.com/recaptcha/ https://www.google.com/maps/ https://calendar.google.com https://www.youtube-nocookie.com https://player.vimeo.com",
                "connect-src 'self' https://www.google.com/recaptcha/",
                "img-src 'self' data: https:",
                "media-src 'self'",
                "style-src 'self' 'unsafe-inline'",
                "font-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'self'",
            ]));
        }

        if ($request->is(...self::PRIVATE_PATHS)) {
            $response->headers->set('Content-Security-Policy', implode('; ', [
                "default-src 'self'",
                "script-src 'self' https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/",
                'frame-src https://www.google.com/recaptcha/ https://recaptcha.google.com/recaptcha/',
                "connect-src 'self' https://www.google.com/recaptcha/",
                "img-src 'self' data: https:",
                "media-src 'self'",
                "style-src 'self' 'unsafe-inline'",
                "font-src 'self'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'none'",
            ]));
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');
            $response->headers->set('Cache-Control', 'no-store, private');
        }

        return $response;
    }
}
