<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class ApotekerController extends Controller
{
    public function index()
    {
        $antreans = Antrian::with(['pemeriksaan', 'dokter', 'pembayaran'])
            ->whereDate('tanggal_kunjungan', today())
            ->where('status', 'menunggu_obat')
            ->orderBy('nomor_antrian')
            ->get();

        return view('apoteker.index', compact('antreans'));
    }

    public function serahkan(Antrian $antrian)
    {
        if ($antrian->status !== 'menunggu_obat') {
            return back()->with('error', 'Pasien belum membayar atau sudah selesai.');
        }

        // Kurangi stok obat sesuai resep
        $pemeriksaan = $antrian->pemeriksaan;
        if ($pemeriksaan && !empty($pemeriksaan->resep_obat)) {
            foreach ($pemeriksaan->resep_obat as $item) {
                $obat = \App\Models\Obat::where('nama', $item['nama_obat'])->first();
                if ($obat) {
                    $obat->decrement('stok', $item['jumlah']);
                }
            }
        }

        $antrian->update(['status' => 'selesai']);

        return redirect()->route('apoteker.index')
            ->with('success', "Obat untuk {$antrian->nama_lengkap} berhasil diserahkan.");
    }

    public function riwayat()
    {
        $antreans = Antrian::with(['pemeriksaan', 'dokter'])
            ->where('status', 'selesai')
            ->orderByDesc('tanggal_kunjungan')
            ->orderByDesc('nomor_antrian')
            ->paginate(20);

        return view('riwayat.apoteker', compact('antreans'));
    }
}