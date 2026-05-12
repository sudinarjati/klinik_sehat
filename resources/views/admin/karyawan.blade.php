@extends('admin.layout')
@section('title', 'Manajemen Karyawan')

@section('content')
<div style="display:grid; grid-template-columns:1fr 360px; gap:20px; align-items:start;">

    {{-- Tabel Karyawan --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                Daftar Karyawan
            </div>
            <span style="font-size:12px; color:var(--text-light);">{{ $karyawans->count() }} karyawan</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Peran</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $k)
                    <tr>
                        <td style="font-weight:600;">{{ $k->nama_lengkap }}</td>
                        <td>
                            <span style="background:var(--bg); border:1px solid var(--border); padding:2px 8px; border-radius:6px; font-family:monospace; font-size:12px;">
                                {{ $k->username }}
                            </span>
                        </td>
                        <td>
                            @php
                                $warna = match($k->peran) {
                                    'pendaftaran'       => 'background:#e0f2fe; color:#0369a1;',
                                    'dokter'            => 'background:#d1fae5; color:#065f46;',
                                    'kasir'             => 'background:#fef3cd; color:#856404;',
                                    'apoteker'          => 'background:#fdf4ff; color:#7e22ce;',
                                    'pendaftaran_kasir' => 'background:#f0fdf4; color:#166534;',
                                    default             => 'background:#f3f4f6; color:#374151;',
                                };
                                $icon = match($k->peran) {
                                    'pendaftaran'       => '🗂️',
                                    'dokter'            => '🩺',
                                    'kasir'             => '💳',
                                    'apoteker'          => '💊',
                                    'pendaftaran_kasir' => '🗂️💳',
                                    default             => '👤',
                                };
                                $labelPeran = match($k->peran) {
                                    'pendaftaran'       => 'Pendaftaran',
                                    'dokter'            => 'Dokter',
                                    'kasir'             => 'Kasir',
                                    'apoteker'          => 'Apoteker',
                                    'pendaftaran_kasir' => 'Pendaftaran & Kasir',
                                    default             => ucfirst($k->peran),
                                };
                            @endphp
                            <span style="display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; {{ $warna }}">
                                {{ $icon }} {{ $labelPeran }}
                            </span>
                        </td>
                        <td style="font-size:12px; color:var(--text-light);">
                            {{ $k->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button class="btn btn-sm btn-warning"
                                    data-id="{{ $k->id }}"
                                    data-nama="{{ $k->nama_lengkap }}"
                                    data-username="{{ $k->username }}"
                                    data-peran="{{ $k->peran }}"
                                    onclick="editKaryawan(this)">Edit</button>
                                <form action="{{ route('admin.karyawan.destroy', $k->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus karyawan {{ addslashes($k->nama_lengkap) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:32px; color:var(--text-light);">
                            Belum ada karyawan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Form Tambah --}}
    <div style="position:sticky; top:80px;">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">+ Tambah Karyawan</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.karyawan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                            placeholder="Contoh: Dr. Budi Santoso"
                            value="{{ old('nama_lengkap') }}" required>
                        @error('nama_lengkap')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Peran</label>
                        <select name="peran" class="form-control" required>
                            <option value="">Pilih peran</option>
                            <option value="pendaftaran"       {{ old('peran') === 'pendaftaran'       ? 'selected' : '' }}>🗂️ Pendaftaran</option>
                            <option value="dokter"            {{ old('peran') === 'dokter'            ? 'selected' : '' }}>🩺 Dokter</option>
                            <option value="kasir"             {{ old('peran') === 'kasir'             ? 'selected' : '' }}>💳 Kasir</option>
                            <option value="apoteker"          {{ old('peran') === 'apoteker'          ? 'selected' : '' }}>💊 Apoteker</option>
                            <option value="pendaftaran_kasir" {{ old('peran') === 'pendaftaran_kasir' ? 'selected' : '' }}>🗂️💳 Pendaftaran & Kasir (Double Job)</option>
                        </select>
                        @error('peran')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control"
                            placeholder="Contoh: dr.budi atau dr_budi"
                            value="{{ old('username') }}" required>
                        <div style="font-size:11px; color:var(--text-light); margin-top:4px;">
                            Huruf, angka, titik atau underscore. <strong>Tanpa spasi.</strong>
                        </div>
                        @error('username')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="passwordTambah"
                                class="form-control" placeholder="Minimal 6 karakter" required>
                            <button type="button" onclick="togglePassword('passwordTambah', this)"
                                style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                       background:none; border:none; cursor:pointer;
                                       color:var(--text-light); font-size:12px; font-weight:600; font-family:inherit;">
                                Lihat
                            </button>
                        </div>
                        @error('password')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Simpan Karyawan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEditKaryawan">
    <div class="modal">
        <div class="modal-header">
            Edit Karyawan
            <button class="btn-close" onclick="tutupModalKaryawan()">✕</button>
        </div>
        <form id="formEditKaryawan" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="editNamaKaryawan"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Peran</label>
                    <select name="peran" id="editPeranKaryawan" class="form-control" required>
                        <option value="pendaftaran">🗂️ Pendaftaran</option>
                        <option value="dokter">🩺 Dokter</option>
                        <option value="kasir">💳 Kasir</option>
                        <option value="apoteker">💊 Apoteker</option>
                        <option value="pendaftaran_kasir">🗂️💳 Pendaftaran & Kasir (Double Job)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" id="editUsernameKaryawan"
                        class="form-control" required>
                    <div style="font-size:11px; color:var(--text-light); margin-top:4px;">
                        Tanpa spasi.
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Password Baru
                        <span style="font-size:11px; font-weight:400; color:var(--text-light);">
                            (kosongkan jika tidak diubah)
                        </span>
                    </label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="passwordEdit"
                            class="form-control" placeholder="Minimal 6 karakter">
                        <button type="button" onclick="togglePassword('passwordEdit', this)"
                            style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                   background:none; border:none; cursor:pointer;
                                   color:var(--text-light); font-size:12px; font-weight:600; font-family:inherit;">
                            Lihat
                        </button>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModalKaryawan()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editKaryawan(btn) {
    const id       = btn.getAttribute('data-id');
    const nama     = btn.getAttribute('data-nama');
    const username = btn.getAttribute('data-username');
    const peran    = btn.getAttribute('data-peran');

    document.getElementById('formEditKaryawan').action    = `/admin/karyawan/${id}`;
    document.getElementById('editNamaKaryawan').value     = nama;
    document.getElementById('editUsernameKaryawan').value = username;
    document.getElementById('editPeranKaryawan').value    = peran;
    document.getElementById('passwordEdit').value         = '';
    document.getElementById('modalEditKaryawan').classList.add('show');
}

function tutupModalKaryawan() {
    document.getElementById('modalEditKaryawan').classList.remove('show');
}

function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type   = 'text';
        btn.textContent = 'Sembunyikan';
    } else {
        input.type   = 'password';
        btn.textContent = 'Lihat';
    }
}

// Validasi username tanpa spasi
document.querySelectorAll('input[name="username"]').forEach(input => {
    input.addEventListener('input', function() {
        const warn = this.parentElement.querySelector('.username-warn');
        if (this.value.includes(' ')) {
            this.style.borderColor = '#ef4444';
            this.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.15)';
            if (!warn) {
                const el = document.createElement('div');
                el.className     = 'username-warn';
                el.style.cssText = 'font-size:12px; color:#991b1b; margin-top:4px;';
                el.textContent   = '⚠️ Username tidak boleh mengandung spasi!';
                this.parentElement.appendChild(el);
            }
        } else {
            this.style.borderColor = '';
            this.style.boxShadow   = '';
            if (warn) warn.remove();
        }
    });
});
</script>
@endpush