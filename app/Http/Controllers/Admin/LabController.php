<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lab;

class LabController extends Controller
{
    public function index()
    {
        $labs = Lab::orderBy('nama')->get();
        return view('admin.lab', compact('labs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|min:2',
            'harga' => 'required|integer|min:0',
        ]);

        Lab::create([
            'nama'  => $request->nama,
            'harga' => $request->harga,
        ]);

        return back()->with('success', 'Pemeriksaan lab berhasil ditambahkan.');
    }

    public function update(Request $request, Lab $lab)
    {
        $request->validate([
            'nama'  => 'required|string|min:2',
            'harga' => 'required|integer|min:0',
        ]);

        $lab->update([
            'nama'  => $request->nama,
            'harga' => $request->harga,
            'aktif' => $request->boolean('aktif'),
        ]);

        return back()->with('success', 'Pemeriksaan lab berhasil diupdate.');
    }

    public function destroy(Lab $lab)
    {
        $lab->delete();
        return back()->with('success', 'Pemeriksaan lab berhasil dihapus.');
    }
}