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
            'nama'        => 'required|string',
            'satuan_beli' => 'required|string',
            'satuan_jual' => 'required|string',
            'konversi'    => 'required|integer|min:1',
            'stok'        => 'required|integer|min:0',
            'harga_beli'  => 'required|integer|min:0',
            'harga_jual'  => 'required|integer|min:0',
        ]);

        // Stok disimpan dalam satuan JUAL
        $stokJual = $request->stok * $request->konversi;

        \DB::table('obats')->insert([
            'nama'        => $request->nama,
            'satuan'      => $request->satuan_jual,
            'satuan_beli' => $request->satuan_beli,
            'satuan_jual' => $request->satuan_jual,
            'konversi'    => $request->konversi,
            'stok'        => $stokJual,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'aktif'       => true,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return back()->with('success', "Obat {$request->nama} berhasil ditambahkan. Stok: {$stokJual} {$request->satuan_jual}.");
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama'        => 'required|string',
            'satuan_beli' => 'required|string',
            'satuan_jual' => 'required|string',
            'konversi'    => 'required|integer|min:1',
            'stok'        => 'required|integer|min:0',
            'harga_beli'  => 'required|integer|min:0',
            'harga_jual'  => 'required|integer|min:0',
            'aktif'       => 'required|boolean',
        ]);

        \DB::table('obats')->where('id', $obat->id)->update([
            'nama'        => $request->nama,
            'satuan'      => $request->satuan_jual,
            'satuan_beli' => $request->satuan_beli,
            'satuan_jual' => $request->satuan_jual,
            'konversi'    => $request->konversi,
            'stok'        => $request->stok,
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'aktif'       => $request->aktif,
            'updated_at'  => now(),
        ]);

        return back()->with('success', "Obat {$obat->nama} berhasil diupdate.");
    }

    public function tambahStok(Request $request, Obat $obat)
    {
        $request->validate([
            'jumlah'       => 'required|integer|min:1',
            'satuan_input' => 'required|in:beli,jual',
        ]);

        // Jika input dalam satuan beli → konversi ke satuan jual
        $tambah = $request->satuan_input === 'beli'
            ? $request->jumlah * ($obat->konversi ?? 1)
            : $request->jumlah;

        $obat->increment('stok', $tambah);

        $satuanJual = $obat->satuan_jual ?? $obat->satuan;
        return back()->with('success', "Stok {$obat->nama} bertambah {$tambah} {$satuanJual}.");
    }

    public function destroy(Obat $obat)
    {
        $nama = $obat->nama;
        $obat->delete();
        return back()->with('success', "Obat {$nama} berhasil dihapus.");
    }
}