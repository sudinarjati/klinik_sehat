<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckKaryawan
{
    public function handle(Request $request, Closure $next, string ...$perans): Response
    {
        if (!session()->has('karyawan_id')) {
            return redirect()->route('login');
        }

        if (!empty($perans) && !in_array(session('karyawan_peran'), $perans)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}