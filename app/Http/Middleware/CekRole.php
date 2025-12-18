<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!session('login')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu!');
        }

        // Ambil role dari session
        $userRole = session('role');

        // Cek apakah role user ada dalam daftar roles yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Redirect berdasarkan role yang dimiliki
            if ($userRole == 'dosen') {
                return redirect('/dosen/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            } elseif ($userRole == 'mahasiswa') {
                return redirect('/mahasiswa/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            } else {
                return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
            }
        }

        return $next($request);
    }
}



