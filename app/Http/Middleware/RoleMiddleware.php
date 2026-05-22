<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login. Jika belum, lempar ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user saat ini (di database) ada di dalam daftar role yang diizinkan rute
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request); // Lolos pengecekan, silakan masuk ke halaman
        }

        // 3. Jika user nekat masuk ke halaman yang bukan haknya, kunci dengan error 403
        abort(403, 'Maaf, Anda tidak memiliki hak akses untuk halaman ini.');
    }
}