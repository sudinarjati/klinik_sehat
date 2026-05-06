@extends('layouts.app')

@section('title', 'Antrian Pasien')

@section('nav-links')
    <li><a href="{{ route('dokter.index') }}" class="nav-link active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Antrian Pasien
    </a></li>
    <li><a href="{{ route('dokter.riwayat') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Antrian Pasien</h1>
    <p class="page-desc">Daftar pasien yang menunggu pemeriksaan hari ini.</p>
</div>

@if($antreans->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">🩺</div>
                <div class="empty-title">Tidak ada pasien dalam antrian</div>
                <div class="empty-desc">Pasien yang telah didaftarkan akan muncul di sini.</div>
            </div>
        </div>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:12px;">
        @foreach($antreans as $antrian)
            <div class="card">
                <div class="card-body" style="display:flex; align-items:center; gap:16px;">

                    {{-- Nomor Antrian --}}
                    <div style="width:52px; height:52px; background:var(--primary-light); color:var(--primary); border-radius:14px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:20px; flex-shrink:0;">
                        {{ $antrian->nomor_antrian }}
                    </div>

                    {{-- Info Pasien --}}
                    <div style="flex:1;">
                        <div style="font-size:17px; font-weight:700;">{{ $antrian->nama_lengkap }}</div>
                        <div style="font-size:12px; color:var(--text-light); margin-top:3px; display:flex; gap:16px;">
                            @if($antrian->umur)
                                <span>{{ $antrian->umur }} thn ({{ $antrian->jenis_kelamin }})</span>
                            @else
                                <span>{{ $antrian->jenis_kelamin }}</span>
                            @endif
                            <span>HP: {{ $antrian->nomor_hp }}</span>
                            <span>Ibu: {{ $antrian->nama_ibu_kandung }}</span>
                            <span>{{ $antrian->alamat }}</span>
                        </div>
                       <div style="margin-top:6px; display:flex; gap:6px; align-items:center;">
                            <span class="badge {{ $antrian->badge_class }}">{{ $antrian->label_status }}</span>
                            @if(isset($antrian->jenis_pasien))
                                <span class="badge" style="{{ $antrian->jenis_pasien === 'luar_negeri' ? 'background:#fef3cd; color:#856404;' : 'background:#e0f2fe; color:#0369a1;' }}">
                                    {{ $antrian->jenis_pasien === 'luar_negeri' ? '✈️ Luar Negeri' : '🏠 Lokal' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Waktu Daftar --}}
                    <div style="text-align:right; font-size:12px; color:var(--text-light); flex-shrink:0;">
                        {{ $antrian->created_at->format('H:i') }}<br>
                        {{ $antrian->tanggal_kunjungan->format('d M Y') }}
                    </div>

                    {{-- Tombol Aksi --}}
                    <div style="display:flex; gap:8px; flex-shrink:0;">
                        @if($antrian->status === 'menunggu_dokter')
                            <form action="{{ route('dokter.panggil', $antrian->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.67A2 2 0 012 1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                    Panggil
                                </button>
                            </form>
                        @endif

                        @if(in_array($antrian->status, ['menunggu_dokter', 'dipanggil_dokter']))
                            <form action="{{ route('dokter.periksa', $antrian->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                                    Periksa
                                </button>
                            </form>
                        @endif

                        @if($antrian->status === 'sedang_diperiksa')
                            <a href="{{ route('dokter.form', $antrian->id) }}" class="btn btn-primary">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Lanjut Input
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection