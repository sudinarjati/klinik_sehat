@extends('layouts.app')

@section('title', 'Apotek')

@section('nav-links')
    <li><a href="{{ route('apoteker.index') }}" class="nav-link active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/><path d="M18 15v3l2 1"/></svg>
        Apotek
    </a></li>
    <li><a href="{{ route('apoteker.riwayat') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Apotek</h1>
    <p class="page-desc">Siapkan dan serahkan obat kepada pasien yang telah membayar.</p>
</div>

@if($antreans->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">💊</div>
                <div class="empty-title">Tidak ada obat yang perlu disiapkan</div>
                <div class="empty-desc">Pasien yang telah membayar akan muncul di sini.</div>
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
                        Dokter: {{ $antrian->dokter->nama_lengkap ?? '-' }}
                    </div>
                </div>

                {{-- Body --}}
                <div class="patient-card-body">
                    @if(!empty($p->resep_obat))
                        @foreach($p->resep_obat as $obat)
                            <div class="obat-pill">
                                <div class="obat-pill-header">
                                    <span class="obat-pill-nama">{{ $obat['nama_obat'] }}</span>
                                    <span class="obat-jumlah">{{ $obat['jumlah'] }}</span>
                                </div>
                                @if(!empty($obat['aturan_pakai']))
                                    <div class="obat-aturan">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $obat['aturan_pakai'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div style="text-align:center; padding:24px; color:var(--text-light); font-size:13px;">
                            Tidak ada obat dalam resep.
                        </div>
                    @endif
                </div>

                {{-- Footer --}}
                <div class="patient-card-footer">
                    <form action="{{ route('apoteker.serahkan', $antrian->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-full"
                            onclick="return confirm('Konfirmasi penyerahan obat untuk {{ $antrian->nama_lengkap }}?')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Serahkan Obat
                        </button>
                    </form>
                </div>

            </div>
        @endforeach
    </div>
@endif
@endsection