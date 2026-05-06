<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tindakan;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakans = Tindakan::orderBy('nama')->get();
        return view('admin.tindakan', compact('tindakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|min:2',
            'harga' => 'required|integer|min:0',
        ]);

        Tindakan::create([
            'nama'  => $request->nama,
            'harga' => $request->harga,
        ]);

        return back()->with('success', 'Tindakan berhasil ditambahkan.');
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $request->validate([
            'nama'  => 'required|string|min:2',
            'harga' => 'required|integer|min:0',
        ]);

        $tindakan->update([
            'nama'  => $request->nama,
            'harga' => $request->harga,
            'aktif' => $request->boolean('aktif'),
        ]);

        return back()->with('success', 'Tindakan berhasil diupdate.');
    }

    public function destroy(Tindakan $tindakan)
    {
        $tindakan->delete();
        return back()->with('success', 'Tindakan berhasil dihapus.');
    }
}