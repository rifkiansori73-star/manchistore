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
        // Cek apakah user sudah login DAN apakah dia admin
        // (Pastikan di database tabel users Anda ada kolom 'is_admin' dengan nilai 1 untuk admin)
        if (auth()->check() && auth()->user()->is_admin == 1) {
            return $next($request);
        }

        // Jika bukan admin atau belum login, tendang ke halaman utama
        return redirect('/')->with('error', 'Akses ditolak! Khusus Administrator.');
    }
}