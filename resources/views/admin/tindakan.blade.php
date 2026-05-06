@extends('admin.layout')
@section('title', 'Tindakan Medis')

@section('content')
<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

    {{-- Tabel --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Daftar Tindakan Medis
            </div>
            <span style="font-size:12px; color:var(--text-light);">{{ $tindakans->count() }} tindakan</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Tindakan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tindakans as $t)
                    <tr>
                        <td style="font-weight:600;">{{ $t->nama }}</td>
                        <td style="color:var(--primary); font-weight:600;">Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $t->aktif ? 'badge-success' : 'badge-danger' }}">
                                {{ $t->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:6px;">
                                <button onclick="editTindakan({{ $t->id }}, '{{ addslashes($t->nama) }}', {{ $t->harga }}, {{ $t->aktif ? 1 : 0 }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('admin.tindakan.destroy', $t->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus tindakan ini?')">
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

    {{-- Form Tambah --}}
    <div style="position:sticky; top:80px;">
        <div class="card">
            <div class="card-header">
                <div class="card-header-title">+ Tambah Tindakan</div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tindakan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Tindakan</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Nebulizer" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="Contoh: 80000" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Simpan Tindakan</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            Edit Tindakan
            <button class="btn-close" onclick="tutupModal()">✕</button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Tindakan</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" id="editHarga" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="aktif" class="form-control" id="editAktif">
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
function editTindakan(id, nama, harga, aktif) {
    document.getElementById('formEdit').action = `/admin/tindakan/${id}`;
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