<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (! Auth::check()) {
            return redirect('/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // 2. Cek apakah akun aktif
        if (Auth::user()->status !== 'aktif') {
            Auth::logout();

            return redirect('/login')->with('error', 'Akun Anda dinonaktifkan. Hubungi Admin.');
        }

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 4. Jika role tidak sesuai, lempar kembali ke dashboard masing-masing
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect('/admin/dashboard');
        }
        if ($role === 'operator') {
            return redirect('/operator/dashboard');
        }

        return redirect('/user/dashboard');
    }
}
