<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class KasirController extends Controller
{
    public function index()
    {
        $antreans = Antrian::with(['pemeriksaan', 'dokter', 'pembayaran'])
            ->whereDate('tanggal_kunjungan', today())
            ->where('status', 'menunggu_kasir')
            ->orderBy('nomor_antrian')
            ->get();

        return view('kasir.index', compact('antreans'));
    }

    public function tandaiLunas(Antrian $antrian)
    {
        $pembayaran = $antrian->pembayaran;

        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $pembayaran->update([
            'dibayar_pada' => now(),
            'kasir_id'     => session('karyawan_id'),
        ]);

        $antrian->update(['status' => 'menunggu_obat']);

        return redirect()->route('kasir.index')
            ->with('success', "Pembayaran {$antrian->nama_lengkap} berhasil dikonfirmasi.");
    }

    public function riwayat()
    {
        $antreans = Antrian::with(['pemeriksaan', 'dokter', 'pembayaran'])
            ->whereIn('status', ['menunggu_obat', 'selesai'])
            ->orderByDesc('tanggal_kunjungan')
            ->orderByDesc('nomor_antrian')
            ->paginate(20);

        return view('riwayat.kasir', compact('antreans'));
    }
}