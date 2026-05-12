@extends('layouts.app')

@section('title', 'Pemeriksaan Pasien')

@section('nav-links')
    <li><a href="{{ route('dokter.index') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Antrian Pasien
    </a></li>
    <li><a href="{{ route('dokter.riwayat') }}" class="nav-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Riwayat
    </a></li>
@endsection

@section('content')
<a href="{{ route('dokter.index') }}" class="back-link">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Antrian
</a>

<div class="page-header">
    <h1 class="page-title">Pemeriksaan Pasien</h1>
    <p class="page-desc">Isi hasil diagnosa dan tindakan untuk pasien ini.</p>
</div>

{{-- Info Pasien --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <div style="display:flex; align-items:flex-start; gap:16px;">
            <span class="badge badge-primary" style="font-size:13px; padding:4px 12px;">Antrean {{ $antrian->nomor_antrian }}</span>
            <div>
                <div style="font-size:12px; color:var(--text-light);">{{ $antrian->tanggal_kunjungan->format('d F Y') }} pukul {{ $antrian->created_at->format('H.i') }}</div>
                <div style="font-size:22px; font-weight:700; margin-top:2px;">{{ $antrian->nama_lengkap }}</div>
                @if($antrian->nomor_rm)
                    <div style="margin-top:4px;">
                        <span style="background:var(--primary-light); color:var(--primary); padding:2px 10px; border-radius:20px; font-weight:700; font-size:12px;">
                            RM {{ $antrian->nomor_rm }}
                        </span>
                    </div>
                @endif
                <div style="font-size:13px; color:var(--text-light); margin-top:6px; display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
                    @if($antrian->umur)
                        <span>{{ $antrian->umur }} thn ({{ $antrian->jenis_kelamin }})</span>
                    @else
                        <span>{{ $antrian->jenis_kelamin }}</span>
                    @endif
                    <span>HP: {{ $antrian->nomor_hp }}</span>
                    <span>Ibu: {{ $antrian->nama_ibu_kandung }}</span>
                    <span>{{ $antrian->alamat }}</span>
                    @if(isset($antrian->jenis_pasien))
                        <span style="display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; {{ $antrian->jenis_pasien === 'luar_negeri' ? 'background:#fef3cd; color:#856404;' : 'background:#e0f2fe; color:#0369a1;' }}">
                            {{ $antrian->jenis_pasien === 'luar_negeri' ? '✈️ Luar Negeri' : '🏠 Lokal' }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('dokter.simpan', $antrian->id) }}" method="POST" id="formPemeriksaan">
@csrf
<div class="layout-split">

    {{-- Kolom Kiri --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

        {{-- Hasil Pemeriksaan --}}
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Hasil Pemeriksaan
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Diagnosa Utama <span class="required">*</span></label>
                    <textarea name="diagnosa_utama" class="form-control" rows="3"
                        placeholder="Tuliskan diagnosa penyakit pasien..." required>{{ old('diagnosa_utama', $pemeriksaan->diagnosa_utama ?? '') }}</textarea>
                    @error('diagnosa_utama')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea name="catatan_tambahan" class="form-control" rows="3"
                        placeholder="Keluhan, alergi, atau catatan lainnya...">{{ old('catatan_tambahan', $pemeriksaan->catatan_tambahan ?? '') }}</textarea>
                </div>

                <div class="toggle-wrap">
                    <label class="toggle">
                        <input type="checkbox" name="perlu_observasi" value="1"
                            {{ old('perlu_observasi', $pemeriksaan->perlu_observasi ?? false) ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <div>
                        <div class="toggle-title">Perlu Observasi Lanjut</div>
                        <div class="toggle-desc">Tandai jika pasien membutuhkan observasi atau rawat inap sementara</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tindakan Medis --}}
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Tindakan Medis
            </div>
            <div class="card-body">
                @if($tindakanList->isEmpty())
                    <div style="text-align:center; padding:20px; color:var(--text-light); font-size:13px;">
                        Belum ada tindakan medis. Tambahkan di panel manajemen.
                    </div>
                @else
                    <div class="tindakan-grid">
                        @foreach($tindakanList as $tindakan)
                            @php
                                $terpilih = collect($pemeriksaan->tindakan ?? [])->pluck('nama')->contains($tindakan->nama);
                            @endphp
                            <label class="tindakan-item">
                                <input type="checkbox" name="tindakan[]"
                                    value="{{ $tindakan->nama }}"
                                    {{ $terpilih ? 'checked' : '' }}
                                    onchange="hitungEstimasi()">
                                <div style="flex:1;">
                                    <div class="tindakan-nama">{{ $tindakan->nama }}</div>
                                    <div class="tindakan-harga">Rp {{ number_format($tindakan->harga, 0, ',', '.') }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Pemeriksaan Lab --}}
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2v-4M9 21H5a2 2 0 01-2-2v-4m0 0h18"/></svg>
                Pemeriksaan Penunjang (Lab)
            </div>
            <div class="card-body">
                @if($labList->isEmpty())
                    <div style="text-align:center; padding:20px; color:var(--text-light); font-size:13px;">
                        Belum ada pemeriksaan lab. Tambahkan di panel manajemen.
                    </div>
                @else
                    <div class="tindakan-grid">
                        @foreach($labList as $lab)
                            @php
                                $terpilih = collect($pemeriksaan->lab ?? [])->pluck('nama')->contains($lab->nama);
                            @endphp
                            <label class="tindakan-item">
                                <input type="checkbox" name="lab[]"
                                    value="{{ $lab->nama }}"
                                    {{ $terpilih ? 'checked' : '' }}
                                    onchange="hitungEstimasi()">
                                <div style="flex:1;">
                                    <div class="tindakan-nama">{{ $lab->nama }}</div>
                                    <div class="tindakan-harga">Rp {{ number_format($lab->harga, 0, ',', '.') }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Resep Obat --}}
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.5 20H4a2 2 0 01-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 011.66.9l.82 1.2a2 2 0 001.66.9H20a2 2 0 012 2v3"/><circle cx="18" cy="18" r="3"/><path d="M18 15v3l2 1"/></svg>
                Resep Obat
                <button type="button" onclick="tambahObat()" class="btn btn-outline btn-sm" style="margin-left:auto;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Obat
                </button>
            </div>
            <div class="card-body">
                <div id="resepContainer">
                    @if(!empty($pemeriksaan->resep_obat))
                        @foreach($pemeriksaan->resep_obat as $i => $obat)
                            <div class="resep-item" id="resep_{{ $i }}">
                                <button type="button" class="btn-remove-resep" onclick="hapusObat({{ $i }})">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                </button>
                                <div class="resep-grid">
                                    <div class="form-group mb-0">
                                        <label class="form-label">Obat</label>
                                        <select name="obat_nama[]" class="form-control" onchange="cekStokObat(this)">
                                            <option value="">Pilih obat</option>
                                            @foreach($obatList as $o)
                                                <option value="{{ $o->nama }}"
                                                    data-harga="{{ $o->harga_jual }}"
                                                    {{ ($obat['nama_obat'] ?? '') === $o->nama ? 'selected' : '' }}>
                                                    {{ $o->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">Jumlah</label>
                                        <input type="number" name="obat_jumlah[]" class="form-control"
                                            value="{{ $obat['jumlah'] ?? 1 }}" min="1" onchange="hitungEstimasi()">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">Aturan Pakai</label>
                                        <input type="text" name="obat_aturan[]" class="form-control"
                                            placeholder="Contoh: 3x sehari 1 tablet sesudah makan"
                                            value="{{ $obat['aturan_pakai'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div id="emptyResep" style="{{ !empty($pemeriksaan->resep_obat) ? 'display:none;' : '' }}text-align:center; padding:24px; color:var(--text-light); font-size:13px;">
                    Belum ada obat ditambahkan. Klik "Tambah Obat" untuk menambah resep.
                </div>
            </div>
        </div>

    </div>

    {{-- Kolom Kanan: Estimasi --}}
    <div class="estimasi-sticky">
        <div class="card">
            <div class="card-header">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><line x1="9" y1="15" x2="13" y2="15"/></svg>
                Estimasi Biaya
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Biaya Konsultasi Dokter</label>
                    <input type="number" name="biaya_konsultasi" id="biayaKonsultasi"
                        class="form-control"
                        value="{{ old('biaya_konsultasi', $pemeriksaan->biaya_konsultasi ?? 50000) }}"
                        min="0" onchange="hitungEstimasi()">
                </div>

                <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--border);">
                    <div class="estimasi-row">
                        <span>Konsultasi</span>
                        <span id="estKonsultasi">Rp 0</span>
                    </div>
                    <div class="estimasi-row">
                        <span>Tindakan (<span id="jmlTindakan">0</span>)</span>
                        <span id="estTindakan">Rp 0</span>
                    </div>
                    <div class="estimasi-row">
                        <span>Lab (<span id="jmlLab">0</span>)</span>
                        <span id="estLab">Rp 0</span>
                    </div>
                    <div class="estimasi-row">
                        <span>Obat (<span id="jmlObat">0</span>)</span>
                        <span id="estObat">Rp 0</span>
                    </div>
                    <div class="estimasi-total">
                        <span>Total Estimasi</span>
                        <span id="estTotal">Rp 0</span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-top:20px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Selesaikan Pemeriksaan
                </button>
            </div>
        </div>
    </div>

</div>
</form>
@endsection

@push('scripts')
<script>
    // Data harga dari database (disiapkan di controller)
    const tindakanHarga = @json($tindakanList->pluck('harga', 'nama'));
    const labHarga      = @json($labList->pluck('harga', 'nama'));
    const obatHarga     = @json($obatList->pluck('harga_jual', 'nama'));

    // Data obat untuk dropdown dinamis (disiapkan di controller)
        const obatOptions = obatData.map(o => {
            const label = o.isi_per_satuan > 1
                ? `${o.nama} — per ${o.satuan_jual} (isi ${o.isi_per_satuan} ${o.satuan})`
                : `${o.nama} — per ${o.satuan_jual}`;
            const disabled = o.stok <= 0 ? 'disabled' : '';
            const habis    = o.stok <= 0 ? ' — STOK HABIS' : '';
            return `<option value="${o.nama}" data-harga="${o.harga}"
                data-satuan="${o.satuan_jual}" data-isi="${o.isi_per_satuan}"
                ${disabled}>${label}${habis}</option>`;
        }).join('');

    let resepCount = {{ !empty($pemeriksaan->resep_obat) ? count($pemeriksaan->resep_obat) : 0 }};

    function formatRp(n) {
        return 'Rp ' + n.toLocaleString('id-ID');
    }

    function hitungEstimasi() {
        let konsultasi = parseInt(document.getElementById('biayaKonsultasi').value) || 0;

        // Hitung tindakan
        let totalTindakan = 0, jmlTindakan = 0;
        document.querySelectorAll('input[name="tindakan[]"]:checked').forEach(cb => {
            totalTindakan += tindakanHarga[cb.value] || 0;
            jmlTindakan++;
        });

        // Hitung lab
        let totalLab = 0, jmlLab = 0;
        document.querySelectorAll('input[name="lab[]"]:checked').forEach(cb => {
            totalLab += labHarga[cb.value] || 0;
            jmlLab++;
        });

        // Hitung obat
        let totalObat = 0, jmlObat = 0;
        const namaObats = document.querySelectorAll('select[name="obat_nama[]"]');
        const jmlObats  = document.querySelectorAll('input[name="obat_jumlah[]"]');
        namaObats.forEach((sel, i) => {
            if (sel.value) {
                totalObat += (obatHarga[sel.value] || 0) * (parseInt(jmlObats[i]?.value) || 1);
                jmlObat++;
            }
        });

        document.getElementById('estKonsultasi').textContent = formatRp(konsultasi);
        document.getElementById('estTindakan').textContent   = formatRp(totalTindakan);
        document.getElementById('jmlTindakan').textContent   = jmlTindakan;
        document.getElementById('estLab').textContent        = formatRp(totalLab);
        document.getElementById('jmlLab').textContent        = jmlLab;
        document.getElementById('estObat').textContent       = formatRp(totalObat);
        document.getElementById('jmlObat').textContent       = jmlObat;
        document.getElementById('estTotal').textContent      = formatRp(konsultasi + totalTindakan + totalLab + totalObat);
    }

    function cekStokObat(selectEl) {
    const selected = selectEl.options[selectEl.selectedIndex];
    const stok     = parseInt(selected?.getAttribute('data-stok') ?? '999');
    const nama     = selectEl.value;

    // Hapus peringatan lama
    const wrapper = selectEl.closest('.form-group');
    const oldWarn = wrapper.querySelector('.stok-warning');
    if (oldWarn) oldWarn.remove();

    if (!nama) return;

    if (stok <= 0) {
        const warn = document.createElement('div');
        warn.className = 'stok-warning';
        warn.style.cssText = 'font-size:12px; color:#991b1b; background:#fee2e2; padding:6px 10px; border-radius:6px; margin-top:6px;';
        warn.textContent = '⚠️ Stok habis! Hubungi bagian manajemen untuk restok.';
        wrapper.appendChild(warn);
    } else if (stok <= 10) {
        const warn = document.createElement('div');
        warn.className = 'stok-warning';
        warn.style.cssText = 'font-size:12px; color:#856404; background:#fef3cd; padding:6px 10px; border-radius:6px; margin-top:6px;';
        warn.textContent = `⚠️ Stok hampir habis! Sisa ${stok}.`;
        wrapper.appendChild(warn);
    }

    hitungEstimasi();
    }


    function tambahObat() {
        const id = resepCount++;
        document.getElementById('emptyResep').style.display = 'none';

        const html = `
        <div class="resep-item" id="resep_${id}">
            <button type="button" class="btn-remove-resep" onclick="hapusObat(${id})">...</button>
            <div class="resep-grid">
                <div class="form-group mb-0">
                    <label class="form-label">Obat</label>
                    <select name="obat_nama[]" class="form-control" onchange="patchSatuanObat(this); cekStokObat(this)">
                        <option value="">Pilih obat</option>
                        ${obatOptions}
                    </select>
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Jumlah <span id="satuanLabel_${id}" style="font-weight:400; color:var(--text-light);"></span></label>
                    <input type="number" name="obat_jumlah[]" class="form-control" value="1" min="1" onchange="hitungEstimasi()">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Aturan Pakai</label>
                    <input type="text" name="obat_aturan[]" class="form-control"
                        placeholder="Contoh: 3x sehari 1 tablet sesudah makan">
                </div>
            </div>
        </div>`;

        document.getElementById('resepContainer').insertAdjacentHTML('beforeend', html);
        hitungEstimasi();
    }

    function patchSatuanObat(selectEl) {
    const opt    = selectEl.options[selectEl.selectedIndex];
    const satuan = opt?.getAttribute('data-satuan') ?? '';
    const isi    = opt?.getAttribute('data-isi') ?? '1';

    // Cari label satuan terdekat
    const wrapper = selectEl.closest('.resep-item');
    const label   = wrapper?.querySelector('[id^="satuanLabel_"]');
    if (label) {
        label.textContent = satuan
            ? `(${satuan}${isi > 1 ? `, isi ${isi}` : ''})`
            : '';
    }
    hitungEstimasi();
}







    function hapusObat(id) {
        const el = document.getElementById('resep_' + id);
        if (el) el.remove();
        if (document.querySelectorAll('.resep-item').length === 0) {
            document.getElementById('emptyResep').style.display = '';
        }
        hitungEstimasi();
    }

    document.addEventListener('DOMContentLoaded', hitungEstimasi);
</script>
@endpush