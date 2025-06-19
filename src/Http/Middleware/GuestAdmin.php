<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {
        if (Auth::guard($guard)->check()) {
            // Jika sudah login sebagai admin, redirect ke dashboard (atau halaman lain)
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
