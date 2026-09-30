<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Fija el área del panel ("dcc" o "develop") para los controladores compartidos. */
class SetAdminArea
{
    public function handle(Request $request, Closure $next, string $area): Response
    {
        $request->route()->setParameter('area', $area);

        return $next($request);
    }
}
