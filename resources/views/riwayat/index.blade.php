@extends('layouts.app')

@section('title', 'Riwayat Pendaftaran')

@section('nav-links')
    @if(session('karyawan_peran') === 'pendaftaran_kasir')
        @include('layouts.nav-pendaftaran-kasir')
    @else
        <li><a href="{{ route('pendaftaran.index') }}" class="nav-link">Pendaftaran</a></li>
        <li><a href="{{ route('pendaftaran.pasien') }}" class="nav-link">Data Pasien</a></li>
        <li><a href="{{ route('pendaftaran.riwayat') }}" class="nav-link active">Riwayat</a></li>
    @endif
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Riwayat Pendaftaran</h1>
    <p class="page-desc">Seluruh data pasien yang pernah didaftarkan.</p>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:var(--bg);">
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Tanggal</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Nama Pasien</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Jenis Kelamin</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No HP</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Diagnosa</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Status</th>
                    <th style="padding:12px 16px; border-bottom:1px solid var(--border);"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($antreans as $antrian)
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px; font-weight:600; color:var(--primary);">{{ $antrian->nomor_antrian }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->tanggal_kunjungan->format('d M Y') }}
                        </td>
                        <td style="padding:12px 16px; font-weight:600;">{{ $antrian->nama_lengkap }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">{{ ucfirst($antrian->jenis_kelamin) }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">{{ $antrian->nomor_hp }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->pemeriksaan->diagnosa_utama ?? '-' }}
                        </td>
                        <td style="padding:12px 16px;">
                            <span class="badge {{ $antrian->badge_class }}">{{ $antrian->label_status }}</span>
                        </td>
                        <td style="padding:12px 16px;">
                            <form action="{{ route('pendaftaran.hapus', $antrian->id) }}" method="POST"
                                onsubmit="return confirm('Hapus data pasien {{ $antrian->nama_lengkap }}? Tindakan ini tidak bisa dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none; border:1px solid #fca5a5; color:#e05252; padding:5px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:5px; transition:all 0.15s;"
                                    onmouseover="this.style.background='#fee2e2'"
                                    onmouseout="this.style.background='none'">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding:40px; text-align:center; color:var(--text-light);">
                            Belum ada data riwayat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $antreans->links() }}
</div>
@endsection