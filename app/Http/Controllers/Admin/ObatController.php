<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama')->get();
        return view('admin.obat', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|min:2',
            'satuan'     => 'required|string',
            'stok'       => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);

        Obat::create($request->only(['nama', 'satuan', 'stok', 'harga_beli', 'harga_jual']));
        return back()->with('success', 'Obat berhasil ditambahkan.');
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama'       => 'required|string|min:2',
            'satuan'     => 'required|string',
            'stok'       => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);

        $obat->update([
            'nama'       => $request->nama,
            'satuan'     => $request->satuan,
            'stok'       => $request->stok,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'aktif'      => $request->boolean('aktif'),
        ]);

        return back()->with('success', 'Obat berhasil diupdate.');
    }

    public function tambahStok(Request $request, Obat $obat)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $obat->increment('stok', $request->jumlah);
        return back()->with('success', "Stok {$obat->nama} berhasil ditambah {$request->jumlah} {$obat->satuan}.");
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return back()->with('success', 'Obat berhasil dihapus.');
    }
}