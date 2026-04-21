<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login
        if (!auth()->check()) {
            abort(403, 'Akses ditolak');
        }

        $user = auth()->user();

        // Cek role administrator
        if (strtolower($user->role) === 'administrator') {
            return $next($request);
        }

        // Jika bukan administrator
        abort(403, 'Akses ditolak');
    }
}