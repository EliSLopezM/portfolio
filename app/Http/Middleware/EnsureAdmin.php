<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->is_admin) {
            return redirect()->route('login');
        }

        $idle = config('admin.idle_minutes') * 60;
        $last = (int) $request->session()->get('admin_last_activity', time());

        if (time() - $last > $idle) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['username' => 'Tu sesión expiró por inactividad.']);
        }

        $request->session()->put('admin_last_activity', time());

        return $next($request);
    }
}
