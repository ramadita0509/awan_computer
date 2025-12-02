<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        if (!Auth::user()->canAccessBackend()) {
            return redirect()->route('homepage')->with('error', 'Anda tidak memiliki akses ke halaman admin. Silakan hubungi administrator jika Anda memerlukan akses.');
        }

        return $next($request);
    }
}

