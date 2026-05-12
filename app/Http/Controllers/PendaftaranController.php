<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class PendaftaranController extends Controller
{
    public function index()
    {
       $antreans = Antrian::whereDate('tanggal_kunjungan', today())
            ->where('status', '!=', 'selesai')
            ->orderByDesc('nomor_antrian')
            ->get();

        return view('pendaftaran.index', compact('antreans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kunjungan' => 'required|date',
            'nama_lengkap'      => 'required|string|min:2',
            'tanggal_lahir'     => 'nullable|date|before:today',
        'jenis_kelamin'     => 'required|in:laki-laki,perempuan',
        'jenis_pasien'      => 'required|in:lokal,luar_negeri',
        'nomor_hp'          => 'required|string|min:8|max:15',
        'nama_ibu_kandung'  => 'required|string|min:2',
        'alamat'            => 'required|string|min:5',
    ]);

    // Gunakan nomor RM lama jika pasien lama, generate baru jika pasien baru
    $nomorRM = $request->nomor_rm_lama
        ? $request->nomor_rm_lama
        : Antrian::generateNomorRM();

    Antrian::create([
        'nomor_rm'          => $nomorRM,
        'nomor_antrian'     => Antrian::nomorBerikutnya(),
        'tanggal_kunjungan' => $request->tanggal_kunjungan,
        'nama_lengkap'      => $request->nama_lengkap,
        'tanggal_lahir'     => $request->tanggal_lahir,
        'jenis_kelamin'     => $request->jenis_kelamin,
        'jenis_pasien'      => $request->jenis_pasien,
        'nomor_hp'          => $request->nomor_hp,
        'nama_ibu_kandung'  => $request->nama_ibu_kandung,
        'alamat'            => $request->alamat,
        'status'            => 'menunggu_dokter',
    ]);

    return redirect()->route('pendaftaran.index')
        ->with('success', 'Pasien berhasil didaftarkan!');
    }

    public function riwayat()
    {
        $antreans = Antrian::with('pemeriksaan')
            ->orderByDesc('tanggal_kunjungan')
            ->orderByDesc('nomor_antrian')
            ->paginate(20);

        return view('riwayat.index', compact('antreans'));
    }

    public function pasien(Request $request)
    {
        $search = $request->get('search');

        $pasiens = Antrian::whereNotNull('nomor_rm')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_rm', 'like', "%{$search}%");
            });
        })
        ->orderBy('nomor_rm')
        ->get()
        ->unique('nomor_rm'); // satu RM = satu pasien

        return view('pendaftaran.pasien', compact('pasiens', 'search'));
    }

    public function detailPasien(Antrian $antrian)
    {
        // Ambil semua kunjungan pasien berdasarkan nama + ibu kandung
        $riwayatKunjungan = Antrian::with('pemeriksaan', 'dokter')
        ->where('nama_lengkap', $antrian->nama_lengkap)
        ->where('nama_ibu_kandung', $antrian->nama_ibu_kandung)
        ->orderByDesc('tanggal_kunjungan')
        ->get();

        return view('pendaftaran.detail-pasien', compact('antrian', 'riwayatKunjungan'));
    }

    public function hapus(Antrian $antrian)
    {
        $nama = $antrian->nama_lengkap;
        $antrian->delete();

        return redirect()->route('pendaftaran.riwayat')
            ->with('success', "Data pasien {$nama} berhasil dihapus.");
    }

    public function cariPasien(Request $request)
    {
    $keyword = $request->q;

    $results = Antrian::where(function($q) use ($keyword) {
            $q->where('nama_lengkap', 'like', "%{$keyword}%")
              ->orWhere('nomor_rm', 'like', "%{$keyword}%");
        })
        ->whereNotNull('nomor_rm')
        ->orderByRaw('CAST(nomor_rm AS UNSIGNED) DESC')
        ->get(['id', 'nama_lengkap', 'nomor_rm', 'tanggal_lahir',
               'jenis_kelamin', 'jenis_pasien', 'nomor_hp',
               'nama_ibu_kandung', 'alamat'])
        ->unique('nomor_rm')
        ->values()
        ->map(function($a) {
            return [
                'nama_lengkap'    => $a->nama_lengkap,
                'nomor_rm'        => $a->nomor_rm,
                'tanggal_lahir'   => $a->tanggal_lahir
                                        ? $a->tanggal_lahir->format('Y-m-d')
                                        : null,
                'jenis_kelamin'   => $a->jenis_kelamin,
                'jenis_pasien'    => $a->jenis_pasien,
                'nomor_hp'        => $a->nomor_hp,
                'nama_ibu_kandung'=> $a->nama_ibu_kandung,
                'alamat'          => $a->alamat,
            ];
        });

    return response()->json($results);
    }
}