{{-- Nav untuk peran pendaftaran_kasir (double job) --}}
<li><a href="{{ route('pendaftaran.index') }}" class="nav-link {{ request()->routeIs('pendaftaran.index') ? 'active' : '' }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
    Pendaftaran
</a></li>
<li><a href="{{ route('pendaftaran.pasien') }}" class="nav-link {{ request()->routeIs('pendaftaran.pasien*') ? 'active' : '' }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    Data Pasien
</a></li>
<li><a href="{{ route('kasir.index') }}" class="nav-link {{ request()->routeIs('kasir.index') ? 'active' : '' }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
    Pembayaran
</a></li>
<li><a href="{{ route('pendaftaran.riwayat') }}" class="nav-link {{ request()->routeIs('pendaftaran.riwayat') ? 'active' : '' }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    Riwayat Daftar
</a></li>
<li><a href="{{ route('kasir.riwayat') }}" class="nav-link {{ request()->routeIs('kasir.riwayat') ? 'active' : '' }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
    Riwayat Bayar
</a></li>