@extends('layouts.app')

@section('title', 'Pendaftaran Pasien')

@section('nav-links')
    <li><a href="{{ route('pendaftaran.index') }}" class="nav-link active">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Pendaftaran
    </a></li>
    <li><a href="{{ route('pendaftaran.pasien') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
        Data Pasien
    </a></li>
    <li><a href="{{ route('pendaftaran.riwayat') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Pendaftaran Pasien</h1>
    <p class="page-desc">Daftarkan pasien baru atau kunjungan ulang hari ini.</p>
</div>

<div class="layout-split">
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Cari Pasien Lama --}}
        <div class="card" style="border: 2px solid var(--primary-light);">
            <div class="card-header" style="background:var(--primary-light); border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span style="color:var(--primary);">Cari Pasien Lama (Kunjungan Ulang)</span>
            </div>
            <div class="card-body">
                <p style="font-size:13px; color:var(--text-light); margin-bottom:12px;">
                    Jika pasien pernah berkunjung sebelumnya, cari berdasarkan nama atau Nomor RM agar data otomatis terisi.
                </p>
                <div style="display:flex; gap:10px;">
                    <div style="position:relative; flex:1;">
                        <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-light);">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        </span>
                        <input type="text" id="cariPasien" class="form-control" style="padding-left:36px;"
                            placeholder="Ketik nama atau Nomor RM...">
                    </div>
                    <button type="button" onclick="cariPasienLama()" class="btn btn-primary">Cari</button>
                </div>

                {{-- Hasil pencarian --}}
                <div id="hasilCari" style="display:none; margin-top:12px;"></div>
            </div>
        </div>

        {{-- Form Pendaftaran --}}
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Formulir Pendaftaran
                <span id="labelPasien" style="margin-left:8px; font-size:11px; padding:2px 10px; border-radius:20px; font-weight:600; display:none;"></span>
            </div>
            <div class="card-body">
                <form action="{{ route('pendaftaran.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nomor_rm_lama" id="nomor_rm_lama">

                    <div class="form-grid form-grid-2">

                        {{-- 1. Tanggal Kunjungan --}}
                        <div class="form-group">
                            <label class="form-label">1. Tanggal Kunjungan <span class="required">*</span></label>
                            <input type="date" name="tanggal_kunjungan" class="form-control"
                                value="{{ old('tanggal_kunjungan', today()->format('Y-m-d')) }}" required>
                            @error('tanggal_kunjungan')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- Nomor RM --}}
                        <div class="form-group">
                            <label class="form-label">Nomor RM
                                <span style="font-size:11px; font-weight:400; color:var(--text-light); margin-left:4px;" id="rmLabel">(otomatis untuk pasien baru)</span>
                            </label>
                            <input type="text" id="nomorRMDisplay" class="form-control"
                                value="{{ \App\Models\Antrian::generateNomorRM() }}"
                                disabled
                                style="background:var(--bg); color:var(--primary); font-weight:700; font-size:16px; letter-spacing:2px; cursor:not-allowed;">
                        </div>

                        {{-- 2. Nama Lengkap --}}
                        <div class="form-group">
                            <label class="form-label">2. Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama_lengkap" id="f_nama" class="form-control"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 3. Tanggal Lahir --}}
                        <div class="form-group">
                            <label class="form-label">3. Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="f_lahir" class="form-control"
                                value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 4. Jenis Kelamin --}}
                        <div class="form-group">
                            <label class="form-label">4. Jenis Kelamin <span class="required">*</span></label>
                            <select name="jenis_kelamin" id="f_kelamin" class="form-control" required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 5. Jenis Pasien --}}
                        <div class="form-group">
                            <label class="form-label">5. Jenis Pasien <span class="required">*</span></label>
                            <select name="jenis_pasien" id="f_jenis_pasien" class="form-control" required>
                                <option value="">Pilih jenis pasien</option>
                                <option value="lokal" {{ old('jenis_pasien') === 'lokal' ? 'selected' : '' }}>🏠 Lokal</option>
                                <option value="luar_negeri" {{ old('jenis_pasien') === 'luar_negeri' ? 'selected' : '' }}>✈️ Luar Negeri</option>
                            </select>
                            @error('jenis_pasien')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 6. Nomor HP --}}
                        <div class="form-group">
                            <label class="form-label">6. Nomor HP <span class="required">*</span></label>
                            <input type="text" name="nomor_hp" id="f_hp" class="form-control"
                                placeholder="Contoh: 08123456789"
                                value="{{ old('nomor_hp') }}" required>
                            @error('nomor_hp')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 7. Nama Ibu Kandung --}}
                        <div class="form-group">
                            <label class="form-label">7. Nama Ibu Kandung <span class="required">*</span></label>
                            <input type="text" name="nama_ibu_kandung" id="f_ibu" class="form-control"
                                placeholder="Nama ibu kandung"
                                value="{{ old('nama_ibu_kandung') }}" required>
                            @error('nama_ibu_kandung')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                        {{-- 8. Alamat --}}
                        <div class="form-group col-full">
                            <label class="form-label">8. Alamat <span class="required">*</span></label>
                            <textarea name="alamat" id="f_alamat" class="form-control"
                                placeholder="Alamat lengkap pasien" required>{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="form-error">{{ $message }}</div>@enderror
                        </div>

                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:8px;">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Daftarkan Pasien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Antrean Hari Ini --}}
    <div class="estimasi-sticky">
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Antrean Hari Ini
                <span style="margin-left:auto; font-size:12px; color:var(--text-light); font-weight:400;">
                    Total: {{ $antreans->count() }} pasien
                </span>
            </div>
            <div class="card-body">
                @forelse($antreans as $antrian)
                    <div class="antrian-item">
                        <div class="antrian-number">{{ $antrian->nomor_antrian }}</div>
                        <div class="antrian-info">
                            <div class="antrian-nama">{{ $antrian->nama_lengkap }}</div>
                            <div class="antrian-time">
                                @if($antrian->nomor_rm)
                                    <span style="font-weight:600; color:var(--primary);">RM {{ $antrian->nomor_rm }}</span> ·
                                @endif
                                {{ $antrian->created_at->format('d M Y') }} pukul {{ $antrian->created_at->format('H.i') }}
                            </div>
                        </div>
                        <span class="badge {{ $antrian->badge_class }}">{{ $antrian->label_status }}</span>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">🏥</div>
                        <div class="empty-title">Belum ada pasien</div>
                        <div class="empty-desc">Pasien yang didaftarkan hari ini akan muncul di sini.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const nomoBaru = '{{ \App\Models\Antrian::generateNomorRM() }}';

    async function cariPasienLama() {
        const keyword = document.getElementById('cariPasien').value.trim();
        if (!keyword) return alert('Masukkan nama atau Nomor RM terlebih dahulu.');

        const res = await fetch(`/pendaftaran/cari-pasien?q=${encodeURIComponent(keyword)}`);
        const data = await res.json();
        const container = document.getElementById('hasilCari');
        container.style.display = 'block';

        if (data.length === 0) {
            container.innerHTML = `
                <div style="background:#fee2e2; border-radius:8px; padding:10px 14px; font-size:13px; color:#991b1b;">
                    Pasien tidak ditemukan. Silakan isi form sebagai pasien baru.
                </div>`;
            resetForm();
            return;
        }

        let html = `<div style="font-size:12px; font-weight:600; color:var(--text-light); margin-bottom:8px;">Pilih pasien:</div>`;
        data.forEach(p => {
            html += `
            <div onclick="pilihPasien(${JSON.stringify(p).replace(/"/g, '&quot;')})"
                style="display:flex; align-items:center; gap:12px; padding:10px 12px; border:1px solid var(--border); border-radius:8px; cursor:pointer; margin-bottom:6px; transition:all 0.15s;"
                onmouseover="this.style.background='var(--primary-light)'; this.style.borderColor='var(--primary)'"
                onmouseout="this.style.background=''; this.style.borderColor='var(--border)'">
                <div style="background:var(--primary-light); color:var(--primary); padding:3px 10px; border-radius:20px; font-weight:700; font-size:12px; white-space:nowrap;">
                    RM ${p.nomor_rm}
                </div>
                <div>
                    <div style="font-weight:600; font-size:14px;">${p.nama_lengkap}</div>
                    <div style="font-size:12px; color:var(--text-light);">${p.nomor_hp} · ${p.alamat}</div>
                </div>
            </div>`;
        });
        container.innerHTML = html;
    }

    function pilihPasien(p) {
        // Isi form dengan data pasien lama
        document.getElementById('f_nama').value = p.nama_lengkap;
        document.getElementById('f_lahir').value = p.tanggal_lahir ?? '';
        document.getElementById('f_kelamin').value = p.jenis_kelamin;
        document.getElementById('f_jenis_pasien').value = p.jenis_pasien ?? 'lokal';
        document.getElementById('f_hp').value = p.nomor_hp;
        document.getElementById('f_ibu').value = p.nama_ibu_kandung;
        document.getElementById('f_alamat').value = p.alamat;

        // Set nomor RM lama
        document.getElementById('nomor_rm_lama').value = p.nomor_rm;
        document.getElementById('nomorRMDisplay').value = p.nomor_rm;
        document.getElementById('rmLabel').textContent = '(kunjungan ulang)';

        // Tampilkan label
        const label = document.getElementById('labelPasien');
        label.style.display = 'inline-block';
        label.style.background = '#d1fae5';
        label.style.color = '#065f46';
        label.textContent = '✓ Pasien Lama — RM ' + p.nomor_rm;

        // Tutup hasil pencarian
        document.getElementById('hasilCari').style.display = 'none';
        document.getElementById('cariPasien').value = '';

        // Scroll ke form
        document.querySelector('.card-header').scrollIntoView({ behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('nomor_rm_lama').value = '';
        document.getElementById('nomorRMDisplay').value = nomoBaru;
        document.getElementById('rmLabel').textContent = '(otomatis untuk pasien baru)';
        document.getElementById('labelPasien').style.display = 'none';
    }

    // Enter untuk cari
    document.getElementById('cariPasien').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') { e.preventDefault(); cariPasienLama(); }
    });
</script>
@endpush