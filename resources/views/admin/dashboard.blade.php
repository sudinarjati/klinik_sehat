@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalTindakan }}</div>
            <div class="stat-label">Tindakan Medis</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalLab }}</div>
            <div class="stat-label">Pemeriksaan Lab</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fdf4ff;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalObat }}</div>
            <div class="stat-label">Jenis Obat</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $totalAlkes }}</div>
            <div class="stat-label">Jenis Alkes</div>
        </div>
    </div>
</div>

{{-- Stok Obat Menipis --}}
@if($stokMenipisObat->count() > 0)
<div class="card" style="margin-bottom:16px;">
    <div class="card-header">
        <div class="card-header-title" style="color:#ef4444;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Stok Obat Menipis (≤ 10)
        </div>
        <a href="{{ route('admin.obat') }}" class="btn btn-sm btn-outline">Kelola Stok Obat</a>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokMenipisObat as $obat)
                <tr>
                    <td style="font-weight:600;">{{ $obat->nama }}</td>
                    <td>{{ $obat->satuan }}</td>
                    <td>
                        <span class="stok-badge" style="{{ $obat->stok <= 5 ? 'background:#fee2e2;color:#991b1b;' : 'background:#fef3cd;color:#856404;' }}">
                            {{ $obat->stok }} {{ $obat->satuan }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Stok Alkes Menipis --}}
@if($stokMenipisAlkes->count() > 0)
<div class="card" style="margin-bottom:16px;">
    <div class="card-header">
        <div class="card-header-title" style="color:#ef4444;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Stok Alkes Menipis (≤ 10)
        </div>
        <a href="{{ route('admin.alkes') }}" class="btn btn-sm btn-outline">Kelola Stok Alkes</a>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Alkes</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stokMenipisAlkes as $alkes)
                <tr>
                    <td style="font-weight:600;">{{ $alkes->nama }}</td>
                    <td>{{ $alkes->satuan }}</td>
                    <td>
                        <span class="stok-badge" style="{{ $alkes->stok <= 5 ? 'background:#fee2e2;color:#991b1b;' : 'background:#fef3cd;color:#856404;' }}">
                            {{ $alkes->stok }} {{ $alkes->satuan }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($alkes->harga_jual, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Semua stok aman --}}
@if($stokMenipisObat->count() === 0 && $stokMenipisAlkes->count() === 0)
<div class="card">
    <div class="card-body">
        <div class="empty-state">
            <div class="empty-icon">✅</div>
            <div style="font-weight:600; color:var(--text-mid);">Semua stok obat dan alkes dalam kondisi aman</div>
        </div>
    </div>
</div>
@endif
@endsection