@extends('admin.layout')
@section('title', 'Pemeriksaan Lab')

@section('content')
<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
                Daftar Pemeriksaan Lab
            </div>
            <span style="font-size:12px; color:var(--text-light);">{{ $labs->count() }} pemeriksaan</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pemeriksaan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($labs as $l)
                    <tr>
                        <td style="font-weight:600;">{{ $l->nama }}</td>
                        <td style="color:var(--primary); font-weight:600;">Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $l->aktif ? 'badge-success' : 'badge-danger' }}">
                                {{ $l->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editLab({{ $l->id }}, '{{ addslashes($l->nama) }}', {{ $l->harga }}, {{ $l->aktif ? 1 : 0 }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('admin.lab.destroy', $l->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus pemeriksaan ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:32px; color:var(--text-light);">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="position:sticky; top:80px;">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">+ Tambah Pemeriksaan</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.lab.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Pemeriksaan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Darah Rutin" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 100000" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Simpan Pemeriksaan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            Edit Pemeriksaan Lab
            <button class="btn-close" onclick="tutupModal()">✕</button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Pemeriksaan</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="editHarga" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="aktif" id="editAktif" class="form-control">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModal()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editLab(id, nama, harga, aktif) {
    document.getElementById('formEdit').action = `/admin/lab/${id}`;
    document.getElementById('editNama').value  = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editAktif').value = aktif;
    document.getElementById('modalEdit').classList.add('show');
}
function tutupModal() {
    document.getElementById('modalEdit').classList.remove('show');
}
</script>
@endpush