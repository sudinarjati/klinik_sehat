@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('nav-links')
    @if(session('karyawan_peran') === 'pendaftaran_kasir')
        @include('layouts.nav-pendaftaran-kasir')
    @else
        <li><a href="{{ route('kasir.index') }}" class="nav-link">Pembayaran</a></li>
        <li><a href="{{ route('kasir.riwayat') }}" class="nav-link active">Riwayat</a></li>
    @endif
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Riwayat Pembayaran</h1>
    <p class="page-desc">Seluruh data pembayaran pasien.</p>
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
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Total Bayar</th>
                    <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Dibayar Pada</th>
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
                        <td style="padding:12px 16px; font-weight:600; color:var(--primary);">
                            Rp {{ number_format($antrian->pembayaran->total_bayar ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                            {{ $antrian->pembayaran->dibayar_pada?->format('d M Y H:i') ?? '-' }}
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