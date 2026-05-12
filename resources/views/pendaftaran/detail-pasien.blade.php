@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('nav-links')
    @if(session('karyawan_peran') === 'pendaftaran_kasir')
        @include('layouts.nav-pendaftaran-kasir')
    @else
        <li><a href="{{ route('pendaftaran.index') }}" class="nav-link">Pendaftaran</a></li>
        <li><a href="{{ route('pendaftaran.pasien') }}" class="nav-link active">Data Pasien</a></li>
        <li><a href="{{ route('pendaftaran.riwayat') }}" class="nav-link">Riwayat</a></li>
    @endif
@endsection

@section('content')
<a href="{{ route('pendaftaran.pasien') }}" class="back-link">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Data Pasien
</a>

<div style="display:grid; grid-template-columns:320px 1fr; gap:24px; align-items:start;">

    {{-- Kartu Info Pasien --}}
    <div style="position:sticky; top:72px;">
        <div class="card">
            <div class="card-body" style="text-align:center; padding:28px 20px;">
                {{-- Avatar --}}
                <div style="width:72px; height:72px; background:var(--primary-light); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; font-size:28px;">
                    {{ $antrian->jenis_kelamin === 'laki-laki' ? '👨' : '👩' }}
                </div>
                <div style="font-size:20px; font-weight:700;">{{ $antrian->nama_lengkap }}</div>
                <div style="margin-top:8px;">
                    <span style="background:var(--primary-light); color:var(--primary); padding:3px 12px; border-radius:20px; font-weight:700; font-size:13px; letter-spacing:1px;">
                        RM {{ $antrian->nomor_rm }}
                    </span>
                </div>
                @if(isset($antrian->jenis_pasien))
                    <div style="margin-top:8px;">
                        <span style="font-size:12px; padding:2px 10px; border-radius:20px; font-weight:600; {{ $antrian->jenis_pasien === 'luar_negeri' ? 'background:#fef3cd; color:#856404;' : 'background:#e0f2fe; color:#0369a1;' }}">
                            {{ $antrian->jenis_pasien === 'luar_negeri' ? '✈️ Luar Negeri' : '🏠 Lokal' }}
                        </span>
                    </div>
                @endif
            </div>

            <div style="border-top:1px solid var(--border); padding:16px 20px;">
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-light);">Jenis Kelamin</span>
                        <span style="font-weight:500;">{{ ucfirst($antrian->jenis_kelamin) }}</span>
                    </div>
                    @if($antrian->tanggal_lahir)
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-light);">Tanggal Lahir</span>
                        <span style="font-weight:500;">{{ $antrian->tanggal_lahir->format('d M Y') }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-light);">Umur</span>
                        <span style="font-weight:500;">{{ $antrian->umur }} tahun</span>
                    </div>
                    @endif
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-light);">No HP</span>
                        <span style="font-weight:500;">{{ $antrian->nomor_hp }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:13px;">
                        <span style="color:var(--text-light);">Ibu Kandung</span>
                        <span style="font-weight:500;">{{ $antrian->nama_ibu_kandung }}</span>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:4px; font-size:13px;">
                        <span style="color:var(--text-light);">Alamat</span>
                        <span style="font-weight:500; text-align:right;">{{ $antrian->alamat }}</span>
                    </div>
                </div>
            </div>

            <div style="border-top:1px solid var(--border); padding:14px 20px; background:var(--bg); border-radius:0 0 var(--radius-lg) var(--radius-lg);">
                <div style="display:flex; justify-content:space-between; font-size:13px;">
                    <span style="color:var(--text-light);">Total Kunjungan</span>
                    <span style="font-weight:700; color:var(--primary);">{{ $riwayatKunjungan->count() }}x</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:13px; margin-top:6px;">
                    <span style="color:var(--text-light);">Kunjungan Terakhir</span>
                    <span style="font-weight:500;">{{ $riwayatKunjungan->first()?->tanggal_kunjungan->format('d M Y') ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Kunjungan --}}
    <div>
        <div style="font-size:16px; font-weight:700; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Riwayat Kunjungan
        </div>

        @forelse($riwayatKunjungan as $kunjungan)
            @php $p = $kunjungan->pemeriksaan; @endphp
            <div class="card" style="margin-bottom:14px;">
                <div style="padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span style="background:var(--primary-light); color:var(--primary); padding:2px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                            Antrean {{ $kunjungan->nomor_antrian }}
                        </span>
                        <span style="font-weight:600; font-size:14px;">
                            {{ $kunjungan->tanggal_kunjungan->format('d F Y') }}
                        </span>
                    </div>
                    <span class="badge {{ $kunjungan->badge_class }}">{{ $kunjungan->label_status }}</span>
                </div>

                <div style="padding:14px 18px;">
                    @if($p)
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div>
                                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); margin-bottom:4px;">Diagnosa</div>
                                <div style="font-size:14px; font-weight:500;">{{ $p->diagnosa_utama }}</div>
                                @if($p->catatan_tambahan)
                                    <div style="font-size:12px; color:var(--text-light); margin-top:4px;">{{ $p->catatan_tambahan }}</div>
                                @endif
                            </div>
                            <div>
                                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); margin-bottom:4px;">Dokter</div>
                                <div style="font-size:14px; font-weight:500;">{{ $kunjungan->dokter->nama_lengkap ?? '-' }}</div>
                            </div>
                        </div>

                        @if(!empty($p->tindakan))
                            <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--border);">
                                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); margin-bottom:6px;">Tindakan</div>
                                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                    @foreach($p->tindakan as $t)
                                        <span style="background:var(--bg); border:1px solid var(--border); padding:3px 10px; border-radius:20px; font-size:12px;">{{ $t['nama'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(!empty($p->resep_obat))
                            <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--border);">
                                <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:var(--text-light); margin-bottom:6px;">Obat</div>
                                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                    @foreach($p->resep_obat as $o)
                                        <span style="background:var(--primary-light); color:var(--primary); padding:3px 10px; border-radius:20px; font-size:12px; font-weight:500;">
                                            {{ $o['nama_obat'] }} x{{ $o['jumlah'] }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div style="margin-top:12px; padding-top:12px; border-top:1px solid var(--border); display:flex; justify-content:flex-end;">
                            <span style="font-weight:700; color:var(--primary); font-size:15px;">
                                Total: Rp {{ number_format($p->total_biaya ?? 0, 0, ',', '.') }}
                            </span>
                        </div>
                    @else
                        <div style="text-align:center; padding:20px; color:var(--text-light); font-size:13px;">
                            Belum ada data pemeriksaan untuk kunjungan ini.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <div class="empty-icon">📋</div>
                        <div class="empty-title">Belum ada riwayat kunjungan</div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection