@extends('layouts.app')

@section('title', 'Data Pasien')

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
<div class="page-header" style="display:flex; justify-content:space-between; align-items:flex-start;">
    <div>
        <h1 class="page-title">Data Pasien</h1>
        <p class="page-desc">Daftar seluruh pasien yang memiliki Nomor Rekam Medis.</p>
    </div>
    <div style="font-size:13px; color:var(--text-light); background:var(--white); border:1px solid var(--border); padding:6px 14px; border-radius:20px;">
        Total: <strong style="color:var(--text-dark);">{{ $pasiens->count() }} pasien</strong>
    </div>
</div>

{{-- Search Bar --}}
<div style="margin-bottom:20px;">
    <form action="{{ route('pendaftaran.pasien') }}" method="GET">
        <div style="display:flex; gap:10px; max-width:500px;">
            <div style="position:relative; flex:1;">
                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-light);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </span>
                <input type="text" name="search"
                    value="{{ $search }}"
                    placeholder="Cari nama pasien atau Nomor RM..."
                    class="form-control"
                    style="padding-left:38px;"
                    autofocus>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            @if($search)
                <a href="{{ route('pendaftaran.pasien') }}" class="btn btn-outline">Reset</a>
            @endif
        </div>
    </form>
</div>

@if($search)
    <div style="margin-bottom:16px; font-size:13px; color:var(--text-mid);">
        Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong>
        — ditemukan {{ $pasiens->count() }} pasien
    </div>
@endif

@if($pasiens->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <div class="empty-title">
                    {{ $search ? 'Pasien tidak ditemukan' : 'Belum ada data pasien' }}
                </div>
                <div class="empty-desc">
                    {{ $search ? 'Coba cari dengan kata kunci lain.' : 'Pasien yang telah didaftarkan dan memiliki Nomor RM akan muncul di sini.' }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body" style="padding:0;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--bg);">
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No RM</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Nama Pasien</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Jenis Kelamin</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Jenis Pasien</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">No HP</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);">Kunjungan Terakhir</th>
                        <th style="padding:12px 16px; text-align:left; font-size:12px; font-weight:600; color:var(--text-light); border-bottom:1px solid var(--border);"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasiens as $pasien)
                        <tr style="border-bottom:1px solid var(--border); transition:background 0.1s;"
                            onmouseover="this.style.background='var(--bg)'"
                            onmouseout="this.style.background=''">
                            <td style="padding:12px 16px;">
                                <span style="background:var(--primary-light); color:var(--primary); padding:3px 10px; border-radius:20px; font-weight:700; font-size:12px; letter-spacing:1px;">
                                    {{ $pasien->nomor_rm }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;">
                                <div style="font-weight:600; font-size:14px;">{{ $pasien->nama_lengkap }}</div>
                                @if($pasien->umur)
                                    <div style="font-size:12px; color:var(--text-light);">{{ $pasien->umur }} tahun</div>
                                @endif
                            </td>
                            <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                                {{ ucfirst($pasien->jenis_kelamin) }}
                            </td>
                            <td style="padding:12px 16px;">
                                @if(isset($pasien->jenis_pasien))
                                    <span style="font-size:12px; padding:2px 8px; border-radius:20px; font-weight:600; {{ $pasien->jenis_pasien === 'luar_negeri' ? 'background:#fef3cd; color:#856404;' : 'background:#e0f2fe; color:#0369a1;' }}">
                                        {{ $pasien->jenis_pasien === 'luar_negeri' ? '✈️ Luar Negeri' : '🏠 Lokal' }}
                                    </span>
                                @endif
                            </td>
                            <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">{{ $pasien->nomor_hp }}</td>
                            <td style="padding:12px 16px; font-size:13px; color:var(--text-mid);">
                                {{ $pasien->tanggal_kunjungan->format('d M Y') }}
                            </td>
                            <td style="padding:12px 16px;">
                                <a href="{{ route('pendaftaran.pasien.detail', $pasien->id) }}"
                                    class="btn btn-outline btn-sm">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Live search saat mengetik
    const searchInput = document.querySelector('input[name="search"]');
    let timeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            this.closest('form').submit();
        }, 400);
    });
</script>
@endpush