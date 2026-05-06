<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withInput($request->only('username'))
                ->withErrors(['login' => 'Username atau password salah.']);
        }

        session([
            'admin_id'   => $admin->id,
            'admin_nama' => $admin->nama_lengkap,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_nama']);
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalObat     = \App\Models\Obat::count();
        $totalAlkes    = \App\Models\Alkes::count();
        $totalTindakan = \App\Models\Tindakan::count();
        $totalLab      = \App\Models\Lab::count();
        $stokMenipisObat  = \App\Models\Obat::where('stok', '<=', 10)->get();
        $stokMenipisAlkes = \App\Models\Alkes::where('stok', '<=', 10)->get();

        return view('admin.dashboard', compact(
            'totalObat', 'totalAlkes', 'totalTindakan', 'totalLab',
            'stokMenipisObat', 'stokMenipisAlkes'
        ));
    }
}