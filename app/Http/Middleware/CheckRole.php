<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request - Middleware untuk memeriksa role user
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed  ...$roles - Role yang diizinkan mengakses
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Cek apakah user aktif
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        // Jika tidak ada role yang dispesifikasi, izinkan akses untuk user yang sudah login
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah user memiliki salah satu role yang diizinkan
        foreach ($roles as $role) {
            if ($this->userHasRole($user, $role)) {
                return $next($request);
            }
        }

        // Jika user tidak memiliki akses, redirect dengan pesan error
        return redirect()->route('lottery.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    private function userHasRole($user, string $role): bool
    {
        switch ($role) {
            case 'super_admin':
                return $user->isSuperAdmin();
            case 'admin_undian':
                return $user->isAdminUndian();
            case 'admin_peserta':
                return $user->isAdminPeserta();
            case 'admin_hadiah':
                return $user->isAdminHadiah();
            default:
                return $user->role === $role;
        }
    }
}
