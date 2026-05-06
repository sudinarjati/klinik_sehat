<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('karyawan_id')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $karyawan = Karyawan::where('username', $request->username)->first();

        if (!$karyawan || !Hash::check($request->password, $karyawan->password)) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['login' => 'Username atau password salah.']);
        }

        session([
            'karyawan_id'    => $karyawan->id,
            'karyawan_nama'  => $karyawan->nama_lengkap,
            'karyawan_peran' => $karyawan->peran,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $peran = session('karyawan_peran');

        return match($peran) {
            'pendaftaran' => redirect()->route('pendaftaran.index'),
            'dokter'      => redirect()->route('dokter.index'),
            'kasir'       => redirect()->route('kasir.index'),
            'apoteker'    => redirect()->route('apoteker.index'),
            default       => redirect()->route('login'),
        };
    }
}   