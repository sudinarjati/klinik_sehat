@extends('layouts.app')

@section('title', 'Riwayat Apotek')

@section('nav-links')
    <li><a href="{{ route('apoteker.index') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/><path d="M18 15v3l2 1"/></svg>
        Apotek
    </a></li>
    <li><a href="{{ route('apoteker.riwayat') }}" class="nav-link active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Riwayat Apotek</h1>
    <p class="page-desc">Seluruh data obat yang telah diserahkan kepada pasien.</p>
</div>

<div class="card">
    <div class="card-body" style="padding:0;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:var(--bg);">
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Tanggal</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Nama Pasien</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Dokter</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Obat Diberikan</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antreans as $antrian)
                    @php $p = $antrian->pemeriksaan; @endphp
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:12px 16px; font-weight:600; color:var(--primary);">
                            {{ $antrian->nomor_antrian }}
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->tanggal_kunjungan->format('d M Y') }}
                        </td>
                        <td style="padding:12px 16px; font-weight:600;">
                            {{ $antrian->nama_lengkap }}
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->dokter->nama_lengkap ?? '-' }}
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            @if(!empty($p->resep_obat))
                                @foreach($p->resep_obat as $obat)
                                    <div style="margin-bottom:2px;">
                                        {{ $obat['nama_obat'] }}
                                        <span style="background:var(--primary-light); color:var(--primary); padding:1px 6px; border-radius:4px; font-size:11px; font-weight:600;">
                                            x{{ $obat['jumlah'] }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <span style="color:var(--text-light);">Tidak ada obat</span>
                            @endif
                        </td>
                        <td style="padding:12px 16px;">
                            <span class="badge badge-success">Selesai</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:40px; text-align:center; color:var(--text-light);">
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