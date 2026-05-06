@extends('layouts.app')

@section('title', 'Riwayat Pemeriksaan')

@section('nav-links')
    <li><a href="{{ route('dokter.index') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Antrian Pasien
    </a></li>
    <li><a href="{{ route('dokter.riwayat') }}" class="nav-link active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Riwayat Pemeriksaan</h1>
    <p class="page-desc">Seluruh data pasien yang telah diperiksa.</p>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:var(--bg);">
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Tanggal</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Nama Pasien</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Diagnosa</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Tindakan</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Total</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antreans as $antrian)
                    @php $p = $antrian->pemeriksaan; @endphp
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px; font-weight:600; color:var(--primary);">{{ $antrian->nomor_antrian }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->tanggal_kunjungan->format('d M Y') }}
                        </td>
                        <td style="padding:12px 16px; font-weight:600;">{{ $antrian->nama_lengkap }}</td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $p->diagnosa_utama ?? '-' }}
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            @if(!empty($p->tindakan))
                                {{ collect($p->tindakan)->pluck('nama')->join(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding:12px 16px; font-weight:600; color:var(--primary);">
                            Rp {{ number_format($p->total_biaya ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding:12px 16px;">
                            <span class="badge {{ $antrian->badge_class }}">{{ $antrian->label_status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding:40px; text-align:center; color:var(--text-light);">
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