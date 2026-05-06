<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alkes;

class AlkesController extends Controller
{
    public function index()
    {
        $alkes = Alkes::orderBy('nama')->get();
        return view('admin.alkes', compact('alkes'));
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

        Alkes::create($request->only(['nama', 'satuan', 'stok', 'harga_beli', 'harga_jual']));
        return back()->with('success', 'Alkes berhasil ditambahkan.');
    }

    public function update(Request $request, Alkes $alkes)
    {
        $request->validate([
            'nama'       => 'required|string|min:2',
            'satuan'     => 'required|string',
            'stok'       => 'required|integer|min:0',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
        ]);

        $alkes->update([
            'nama'       => $request->nama,
            'satuan'     => $request->satuan,
            'stok'       => $request->stok,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'aktif'      => $request->boolean('aktif'),
        ]);

        return back()->with('success', 'Alkes berhasil diupdate.');
    }

    public function tambahStok(Request $request, Alkes $alkes)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $alkes->increment('stok', $request->jumlah);
        return back()->with('success', "Stok {$alkes->nama} berhasil ditambah {$request->jumlah} {$alkes->satuan}.");
    }

    public function destroy(Alkes $alkes)
    {
        $alkes->delete();
        return back()->with('success', 'Alkes berhasil dihapus.');
    }
}