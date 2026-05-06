@extends('admin.layout')
@section('title', 'Alat Kesehatan')

@section('content')
<div style="display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start;">

    {{-- Tabel --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                Daftar Alat Kesehatan
            </div>
            <span style="font-size:12px; color:var(--text-light);">{{ $alkes->count() }} jenis alkes</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Alkes</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alkes as $a)
                    <tr>
                        <td style="font-weight:600;">{{ $a->nama }}</td>
                        <td>{{ $a->satuan }}</td>
                        <td>
                            <span class="stok-badge" style="{{ $a->stok <= 5 ? 'background:#fee2e2;color:#991b1b;' : ($a->stok <= 10 ? 'background:#fef3cd;color:#856404;' : 'background:#d1fae5;color:#065f46;') }}">
                                {{ $a->stok }}
                            </span>
                        </td>
                        <td style="color:var(--text-mid);">Rp {{ number_format($a->harga_beli, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $ppn = round($a->harga_beli * 0.11);
                                $minJual = $a->harga_beli + $ppn;
                            @endphp
                            <span style="font-weight:600; color:{{ $a->harga_jual <= $a->harga_beli ? '#ef4444' : ($a->harga_jual < $minJual ? '#f59e0b' : 'var(--primary)') }};">
                                Rp {{ number_format($a->harga_jual, 0, ',', '.') }}
                            </span>
                            @if($a->harga_jual <= $a->harga_beli)
                                <div style="font-size:10px; color:#ef4444; font-weight:600;">⚠️ Rugi!</div>
                            @elseif($a->harga_jual < $minJual)
                                <div style="font-size:10px; color:#f59e0b; font-weight:600;">⚠️ Di bawah PPN</div>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:5px; flex-wrap:wrap;">
                                {{-- PERBAIKAN: nama fungsi konsisten --}}
                                <button onclick="bukaModalStok({{ $a->id }}, '{{ addslashes($a->nama) }}', '{{ $a->satuan }}')"
                                    class="btn btn-sm btn-success">+ Stok</button>
                                <button onclick="bukaModalEdit({{ $a->id }}, '{{ addslashes($a->nama) }}', '{{ $a->satuan }}', {{ $a->stok }}, {{ $a->harga_beli }}, {{ $a->harga_jual }}, {{ $a->aktif ? 1 : 0 }})"
                                    class="btn btn-sm btn-warning">Edit</button>
                                <form action="{{ route('admin.alkes.destroy', $a->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus alkes ini?')">
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
            <div class="card-header"><div class="card-header-title">+ Tambah Alkes Baru</div></div>
            <div class="card-body">
                <form action="{{ route('admin.alkes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Alkes</label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Masker Bedah" required>
                    </div>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Satuan</label>
                            <select name="satuan" class="form-control" required>
                                <option value="buah">Buah</option>
                                <option value="botol">Botol</option>
                                <option value="box">Box</option>
                                <option value="pack">Pack</option>
                                <option value="lembar">Lembar</option>
                                <option value="roll">Roll</option>
                                <option value="set">Set</option>
                                <option value="pasang">Pasang</option>
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
                            <input type="number" name="harga_beli" id="alkesHargaBeli"
                                class="form-control" placeholder="Contoh: 5000"
                                min="0" oninput="hitungHargaAlkes()" required>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                            <div>
                                <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">PPN 11%</div>
                                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; font-weight:600; color:#f59e0b;" id="alkesNilaiPPN">Rp 0</div>
                            </div>
                            <div>
                                <div style="font-size:11px; color:#94a3b8; margin-bottom:4px;">Harga Dasar + PPN</div>
                                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; font-size:13px; font-weight:600; color:#1e40af;" id="alkesHargaPlusPPN">Rp 0</div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom:6px;">
                            <label class="form-label" style="display:flex; justify-content:space-between; align-items:center;">
                                <span>Harga Jual (Rp) <span style="color:#ef4444;">*</span></span>
                                <span id="alkesSaranHarga" style="font-size:11px; color:#10b981; font-weight:600;"></span>
                            </label>
                            <input type="number" name="harga_jual" id="alkesHargaJual"
                                class="form-control" placeholder="Input manual harga jual"
                                min="0" oninput="cekHargaJualAlkes()" required>
                        </div>
                        <div id="alkesPeringatanHarga" style="display:none; background:#fee2e2; border:1px solid #fca5a5; border-radius:8px; padding:10px 12px; font-size:12px; color:#991b1b; margin-top:8px;">
                            <div style="display:flex; align-items:flex-start; gap:8px;">
                                <span style="font-size:16px; flex-shrink:0;">⚠️</span>
                                <div>
                                    <div style="font-weight:700; margin-bottom:2px;">Harga jual terlalu rendah!</div>
                                    <div id="alkesPesanPeringatan"></div>
                                </div>
                            </div>
                        </div>
                        <div id="alkesInfoHargaOke" style="display:none; background:#d1fae5; border:1px solid #a7f3d0; border-radius:8px; padding:8px 12px; font-size:12px; color:#065f46; margin-top:8px;">
                            ✅ Harga jual sudah di atas harga dasar + PPN
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full">Simpan Alkes</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Stok --}}
<div class="modal-overlay" id="modalStokAlkes">
    <div class="modal">
        <div class="modal-header">
            Tambah Stok — <span id="stokNamaAlkes"></span>
            <button class="btn-close" onclick="tutupModalStok()">✕</button>
        </div>
        <form id="formStokAlkes" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Jumlah Tambah Stok</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 50" min="1" required>
                    <div style="font-size:12px; color:var(--text-light); margin-top:4px;" id="stokSatuanAlkes"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tutupModalStok()" class="btn btn-outline">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Stok</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modalEditAlkes">
    <div class="modal">
        <div class="modal-header">
            Edit Alkes
            <button class="btn-close" onclick="tutupModalEdit()">✕</button>
        </div>
        <form id="formEditAlkes" method="POST">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Alkes</label>
                    <input type="text" name="nama" id="editNamaAlkes" class="form-control" required>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" id="editSatuanAlkes" class="form-control">
                            <option value="buah">Buah</option>
                            <option value="botol">Botol</option>
                            <option value="box">Box</option>
                            <option value="pack">Pack</option>
                            <option value="lembar">Lembar</option>
                            <option value="roll">Roll</option>
                            <option value="set">Set</option>
                            <option value="pasang">Pasang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" id="editStokAlkes" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Beli (Rp)</label>
                    <input type="number" name="harga_beli" id="editHargaBeliAlkes" class="form-control" min="0" required oninput="hitungHargaEditAlkes()">
                </div>
                {{-- Kalkulator Edit --}}
                <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:10px; margin-bottom:12px;">
                    <div style="font-size:11px; color:#94a3b8; margin-bottom:6px; font-weight:600;">🧮 Kalkulasi Harga</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:8px;">
                        <div>
                            <div style="font-size:10px; color:#94a3b8;">PPN 11%</div>
                            <div style="font-size:12px; font-weight:600; color:#f59e0b;" id="editNilaiPPNAlkes">Rp 0</div>
                        </div>
                        <div>
                            <div style="font-size:10px; color:#94a3b8;">Dasar + PPN</div>
                            <div style="font-size:12px; font-weight:600; color:#1e40af;" id="editHargaPlusPPNAlkes">Rp 0</div>
                        </div>
                    </div>
                    <div id="editPeringatanAlkes" style="display:none; font-size:11px; color:#991b1b; background:#fee2e2; padding:6px 8px; border-radius:6px;">
                        ⚠️ <span id="editPesanPeringatanAlkes"></span>
                    </div>
                    <div id="editInfoOkeAlkes" style="display:none; font-size:11px; color:#065f46; background:#d1fae5; padding:6px 8px; border-radius:6px;">
                        ✅ Harga jual sudah di atas harga dasar + PPN
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" id="editHargaJualAlkes" class="form-control" min="0" required oninput="cekHargaJualEditAlkes()">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="aktif" id="editAktifAlkes" class="form-control">
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
function bukaModalStok(id, nama, satuan) {
    document.getElementById('formStokAlkes').action  = `/admin/alkes/${id}/stok`;
    document.getElementById('stokNamaAlkes').textContent   = nama;
    document.getElementById('stokSatuanAlkes').textContent = `Satuan: ${satuan}`;
    document.getElementById('modalStokAlkes').classList.add('show');
}

function bukaModalEdit(id, nama, satuan, stok, hargaBeli, hargaJual, aktif) {
    document.getElementById('formEditAlkes').action       = `/admin/alkes/${id}`;
    document.getElementById('editNamaAlkes').value        = nama;
    document.getElementById('editSatuanAlkes').value      = satuan;
    document.getElementById('editStokAlkes').value        = stok;
    document.getElementById('editHargaBeliAlkes').value   = hargaBeli;
    document.getElementById('editHargaJualAlkes').value   = hargaJual;
    document.getElementById('editAktifAlkes').value       = aktif;
    document.getElementById('modalEditAlkes').classList.add('show');
    hitungHargaEditAlkes();
    cekHargaJualEditAlkes();
}

function tutupModalStok() { document.getElementById('modalStokAlkes').classList.remove('show'); }
function tutupModalEdit() { document.getElementById('modalEditAlkes').classList.remove('show'); }

// ============ FORM TAMBAH ============
function hitungHargaAlkes() {
    const hargaBeli    = parseInt(document.getElementById('alkesHargaBeli').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;
    document.getElementById('alkesNilaiPPN').textContent     = 'Rp ' + ppn.toLocaleString('id-ID');
    document.getElementById('alkesHargaPlusPPN').textContent = 'Rp ' + hargaPlusPPN.toLocaleString('id-ID');
    document.getElementById('alkesSaranHarga').textContent   = hargaBeli > 0 ? 'Min. Rp ' + hargaPlusPPN.toLocaleString('id-ID') : '';
    cekHargaJualAlkes();
}

function cekHargaJualAlkes() {
    const hargaBeli    = parseInt(document.getElementById('alkesHargaBeli').value) || 0;
    const hargaJual    = parseInt(document.getElementById('alkesHargaJual').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;
    const elP = document.getElementById('alkesPeringatanHarga');
    const elO = document.getElementById('alkesInfoHargaOke');
    const elI = document.getElementById('alkesHargaJual');
    const elM = document.getElementById('alkesPesanPeringatan');

    elP.style.display = 'none'; elO.style.display = 'none';
    elI.style.borderColor = ''; elI.style.boxShadow = '';
    if (!hargaBeli || !hargaJual) return;

    let msg = '';
    if (hargaJual < hargaBeli)         msg = `Harga jual lebih rendah dari harga beli. RUGI!`;
    else if (hargaJual === hargaBeli)  msg = `Harga jual sama dengan harga beli. Tidak ada keuntungan!`;
    else if (hargaJual < hargaPlusPPN) msg = `Belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')} — kurang Rp ${(hargaPlusPPN-hargaJual).toLocaleString('id-ID')}.`;

    if (msg) {
        elM.textContent = msg; elP.style.display = 'block';
        elI.style.borderColor = '#ef4444'; elI.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        elO.style.display = 'block';
        elI.style.borderColor = '#10b981'; elI.style.boxShadow = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}

// ============ MODAL EDIT ============
function hitungHargaEditAlkes() {
    const hargaBeli    = parseInt(document.getElementById('editHargaBeliAlkes').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;
    document.getElementById('editNilaiPPNAlkes').textContent     = 'Rp ' + ppn.toLocaleString('id-ID');
    document.getElementById('editHargaPlusPPNAlkes').textContent = 'Rp ' + hargaPlusPPN.toLocaleString('id-ID');
    cekHargaJualEditAlkes();
}

function cekHargaJualEditAlkes() {
    const hargaBeli    = parseInt(document.getElementById('editHargaBeliAlkes').value) || 0;
    const hargaJual    = parseInt(document.getElementById('editHargaJualAlkes').value) || 0;
    const ppn          = Math.round(hargaBeli * 0.11);
    const hargaPlusPPN = hargaBeli + ppn;
    const elP = document.getElementById('editPeringatanAlkes');
    const elO = document.getElementById('editInfoOkeAlkes');
    const elI = document.getElementById('editHargaJualAlkes');
    const elM = document.getElementById('editPesanPeringatanAlkes');

    elP.style.display = 'none'; elO.style.display = 'none';
    elI.style.borderColor = ''; elI.style.boxShadow = '';
    if (!hargaBeli || !hargaJual) return;

    let msg = '';
    if (hargaJual < hargaBeli)         msg = `Harga jual lebih rendah dari harga beli. RUGI!`;
    else if (hargaJual === hargaBeli)  msg = `Harga jual sama dengan harga beli. Tidak ada keuntungan!`;
    else if (hargaJual < hargaPlusPPN) msg = `Belum menutupi PPN 11%. Minimal Rp ${hargaPlusPPN.toLocaleString('id-ID')} — kurang Rp ${(hargaPlusPPN-hargaJual).toLocaleString('id-ID')}.`;

    if (msg) {
        elM.textContent = msg; elP.style.display = 'block'; elO.style.display = 'none';
        elI.style.borderColor = '#ef4444'; elI.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.15)';
    } else {
        elP.style.display = 'none'; elO.style.display = 'block';
        elI.style.borderColor = '#10b981'; elI.style.boxShadow = '0 0 0 3px rgba(16,185,129,0.15)';
    }
}
</script>
@endpush