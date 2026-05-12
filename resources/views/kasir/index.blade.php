@extends('layouts.app')

@section('title', 'Kasir & Pembayaran')

@section('nav-links')
    @if(session('karyawan_peran') === 'pendaftaran_kasir')
        @include('layouts.nav-pendaftaran-kasir')
    @else
        <li><a href="{{ route('kasir.index') }}" class="nav-link active">Pembayaran</a></li>
        <li><a href="{{ route('kasir.riwayat') }}" class="nav-link">Riwayat</a></li>
    @endif
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Kasir & Pembayaran</h1>
    <p class="page-desc">Kelola pembayaran dari pasien yang telah diperiksa.</p>
</div>

@if($antreans->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">💳</div>
                <div class="empty-title">Tidak ada pasien menunggu pembayaran</div>
                <div class="empty-desc">Pasien yang telah selesai diperiksa dokter akan muncul di sini.</div>
            </div>
        </div>
    </div>
@else
    <div class="layout-cards">
        @foreach($antreans as $antrian)
            @php $p = $antrian->pemeriksaan; @endphp
            <div class="patient-card">

                {{-- Header --}}
                <div class="patient-card-header">
                    <div class="patient-card-meta">
                        <span class="patient-card-no">No. {{ $antrian->nomor_antrian }}</span>
                        <span class="patient-card-date">{{ $antrian->tanggal_kunjungan->format('d M') }}</span>
                    </div>
                    <div class="patient-card-name">{{ $antrian->nama_lengkap }}</div>
                    <div class="patient-card-doctor">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Dokter: {{ $antrian->dokter->nama_lengkap ?? '-' }}
                    </div>
                </div>

                {{-- Body --}}
                <div class="patient-card-body">

                    {{-- Diagnosa --}}
                    <div style="margin-bottom:12px;">
                        <div class="rincian-label">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;vertical-align:middle;"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/></svg>
                            Diagnosa:
                        </div>
                        <div style="font-size:14px;">{{ $p->diagnosa_utama ?? '-' }}</div>
                    </div>

                    {{-- Rincian Biaya --}}
                    <div class="rincian-label" style="margin-bottom:8px;">Rincian Biaya</div>

                    <div class="rincian-row">
                        <span>Konsultasi Dokter</span>
                        <span>Rp {{ number_format($p->biaya_konsultasi ?? 0, 0, ',', '.') }}</span>
                    </div>

                    @if(!empty($p->tindakan))
                        <div class="rincian-row" style="color:var(--text-mid); font-size:12px;">
                            <span>Tindakan:</span>
                        </div>
                        @foreach($p->tindakan as $t)
                            <div class="rincian-row indent">
                                <span>- {{ $t['nama'] }}</span>
                                <span>Rp {{ number_format($t['harga'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endif

                    @if(!empty($p->resep_obat))
                        <div class="rincian-row" style="color:var(--text-mid); font-size:12px; margin-top:4px;">
                            <span>Obat-obatan:</span>
                        </div>
                        @foreach($p->resep_obat as $o)
                            <div class="rincian-row indent">
                                <span>- {{ $o['nama_obat'] }} x{{ $o['jumlah'] }}</span>
                                <span>Rp {{ number_format(($o['harga_satuan'] ?? 0) * ($o['jumlah'] ?? 1), 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="rincian-total">
                        <span>Total Tagihan</span>
                        <span>Rp {{ number_format($antrian->pembayaran->total_bayar ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="patient-card-footer">
                    <form action="{{ route('kasir.lunas', $antrian->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-full"
                            onclick="return confirm('Konfirmasi pembayaran {{ $antrian->nama_lengkap }}?')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Tandai Lunas
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif
@endsection