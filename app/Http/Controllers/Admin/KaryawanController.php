<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::orderBy('peran')->orderBy('nama_lengkap')->get();
        return view('admin.karyawan', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|min:2',
            'username'     => 'required|string|min:3|regex:/^\S+$/|unique:karyawans,username',
            'password'     => 'required|string|min:6',
            'peran'        => 'required|in:pendaftaran,dokter,kasir,apoteker,pendaftaran_kasir',
        ], [
            'username.regex'  => 'Username tidak boleh mengandung spasi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min'    => 'Password minimal 6 karakter.',
        ]);

        // Langsung hash di sini, jangan pakai model mutator
        Karyawan::withoutEvents(function() use ($request) {
            \DB::table('karyawans')->insert([
                'nama_lengkap' => $request->nama_lengkap,
                'username'     => $request->username,
                'password'     => Hash::make($request->password),
                'peran'        => $request->peran,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        });

        return back()->with('success', "Karyawan {$request->nama_lengkap} berhasil ditambahkan.");
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|min:2',
            'username'     => 'required|string|min:3|regex:/^\S+$/|unique:karyawans,username,' . $karyawan->id,
            'peran'        => 'required|in:pendaftaran,dokter,kasir,apoteker,pendaftaran_kasir',
            'password'     => 'nullable|string|min:6',
        ], [
            'username.regex'  => 'Username tidak boleh mengandung spasi.',
            'username.unique' => 'Username sudah digunakan karyawan lain.',
            'password.min'    => 'Password minimal 6 karakter.',
        ]);

        \DB::table('karyawans')->where('id', $karyawan->id)->update(array_filter([
            'nama_lengkap' => $request->nama_lengkap,
            'username'     => $request->username,
            'peran'        => $request->peran,
            'password'     => $request->filled('password') ? Hash::make($request->password) : null,
            'updated_at'   => now(),
        ], fn($v) => $v !== null));

        return back()->with('success', "Data karyawan {$request->nama_lengkap} berhasil diupdate.");
    }

    public function destroy(Karyawan $karyawan)
    {
        $nama = $karyawan->nama_lengkap;
        $karyawan->delete();
        return back()->with('success', "Karyawan {$nama} berhasil dihapus.");
    }
}