<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan apakah status is_admin bernilai 1 (mendukung integer maupun string)
        if (auth()->check() && (int) auth()->user()->is_admin === 1) {
            return $next($request);
        }

        // Jika bukan admin atau belum login, logout paksa dan kembalikan ke halaman login dengan pesan error
        auth()->logout();
        return redirect()->route('login')->withErrors([
            'email' => 'Akses ditolak! Akun Anda bukan Administrator.',
        ]);
    }
}