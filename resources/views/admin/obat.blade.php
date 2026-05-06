@extends('admin.layout')
@section('title', 'Manajemen Obat')

@section('content')
<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/></svg>
                Daftar Obat
            </div>
            <span style="font-size:12px; color:var(--text-light);">{{ $obats->count() }} jenis obat</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obats as $o)
                    <tr>
                        <td style="font-weight:600;">{{ $o->nama }}</td>
                        <td>{{ $o->satuan }}</td>
                        <td>
                            <span class="stok-badge" style="{{ $o->stok <= 5 ? 'background:#fee2e2;color:#991b1b;' : ($o->stok <= 10 ? 'background:#fef3cd;color:#856404;' : 'background:#d1fae5;color:#065f46;') }}">
                                {{ $o->stok }}
                            </span>
                        </td>
                        <td style="color:var(--text-mid);">Rp {{ number_format($o->harga_beli, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $ppn = round($o->harga_beli * 0.11);
                                $minJual = $o->harga_beli + $ppn;
                            @endphp
                            <span style="font-weight:600; color:{{ $o->harga_jual <= $o->harga_beli ? '#ef4444' : ($o->harga_jual < $minJual ? '#f59e0b' : 'var(--primary)') }};">
                                Rp {{ number_format($o->harga_jual, 0, ',', '.') }}
                            </span>
                            @if($o->harga_jual <= $o->harga_beli)
                                <div style="font-size:10px; color:#ef4444; font-weight:600;">⚠️ Rugi!</div>
                            @elseif($o->harga_jual < $minJual)
                                <div style="font-size:10px; color:#f59e0b; font-weight:600;">⚠️ Di bawah PPN</div>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                <button onclick="tambahStok({{ $o->id }}, '{{ addslashes($o->nama) }}', '{{ $o->satuan }}')"
                                    class="btn btn-sm btn-success">+ Stok</button>
                                <button onclick="editObat({{ $o->id }}, '{{ addslashes($o->nama) }}', '{{ $o->satuan }}', {{ $o->stok }}, {{ $o->harga_beli }}, {{ $o->harga_jual }}, {{ $o->aktif ? 1 : 0 }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('admin.obat.destroy', $o->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus obat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center; padding:32px; color:var(--text-light);">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="position:sticky; top:80px;">
        <div class="card">
            <div class="card-header"><div class="card-header-title">+ Tambah Obat Baru</div></div>
            <div class="card-body">
                <form action="{{ route('admin.obat.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Paracetamol 500mg" required>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Satuan</label>
                            <select name="satuan" class="form-control" required>
                                <option value="tablet">Tablet</option>
                                <option value="kapsul">Kapsul</option>
                                <option value="botol">Botol</option>
                                <option value="sachet">Sachet</option>
                                <option value="tube">Tube</option>
                                <option value="ampul">Ampul</option>
                                <option value="vial">Vial</option>
                                <option value="strip">Strip</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" name="stok" class="form-control" placeholder="0" min="0" value="0" required>
                        </div>
                    </div>

                    {{-- Kalkulator Harga --}}
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px; margin-bottom:14px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#94a3b8; margin-bottom:12px;">
                            🧮 Kalkulator Harga
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga Beli / Harga Dasar (Rp)</label>
                            <input type="number" name="harga_beli" id="hargaBeli"
                                class="form-control" placeholder="Contoh: 3250"
                                min="0" oninput="hitungHarga()" required>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                            <div>
                                <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">PPN 11%</div>
                                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; font-weight:600; color:#f59e0b;" id="nilaiPPN">Rp 0</div>
                            </div>
                            <div>
                                <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">Harga Dasar + PPN</div>
                                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; font-weight:600; color:#1e40af;" id="hargaPlusPPN">Rp 0</div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:6px;">
                            <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
                                <span>Harga Jual (Rp) <span style="color:#ef4444;">*</span></span>
                                <span id="saranHarga" style="font-size:11px; color:#10b981; font-weight:600;"></span>
                            </label>
                            <input type="number" name="harga_jual" id="hargaJual"
                                class="form-control" placeholder="Input manual harga jual"
                                min="0" oninput="cekHargaJual()" required>
                        </div>

                        {{-- Peringatan harga jual di bawah PPN --}}
                        <div id="peringatanHarga" style="display:none; background:#fee2e2; border:1px solid #fca5a5; border-radius:8px; padding:10px 12px; font-size:12px; color:#991b1b; margin-top:8px;">
                            <div style="display:flex; align-items:flex-start; gap:8px;">
                                <span style="font-size:16px; flex-shrink:0;">⚠️</span>
                                <div>
                                    <div style="font-weight:700; margin-bottom:2px;">Harga jual terlalu rendah!</div>
                                    <div id="pesanPeringatan"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Info harga oke --}}
                        <div id="infoHargaOke" style="display:none; background:#d1fae5; border:1px solid #a7f3d0; border-radius:8px; padding:8px 12px; font-size:12px; color:#065f46; margin-top:8px;">
                            ✅ Harga jual sudah di atas harga dasar + PPN
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Simpan Obat</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Stok --}}
<div class="modal-overlay" id="modalStok">
    <div class="modal">
        <div class="modal-header">
            Tambah Stok — <span id="stokNama"></span>
            <button class="btn-close" onclick="tutupModal()">✕</button>
        </div>
        <form id="formStok" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Jumlah Tambah Stok</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 100" min="1" required>
                    <div style="font-size:12px; color:var(--text-light); margin-top:4px;" id="stokSatuan"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModal()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Obat --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <div class="modal-header">
            Edit Obat
            <button class="btn-close" onclick="tutupModalEdit()">✕</button>
        </div>
        <form id="formEdit" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" id="editSatuan" class="form-control">
                            <option value="tablet">Tablet</option>
                            <option value="kapsul">Kapsul</option>
                            <option value="botol">Botol</option>
                            <option value="sachet">Sachet</option>
                            <option value="tube">Tube</option>
                            <option value="ampul">Ampul</option>
                            <option value="vial">Vial</option>
                            <option value="strip">Strip</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" id="editStok" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Harga Beli (Rp)</label>
                        <input type="number" name="harga_beli" id="editHargaBeli" class="form-control" min="0" required oninput="hitungHargaEdit()">
                    </div>
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; margin-bottom:10px;">
                        <div style="font-size:11px; color:#94a3b8; margin-bottom:6px; font-weight:600;">🧮 Kalkulasi Harga</div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:8px;">
                            <div>
                                <div style="font-size:10px; color:#94a3b8;">PPN 11%</div>
                                <div style="font-size:12px; font-weight:600; color:#f59e0b;" id="editNilaiPPN">Rp 0</div>
                            </div>
                            <div>
                                <div style="font-size:10px; color:#94a3b8;">Dasar + PPN</div>
                                <div style="font-size:12px; font-weight:600; color:#1e40af;" id="editHargaPlusPPN">Rp 0</div>
                            </div>
                        </div>
                        <div id="editPeringatan" style="display:none; font-size:11px; color:#991b1b; background:#fee2e2; padding:6px 8px; border-radius:6px;">
                            ⚠️ <span id="editPesanPeringatan"></span>
                        </div>
                        <div id="editInfoOke" style="display:none; font-size:11px; color:#065f46; background:#d1fae5; padding:6px 8px; border-radius:6px;">
                            ✅ Harga jual sudah di atas harga dasar + PPN
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="form-label">Harga Jual (Rp)</label>
                        <input type="number" name="harga_jual" id="editHargaJual" class="form-control" min="0" required oninput="cekHargaJualEdit()">
                    </div>
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
                <button type="button" onclick="tutupModalEdit()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function tambahStok(id, nama, satuan) {
    document.getElementById('formStok').action = `/admin/obat/${id}/stok`;
    document.getElementById('stokNama').textContent = nama;
    document.getElementById('stokSatuan').textContent = `Satuan: ${satuan}`;
    document.getElementById('modalStok').classList.add('show');
}

function editObat(id, nama, satuan, stok, hargaBeli, hargaJual, aktif) {
    document.getElementById('formEdit').action     = `/admin/obat/${id}`;
    document.getElementById('editNama').value      = nama;
    document.getElementById('editSatuan').value    = satuan;
    document.getElementById('editStok').value      = stok;
    document.getElementById('editHargaBeli').value = hargaBeli;
    document.getElementById('editHargaJual').value = hargaJual;
    document.getElementById('editAktif').value     = aktif;
    document.getElementById('modalEdit').classList.add('show');
    hitungHargaEdit();
    cekHargaJualEdit();
}

function tutupModal()     { document.getElementById('modalStok').classList.remove('show'); }
function tutupModalEdit() { document.getElementById('modalEdit').classList.remove('show'); }

// ============ FORM TAMBAH ============
function hitungHarga() {
    const hargaBeli    = parseInt(document.getElementById('hargaBeli').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;

    document.getElementById('nilaiPPN').textContent     = 'Rp ' + ppn.toLocaleString('id-ID');
    document.getElementById('hargaPlusPPN').textContent = 'Rp ' + hargaPlusPPN.toLocaleString('id-ID');
    document.getElementById('saranHarga').textContent   = hargaBeli > 0
        ? 'Min. Rp ' + hargaPlusPPN.toLocaleString('id-ID') : '';

    cekHargaJual();
}

function cekHargaJual() {
    const hargaBeli    = parseInt(document.getElementById('hargaBeli').value) || 0;
    const hargaJual    = parseInt(document.getElementById('hargaJual').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;

    const elPeringatan = document.getElementById('peringatanHarga');
    const elOke        = document.getElementById('infoHargaOke');
    const elInput      = document.getElementById('hargaJual');
    const elPesan      = document.getElementById('pesanPeringatan');

    // Reset semua
    elPeringatan.style.display = 'none';
    elOke.style.display        = 'none';
    elInput.style.borderColor  = '';
    elInput.style.boxShadow    = '';

    if (hargaBeli === 0 || hargaJual === 0) return;

    let pesanText = '';

    if (hargaJual < hargaBeli) {
        pesanText = `Harga jual (Rp ${hargaJual.toLocaleString('id-ID')}) lebih rendah dari harga beli (Rp ${hargaBeli.toLocaleString('id-ID')}). Anda pasti RUGI!`;
    } else if (hargaJual === hargaBeli) {
        pesanText = `Harga jual sama dengan harga beli (Rp ${hargaBeli.toLocaleString('id-ID')}). Tidak ada keuntungan sama sekali!`;
    } else if (hargaJual < hargaPlusPPN) {
        const selisih = hargaPlusPPN - hargaJual;
        pesanText = `Harga jual belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')} — masih kurang Rp ${selisih.toLocaleString('id-ID')}.`;
    }

    if (pesanText) {
        elPesan.textContent        = pesanText;
        elPeringatan.style.display = 'block';
        elInput.style.borderColor  = '#ef4444';
        elInput.style.boxShadow    = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        elOke.style.display       = 'block';
        elInput.style.borderColor = '#10b981';
        elInput.style.boxShadow   = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}

// ============ MODAL EDIT ============
function hitungHargaEdit() {
    const hargaBeli    = parseInt(document.getElementById('editHargaBeli').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;

    document.getElementById('editNilaiPPN').textContent     = 'Rp ' + ppn.toLocaleString('id-ID');
    document.getElementById('editHargaPlusPPN').textContent = 'Rp ' + hargaPlusPPN.toLocaleString('id-ID');
    cekHargaJualEdit();
}

function cekHargaJualEdit() {
    const hargaBeli    = parseInt(document.getElementById('editHargaBeli').value) || 0;
    const hargaJual    = parseInt(document.getElementById('editHargaJual').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;

    const elPeringatan = document.getElementById('editPeringatan');
    const elOke        = document.getElementById('editInfoOke');
    const elInput      = document.getElementById('editHargaJual');
    const elPesan      = document.getElementById('editPesanPeringatan');

    // Reset semua
    elPeringatan.style.display = 'none';
    elOke.style.display        = 'none';
    elInput.style.borderColor  = '';
    elInput.style.boxShadow    = '';

    if (hargaBeli === 0 || hargaJual === 0) return;

    let pesanText = '';

    if (hargaJual < hargaBeli) {
        pesanText = `Harga jual lebih rendah dari harga beli. Anda pasti RUGI!`;
    } else if (hargaJual === hargaBeli) {
        pesanText = `Harga jual sama dengan harga beli. Tidak ada keuntungan!`;
    } else if (hargaJual < hargaPlusPPN) {
        const selisih = hargaPlusPPN - hargaJual;
        pesanText = `Belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')} — kurang Rp ${selisih.toLocaleString('id-ID')}.`;
    }

    if (pesanText) {
        elPesan.textContent        = pesanText;
        elPeringatan.style.display = 'block';
        elOke.style.display        = 'none';
        elInput.style.borderColor  = '#ef4444';
        elInput.style.boxShadow    = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        elPeringatan.style.display = 'none';
        elOke.style.display        = 'block';
        elInput.style.borderColor  = '#10b981';
        elInput.style.boxShadow    = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}
</script>
@endpush