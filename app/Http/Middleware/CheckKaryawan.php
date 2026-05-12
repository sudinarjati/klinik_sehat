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

        if (!empty($perans)) {
            $peranUser = session('karyawan_peran');

            // Pecah peran user jika double job (misal: pendaftaran_kasir)
            $peranUserList = explode('_', $peranUser);

            $bolehAkses = false;
            foreach ($perans as $p) {
                if (in_array($p, $peranUserList) || $peranUser === $p) {
                    $bolehAkses = true;
                    break;
                }
            }

            if (!$bolehAkses) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}