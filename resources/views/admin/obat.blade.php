@extends('admin.layout')
@section('title', 'Manajemen Obat')

@section('content')
<div style="display:grid; grid-template-columns:1fr 380px; gap:20px; align-items:start;">

    {{-- Tabel --}}
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
                        <th>Satuan Jual</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($obats as $o)
                    <tr>
                        <td>
                            <div style="font-weight:600;">{{ $o->nama }}</div>
                            @if(($o->konversi ?? 1) > 1)
                            <div style="font-size:11px; color:var(--text-light); margin-top:2px;">
                                1 {{ $o->satuan_beli ?? $o->satuan }} = {{ $o->konversi ?? 1 }} {{ $o->satuan_jual ?? $o->satuan }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <span style="background:var(--bg); border:1px solid var(--border); padding:2px 8px; border-radius:6px; font-size:12px;">
                                per {{ $o->satuan_jual ?? $o->satuan }}
                            </span>
                        </td>
                        <td>
                            <span class="stok-badge" style="{{ $o->stok <= 0 ? 'background:#fee2e2;color:#991b1b;' : ($o->stok <= 10 ? 'background:#fef3cd;color:#856404;' : 'background:#d1fae5;color:#065f46;') }}">
                                {{ $o->stok }}
                            </span>
                            <div style="font-size:10px; color:var(--text-light); margin-top:2px;">{{ $o->satuan_jual ?? $o->satuan }}</div>
                        </td>
                        <td style="color:var(--text-mid);">
                            Rp {{ number_format($o->harga_beli, 0, ',', '.') }}
                            <div style="font-size:10px; color:var(--text-light);">per {{ $o->satuan_beli ?? $o->satuan }}</div>
                        </td>
                        <td>
                            @php
                                $konversi     = $o->konversi ?? 1;
                                $hargaPokok   = $konversi > 0 ? ceil($o->harga_beli / $konversi) : $o->harga_beli;
                                $ppn          = round($hargaPokok * 0.11);
                                $minJual      = $hargaPokok + $ppn;
                            @endphp
                        {{-- Warna harga jual --}}
                        <span style="font-weight:600; color:{{ $o->harga_jual <= $hargaPokok ? '#ef4444' : ($o->harga_jual < $minJual ? '#f59e0b' : 'var(--primary)') }};">
                            Rp {{ number_format($o->harga_jual, 0, ',', '.') }}
                        </span>
                        <div style="font-size:10px; color:var(--text-light);">per {{ $o->satuan_jual ?? $o->satuan }}</div>

                        @if($o->harga_jual <= $hargaPokok)
                            <div style="font-size:10px; color:#ef4444; font-weight:600;">⚠️ Rugi!</div>
                        @elseif($o->harga_jual < $minJual)
                            <div style="font-size:10px; color:#f59e0b; font-weight:600;">⚠️ Di bawah PPN</div>
                        @else
                            @php $untungTotal = ($o->harga_jual - $hargaPokok) * $konversi; @endphp
                            <div style="font-size:10px; color:#065f46; font-weight:600;">
                                +Rp {{ number_format($untungTotal, 0, ',', '.') }}/{{ $o->satuan_beli ?? 'pack' }}
                            </div>
                        @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                <button onclick="bukaModalStok(
                                    {{ $o->id }},
                                    '{{ addslashes($o->nama) }}',
                                    '{{ $o->satuan_beli ?? $o->satuan }}',
                                    '{{ $o->satuan_jual ?? $o->satuan }}',
                                    {{ $o->konversi ?? 1 }})"
                                    class="btn btn-sm btn-success">+ Stok</button>
                                <button onclick="bukaModalEdit(
                                    {{ $o->id }},
                                    '{{ addslashes($o->nama) }}',
                                    '{{ $o->satuan_beli ?? $o->satuan }}',
                                    '{{ $o->satuan_jual ?? $o->satuan }}',
                                    {{ $o->konversi ?? 1 }},
                                    {{ $o->stok }},
                                    {{ $o->harga_beli }},
                                    {{ $o->harga_jual }},
                                    {{ $o->aktif ? 1 : 0 }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('admin.obat.destroy', $o->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus obat {{ addslashes($o->nama) }}?')">
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

    {{-- Form Tambah --}}
    <div style="position:sticky; top:80px;">
        <div class="card">
            <div class="card-header"><div class="card-header-title">+ Tambah Obat Baru</div></div>
            <div class="card-body">
                <form action="{{ route('admin.obat.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Amoxicillin 500mg" required>
                    </div>

                    {{-- Satuan Beli --}}
                    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:14px; margin-bottom:12px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#1e40af; margin-bottom:10px;">
                            📦 Satuan Beli (dari Distributor)
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Satuan Beli</label>
                                <select name="satuan_beli" id="satuanBeliTambah" class="form-control" required onchange="updatePreviewTambah()">
                                    <option value="pack">Pack</option>
                                    <option value="dus">Dus</option>
                                    <option value="botol_besar">Botol Besar</option>
                                    <option value="karton">Karton</option>
                                    <option value="lusin">Lusin</option>
                                    <option value="pcs">Pcs</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stok Awal (satuan beli)</label>
                                <input type="number" name="stok" id="stokBeliTambah"
                                    class="form-control" placeholder="0" min="0" value="0"
                                    required oninput="updatePreviewTambah()">
                            </div>
                        </div>
                    </div>

                    {{-- Satuan Jual --}}
                    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px; margin-bottom:12px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#166534; margin-bottom:10px;">
                            🏷️ Satuan Jual (ke Pasien)
                        </div>
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Satuan Jual</label>
                                <select name="satuan_jual" id="satuanJualTambah" class="form-control" required onchange="updatePreviewTambah()">
                                    <option value="lembar">Lembar / Strip</option>
                                    <option value="botol">Botol</option>
                                    <option value="tablet">Tablet / Biji</option>
                                    <option value="kapsul">Kapsul</option>
                                    <option value="sachet">Sachet</option>
                                    <option value="tube">Tube</option>
                                    <option value="ampul">Ampul</option>
                                    <option value="pcs">Pcs</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Isi per Satuan Beli</label>
                                <input type="number" name="konversi" id="konversiTambah"
                                    class="form-control" placeholder="Contoh: 5" min="1" value="1"
                                    required oninput="updatePreviewTambah()">
                            </div>
                        </div>
                        <div style="font-size:11px; color:#166534; margin-top:2px;" id="konversiHintTambah">
                            1 pack = 1 lembar
                        </div>
                        <div id="previewStokTambah" style="display:none; background:#dcfce7; border-radius:8px; padding:8px 12px; font-size:12px; color:#166534; margin-top:8px; font-weight:600;">
                        </div>
                    </div>

                    {{-- Kalkulator Harga --}}
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px; margin-bottom:14px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#94a3b8; margin-bottom:12px;">
                            🧮 Kalkulator Harga
                        </div>

                        <div class="form-group">
                            <label class="form-label">Harga Beli per <span id="labelHargaBeliTambah" style="color:var(--primary); font-weight:700;">Pack</span> (Rp)</label>
                            <input type="number" name="harga_beli" id="hargaBeli"
                                class="form-control" placeholder="Contoh: 50000"
                                min="0" oninput="hitungHarga()" required>
                        </div>
                        <div id="breakdownHarga" style="display:none; background:#f1f5f9; border-radius:8px; padding:8px 12px; margin-top:6px;"></div>

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
                                <span>Harga Jual per <span id="labelHargaJualTambah" style="color:#166534; font-weight:700;">Lembar</span> (Rp)</span>
                                <span id="saranHarga" style="font-size:11px; color:#10b981; font-weight:600;"></span>
                            </label>
                            <input type="number" name="harga_jual" id="hargaJual"
                                class="form-control" placeholder="Input manual harga jual"
                                min="0" oninput="cekHargaJual()" required>
                        </div>

                        <div id="peringatanHarga" style="display:none; background:#fee2e2; border:1px solid #fca5a5; border-radius:8px; padding:10px 12px; font-size:12px; color:#991b1b; margin-top:8px;">
                            <div style="display:flex; align-items:flex-start; gap:8px;">
                                <span style="font-size:16px; flex-shrink:0;">⚠️</span>
                                <div>
                                    <div style="font-weight:700; margin-bottom:2px;">Harga jual terlalu rendah!</div>
                                    <div id="pesanPeringatan"></div>
                                </div>
                            </div>
                        </div>
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
<div class="modal-overlay" id="modalStokObat">
    <div class="modal">
        <div class="modal-header">
            Tambah Stok — <span id="stokNamaObat"></span>
            <button class="btn-close" onclick="tutupModalStok()">✕</button>
        </div>
        <form id="formStokObat" method="POST">
            @csrf
            <div class="modal-body">

                <div id="infoKonversiStok" style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:10px 14px; margin-bottom:14px; font-size:13px; color:#1e40af;">
                </div>

                <div class="form-group">
                    <label class="form-label">Input jumlah dalam satuan:</label>
                    <div style="display:flex; gap:10px; margin-bottom:14px;">
                        <label style="flex:1; display:flex; align-items:center; gap:8px; padding:10px 14px; border:2px solid #e2e8f0; border-radius:8px; cursor:pointer; transition:all 0.15s;" id="wrapSatuanBeli">
                            <input type="radio" name="satuan_input" value="beli" checked onchange="updateSatuanInput()">
                            <div>
                                <div style="font-weight:600; font-size:13px;" id="radioLabelBeli">Pack</div>
                                <div style="font-size:11px; color:#94a3b8;">Satuan beli</div>
                            </div>
                        </label>
                        <label style="flex:1; display:flex; align-items:center; gap:8px; padding:10px 14px; border:2px solid #e2e8f0; border-radius:8px; cursor:pointer; transition:all 0.15s;" id="wrapSatuanJualModal">
                            <input type="radio" name="satuan_input" value="jual" onchange="updateSatuanInput()">
                            <div>
                                <div style="font-weight:600; font-size:13px;" id="radioLabelJual">Lembar</div>
                                <div style="font-size:11px; color:#94a3b8;">Satuan jual</div>
                            </div>
                        </label>
                    </div>

                    <label class="form-label">Jumlah <span id="satuanInputLabel" style="color:var(--primary); font-weight:700;">Pack</span></label>
                    <input type="number" name="jumlah" id="jumlahStokInput"
                        class="form-control" placeholder="Contoh: 2" min="1"
                        required oninput="updatePreviewStok()">

                    <div id="previewHasilStok" style="display:none; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:8px 12px; font-size:12px; color:#166534; margin-top:8px; font-weight:600;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModalStok()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Obat --}}
<div class="modal-overlay" id="modalEditObat">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            Edit Obat
            <button class="btn-close" onclick="tutupModalEdit()">✕</button>
        </div>
        <form id="formEditObat" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="nama" id="editNama" class="form-control" required>
                </div>

                {{-- Satuan Beli Edit --}}
                <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px; margin-bottom:10px;">
                    <div style="font-size:11px; font-weight:700; color:#1e40af; margin-bottom:10px;">📦 SATUAN BELI</div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Satuan Beli</label>
                            <select name="satuan_beli" id="editSatuanBeli" class="form-control" onchange="updateHintEdit()">
                                <option value="pack">Pack</option>
                                <option value="dus">Dus</option>
                                <option value="botol_besar">Botol Besar</option>
                                <option value="karton">Karton</option>
                                <option value="lusin">Lusin</option>
                                <option value="pcs">Pcs</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Isi per Satuan Beli</label>
                            <input type="number" name="konversi" id="editKonversi"
                                class="form-control" min="1" required oninput="updateHintEdit()">
                        </div>
                    </div>
                    <div style="font-size:11px; color:#1e40af;" id="konversiHintEdit"></div>
                </div>

                {{-- Satuan Jual Edit --}}
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; margin-bottom:10px;">
                    <div style="font-size:11px; font-weight:700; color:#166534; margin-bottom:10px;">🏷️ SATUAN JUAL</div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Satuan Jual</label>
                            <select name="satuan_jual" id="editSatuanJual" class="form-control" onchange="updateHintEdit()">
                                <option value="lembar">Lembar / Strip</option>
                                <option value="botol">Botol</option>
                                <option value="tablet">Tablet / Biji</option>
                                <option value="kapsul">Kapsul</option>
                                <option value="sachet">Sachet</option>
                                <option value="tube">Tube</option>
                                <option value="ampul">Ampul</option>
                                <option value="pcs">Pcs</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stok (satuan jual)</label>
                            <input type="number" name="stok" id="editStok" class="form-control" min="0" required>
                        </div>
                    </div>
                </div>

                {{-- Harga Edit --}}
                <div class="form-group">
                    <label class="form-label">Harga Beli (Rp) per <span id="editLabelHargaBeli" style="color:var(--primary);">pack</span></label>
                    <input type="number" name="harga_beli" id="editHargaBeli"
                        class="form-control" min="0" required oninput="hitungHargaEdit()">
                </div>

                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; margin-bottom:10px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                        <div>
                            <div style="font-size:10px; color:#94a3b8;">PPN 11%</div>
                            <div style="font-size:12px; font-weight:600; color:#f59e0b;" id="editNilaiPPN">Rp 0</div>
                        </div>
                        <div>
                            <div style="font-size:10px; color:#94a3b8;">Dasar + PPN</div>
                            <div style="font-size:12px; font-weight:600; color:#1e40af;" id="editHargaPlusPPN">Rp 0</div>
                        </div>
                    </div>
                    <div id="editPeringatan" style="display:none; font-size:11px; color:#991b1b; background:#fee2e2; padding:6px 8px; border-radius:6px; margin-top:8px;">
                        ⚠️ <span id="editPesanPeringatan"></span>
                    </div>
                    <div id="editInfoOke" style="display:none; font-size:11px; color:#065f46; background:#d1fae5; padding:6px 8px; border-radius:6px; margin-top:8px;">
                        ✅ Harga jual sudah di atas harga dasar + PPN
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Harga Jual (Rp) per <span id="editLabelHargaJual" style="color:#166534;">lembar</span></label>
                    <input type="number" name="harga_jual" id="editHargaJual"
                        class="form-control" min="0" required oninput="cekHargaJualEdit()">
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
// ===== STATE MODAL STOK =====
let _satuanBeli = 'pack', _satuanJual = 'lembar', _konversi = 1;

function bukaModalStok(id, nama, satuanBeli, satuanJual, konversi) {
    _satuanBeli = satuanBeli; _satuanJual = satuanJual; _konversi = konversi;

    document.getElementById('formStokObat').action  = `/admin/obat/${id}/stok`;
    document.getElementById('stokNamaObat').textContent = nama;
    document.getElementById('infoKonversiStok').innerHTML =
        `📦 1 <strong>${satuanBeli.replace('_',' ')}</strong> = <strong>${konversi}</strong> ${satuanJual}`;
    document.getElementById('radioLabelBeli').textContent = satuanBeli.replace('_',' ');
    document.getElementById('radioLabelJual').textContent = satuanJual;
    document.querySelector('input[name="satuan_input"][value="beli"]').checked = true;
    document.getElementById('jumlahStokInput').value = '';
    document.getElementById('previewHasilStok').style.display = 'none';
    updateSatuanInput();
    document.getElementById('modalStokObat').classList.add('show');
}

function tutupModalStok() { document.getElementById('modalStokObat').classList.remove('show'); }

function updateSatuanInput() {
    const isBeli = document.querySelector('input[name="satuan_input"]:checked').value === 'beli';
    document.getElementById('satuanInputLabel').textContent = isBeli ? _satuanBeli.replace('_',' ') : _satuanJual;
    updatePreviewStok();
}

function updatePreviewStok() {
    const jumlah = parseInt(document.getElementById('jumlahStokInput').value) || 0;
    const isBeli = document.querySelector('input[name="satuan_input"]:checked').value === 'beli';
    const hasil  = isBeli ? jumlah * _konversi : jumlah;
    const el     = document.getElementById('previewHasilStok');
    if (jumlah > 0) {
        el.style.display = 'block';
        el.innerHTML = isBeli
            ? `📊 ${jumlah} ${_satuanBeli.replace('_',' ')} × ${_konversi} = <strong>${hasil} ${_satuanJual}</strong> masuk ke stok`
            : `📊 <strong>${hasil} ${_satuanJual}</strong> masuk ke stok`;
    } else {
        el.style.display = 'none';
    }
}

// ===== MODAL EDIT =====
function bukaModalEdit(id, nama, satuanBeli, satuanJual, konversi, stok, hargaBeli, hargaJual, aktif) {
    document.getElementById('formEditObat').action   = `/admin/obat/${id}`;
    document.getElementById('editNama').value        = nama;
    document.getElementById('editSatuanBeli').value  = satuanBeli;
    document.getElementById('editSatuanJual').value  = satuanJual;
    document.getElementById('editKonversi').value    = konversi;
    document.getElementById('editStok').value        = stok;
    document.getElementById('editHargaBeli').value   = hargaBeli;
    document.getElementById('editHargaJual').value   = hargaJual;
    document.getElementById('editAktif').value       = aktif;
    document.getElementById('modalEditObat').classList.add('show');
    updateHintEdit();
    hitungHargaEdit();
    cekHargaJualEdit();
}

function tutupModalEdit() { document.getElementById('modalEditObat').classList.remove('show'); }

function updateHintEdit() {
    const beli = document.getElementById('editSatuanBeli').value.replace('_',' ');
    const jual = document.getElementById('editSatuanJual').value;
    const konv = document.getElementById('editKonversi').value || 1;
    document.getElementById('konversiHintEdit').textContent = `1 ${beli} = ${konv} ${jual}`;
    document.getElementById('editLabelHargaBeli').textContent = beli;
    document.getElementById('editLabelHargaJual').textContent = jual;
}

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
    const elP = document.getElementById('editPeringatan');
    const elO = document.getElementById('editInfoOke');
    const elI = document.getElementById('editHargaJual');
    const elM = document.getElementById('editPesanPeringatan');

    elP.style.display = 'none'; elO.style.display = 'none';
    elI.style.borderColor = ''; elI.style.boxShadow = '';
    if (!hargaBeli || !hargaJual) return;

    let msg = '';
    if (hargaJual < hargaBeli)         msg = `Harga jual lebih rendah dari harga beli. RUGI!`;
    else if (hargaJual === hargaBeli)  msg = `Harga jual sama dengan harga beli. Tidak ada keuntungan!`;
    else if (hargaJual < hargaPlusPPN) msg = `Belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')}.`;

    if (msg) {
        elM.textContent = msg; elP.style.display = 'block'; elO.style.display = 'none';
        elI.style.borderColor = '#ef4444'; elI.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        elP.style.display = 'none'; elO.style.display = 'block';
        elI.style.borderColor = '#10b981'; elI.style.boxShadow = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}

// ===== FORM TAMBAH =====
function updatePreviewTambah() {
    const beli  = document.getElementById('satuanBeliTambah').value.replace('_',' ');
    const jual  = document.getElementById('satuanJualTambah').value;
    const konv  = parseInt(document.getElementById('konversiTambah').value) || 1;
    const stok  = parseInt(document.getElementById('stokBeliTambah').value) || 0;

    document.getElementById('konversiHintTambah').textContent = `1 ${beli} = ${konv} ${jual}`;
    document.getElementById('labelHargaBeliTambah').textContent = beli;
    document.getElementById('labelHargaJualTambah').textContent = jual;

    const prev = document.getElementById('previewStokTambah');
    if (stok > 0) {
        const hasil = stok * konv;
        prev.style.display = 'block';
        prev.innerHTML = `📊 ${stok} ${beli} × ${konv} = <strong>${hasil} ${jual}</strong> yang tersimpan di stok`;
    } else {
        prev.style.display = 'none';
    }
    hitungHarga();
}

function hitungHarga() {
    const hargaBeli    = parseInt(document.getElementById('hargaBeli').value) || 0;
    const konversi     = parseInt(document.getElementById('konversiTambah').value) || 1;

    // Harga pokok per satuan JUAL
    const hargaPerJual = konversi > 0 ? Math.ceil(hargaBeli / konversi) : hargaBeli;
    const ppn          = Math.round(hargaPerJual * 0.11);
    const hargaPlusPPN = hargaPerJual + ppn;

    document.getElementById('nilaiPPN').textContent     = 'Rp ' + ppn.toLocaleString('id-ID');
    document.getElementById('hargaPlusPPN').textContent = 'Rp ' + hargaPlusPPN.toLocaleString('id-ID');
    document.getElementById('saranHarga').textContent   = hargaBeli > 0
        ? 'Min. Rp ' + hargaPlusPPN.toLocaleString('id-ID') : '';

    // Tampilkan breakdown
    const jual = document.getElementById('satuanJualTambah').value;
    const beli = document.getElementById('satuanBeliTambah').value.replace('_',' ');
    document.getElementById('breakdownHarga').style.display = hargaBeli > 0 ? 'block' : 'none';
    document.getElementById('breakdownHarga').innerHTML = `
        <div style="font-size:11px; color:#475569; line-height:1.8;">
            Rp ${hargaBeli.toLocaleString('id-ID')} ÷ ${konversi} ${jual} 
            = <strong>Rp ${hargaPerJual.toLocaleString('id-ID')}</strong> / ${jual} (harga pokok)
        </div>`;

    cekHargaJual();
}

function cekHargaJual() {
    const hargaBeli    = parseInt(document.getElementById('hargaBeli').value) || 0;
    const hargaJual    = parseInt(document.getElementById('hargaJual').value) || 0;
    const konversi     = parseInt(document.getElementById('konversiTambah').value) || 1;
    const jual         = document.getElementById('satuanJualTambah').value;

    // Harga pokok per satuan jual
    const hargaPerJual = konversi > 0 ? Math.ceil(hargaBeli / konversi) : hargaBeli;
    const ppn          = Math.round(hargaPerJual * 0.11);
    const hargaPlusPPN = hargaPerJual + ppn;

    const elP = document.getElementById('peringatanHarga');
    const elO = document.getElementById('infoHargaOke');
    const elI = document.getElementById('hargaJual');
    const elM = document.getElementById('pesanPeringatan');

    elP.style.display = 'none'; elO.style.display = 'none';
    elI.style.borderColor = ''; elI.style.boxShadow = '';
    if (!hargaBeli || !hargaJual) return;

    // Hitung keuntungan total
    const untungPerJual = hargaJual - hargaPerJual;
    const untungTotal   = untungPerJual * konversi;

    let msg = '';
    if (hargaJual < hargaPerJual) {
        msg = `Harga jual per ${jual} (Rp ${hargaJual.toLocaleString('id-ID')}) lebih rendah dari harga pokok per ${jual} (Rp ${hargaPerJual.toLocaleString('id-ID')}). RUGI!`;
    } else if (hargaJual === hargaPerJual) {
        msg = `Harga jual sama dengan harga pokok. Tidak ada keuntungan!`;
    } else if (hargaJual < hargaPlusPPN) {
        msg = `Belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')} per ${jual}.`;
    }

    if (msg) {
        elM.textContent = msg; elP.style.display = 'block';
        elI.style.borderColor = '#ef4444'; elI.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        // Tampilkan keuntungan
        elO.style.display = 'block';
        elO.innerHTML = `✅ Untung Rp ${untungPerJual.toLocaleString('id-ID')} per ${jual} 
            × ${konversi} = <strong>Rp ${untungTotal.toLocaleString('id-ID')} per pack</strong>`;
        elI.style.borderColor = '#10b981'; elI.style.boxShadow = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}

// Init saat load
updatePreviewTambah();
</script>
@endpush