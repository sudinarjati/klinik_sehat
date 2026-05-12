<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Pemeriksaan;
use App\Models\Pembayaran;
use App\Models\Tindakan;
use App\Models\Lab;
use App\Models\Obat;

class DokterController extends Controller
{
    public function index()
    {
        $antreans = Antrian::whereDate('tanggal_kunjungan', today())
            ->whereIn('status', ['menunggu_dokter', 'dipanggil_dokter', 'sedang_diperiksa'])
            ->orderBy('nomor_antrian')
            ->get();

        return view('dokter.index', compact('antreans'));
    }

    public function panggil(Antrian $antrian)
    {
        $antrian->update([
            'status'    => 'dipanggil_dokter',
            'dokter_id' => session('karyawan_id'),
        ]);

        return redirect()->route('dokter.index')
            ->with('success', "Pasien {$antrian->nama_lengkap} dipanggil.");
    }

    public function periksa(Antrian $antrian)
    {
        $antrian->update([
            'status'    => 'sedang_diperiksa',
            'dokter_id' => session('karyawan_id'),
        ]);

        return redirect()->route('dokter.form', $antrian->id);
    }

    public function form(Antrian $antrian)
    {
        $pemeriksaan  = $antrian->pemeriksaan;
        $tindakanList = Tindakan::where('aktif', true)->orderBy('nama')->get();
        $labList      = Lab::where('aktif', true)->orderBy('nama')->get();
        $obatList = Obat::where('aktif', true)->orderBy('nama')->get();

        // Siapkan data untuk JavaScript
            $obatJson = $obatList->map(function($o) {
                return [
                    'nama'           => $o->nama,
                    'stok'           => $o->stok,
                    'satuan'         => $o->satuan,
                    'satuan_jual'    => $o->satuan_jual,
                    'isi_per_satuan' => $o->isi_per_satuan,
                    'harga'          => $o->harga_jual,
                ];
            })->values()->toJson();
        return view('dokter.form', compact(
            'antrian', 'pemeriksaan', 'tindakanList', 'labList', 'obatList', 'obatJson'
        ));
    }

    public function simpan(Request $request, Antrian $antrian)
    {
        $request->validate([
            'diagnosa_utama'   => 'required|string|min:3',
            'catatan_tambahan' => 'nullable|string',
            'biaya_konsultasi' => 'required|integer|min:0',
        ], [
            'diagnosa_utama.required' => 'Diagnosa utama wajib diisi.',
        ]);

        // Proses tindakan dari database
        $tindakanDipilih = [];
        if ($request->has('tindakan')) {
            $tindakans = Tindakan::whereIn('nama', $request->tindakan)->get();
            foreach ($tindakans as $t) {
                $tindakanDipilih[] = ['nama' => $t->nama, 'harga' => $t->harga];
            }
        }

        // Proses lab dari database
        $labDipilih = [];
        if ($request->has('lab')) {
            $labs = Lab::whereIn('nama', $request->lab)->get();
            foreach ($labs as $l) {
                $labDipilih[] = ['nama' => $l->nama, 'harga' => $l->harga];
            }
        }

        // Proses resep obat dari database
        $resepObat = [];
        if ($request->has('obat_nama') && is_array($request->obat_nama)) {
            foreach ($request->obat_nama as $i => $namaObat) {
                if (empty($namaObat)) continue;
                $obat = Obat::where('nama', $namaObat)->first();
                $resepObat[] = [
                    'nama_obat'    => $namaObat,
                    'jumlah'       => (int)($request->obat_jumlah[$i] ?? 1),
                    'aturan_pakai' => $request->obat_aturan[$i] ?? '',
                    'harga_satuan' => $obat ? $obat->harga_jual : 0,
                ];
            }
        }

        // Hitung total
        $total = (int)$request->biaya_konsultasi;
        foreach ($tindakanDipilih as $t) $total += $t['harga'];
        foreach ($labDipilih as $l) $total += $l['harga'];
        foreach ($resepObat as $o) $total += $o['harga_satuan'] * $o['jumlah'];

        Pemeriksaan::updateOrCreate(
            ['antrian_id' => $antrian->id],
            [
                'diagnosa_utama'   => $request->diagnosa_utama,
                'catatan_tambahan' => $request->catatan_tambahan,
                'biaya_konsultasi' => $request->biaya_konsultasi,
                'perlu_observasi'  => $request->boolean('perlu_observasi'),
                'tindakan'         => $tindakanDipilih,
                'lab'              => $labDipilih,
                'resep_obat'       => $resepObat,
                'total_biaya'      => $total,
            ]
        );

        Pembayaran::updateOrCreate(
            ['antrian_id' => $antrian->id],
            ['total_bayar' => $total]
        );

        $antrian->update([
            'status'    => 'menunggu_kasir',
            'dokter_id' => session('karyawan_id'),
        ]);

        return redirect()->route('dokter.index')
            ->with('success', "Pemeriksaan {$antrian->nama_lengkap} berhasil disimpan.");
    }

    public function riwayat()
    {
        $antreans = Antrian::with('pemeriksaan', 'dokter')
            ->whereNotIn('status', ['menunggu_dokter', 'dipanggil_dokter', 'sedang_diperiksa'])
            ->orderByDesc('tanggal_kunjungan')
            ->orderByDesc('nomor_antrian')
            ->paginate(20);

        return view('riwayat.dokter', compact('antreans'));
    }
}