<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ApotekerController;

// Auth
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')
    ->middleware('karyawan');

// Pendaftaran
Route::middleware(['karyawan:pendaftaran'])->prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::get('/', [PendaftaranController::class, 'index'])->name('index');
    Route::post('/', [PendaftaranController::class, 'store'])->name('store');
    Route::get('/riwayat', [PendaftaranController::class, 'riwayat'])->name('riwayat');
    Route::delete('/riwayat/{antrian}', [PendaftaranController::class, 'hapus'])->name('hapus');
    Route::get('/pasien', [PendaftaranController::class, 'pasien'])->name('pasien');
    Route::get('/pasien/{antrian}', [PendaftaranController::class, 'detailPasien'])->name('pasien.detail');
    Route::get('/cari-pasien', [PendaftaranController::class, 'cariPasien'])->name('cari-pasien');
});

// Dokter
Route::middleware(['karyawan:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/', [DokterController::class, 'index'])->name('index');
    Route::post('/{antrian}/panggil', [DokterController::class, 'panggil'])->name('panggil');
    Route::post('/{antrian}/periksa', [DokterController::class, 'periksa'])->name('periksa');
    Route::get('/{antrian}/form', [DokterController::class, 'form'])->name('form');
    Route::post('/{antrian}/simpan', [DokterController::class, 'simpan'])->name('simpan');
    Route::get('/riwayat', [DokterController::class, 'riwayat'])->name('riwayat');
});

// Kasir
Route::middleware(['karyawan:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('index');
    Route::post('/{antrian}/lunas', [KasirController::class, 'tandaiLunas'])->name('lunas');
    Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('riwayat');
});

// Apoteker
Route::middleware(['karyawan:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('/', [ApotekerController::class, 'index'])->name('index');
    Route::post('/{antrian}/serahkan', [ApotekerController::class, 'serahkan'])->name('serahkan');
    Route::get('/riwayat', [ApotekerController::class, 'riwayat'])->name('riwayat');
});


// Admin Manajemen
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminAuthController::class, 'dashboard'])->name('dashboard');

        // Tindakan
        Route::get('/tindakan', [\App\Http\Controllers\Admin\TindakanController::class, 'index'])->name('tindakan');
        Route::post('/tindakan', [\App\Http\Controllers\Admin\TindakanController::class, 'store'])->name('tindakan.store');
        Route::put('/tindakan/{tindakan}', [\App\Http\Controllers\Admin\TindakanController::class, 'update'])->name('tindakan.update');
        Route::delete('/tindakan/{tindakan}', [\App\Http\Controllers\Admin\TindakanController::class, 'destroy'])->name('tindakan.destroy');

        // Lab
        Route::get('/lab', [\App\Http\Controllers\Admin\LabController::class, 'index'])->name('lab');
        Route::post('/lab', [\App\Http\Controllers\Admin\LabController::class, 'store'])->name('lab.store');
        Route::put('/lab/{lab}', [\App\Http\Controllers\Admin\LabController::class, 'update'])->name('lab.update');
        Route::delete('/lab/{lab}', [\App\Http\Controllers\Admin\LabController::class, 'destroy'])->name('lab.destroy');

        // Obat
        Route::get('/obat', [\App\Http\Controllers\Admin\ObatController::class, 'index'])->name('obat');
        Route::post('/obat', [\App\Http\Controllers\Admin\ObatController::class, 'store'])->name('obat.store');
        Route::put('/obat/{obat}', [\App\Http\Controllers\Admin\ObatController::class, 'update'])->name('obat.update');
        Route::post('/obat/{obat}/stok', [\App\Http\Controllers\Admin\ObatController::class, 'tambahStok'])->name('obat.stok');
        Route::delete('/obat/{obat}', [\App\Http\Controllers\Admin\ObatController::class, 'destroy'])->name('obat.destroy');

        // Alkes
        Route::get('/alkes', [\App\Http\Controllers\Admin\AlkesController::class, 'index'])->name('alkes');
        Route::post('/alkes', [\App\Http\Controllers\Admin\AlkesController::class, 'store'])->name('alkes.store');
        Route::put('/alkes/{alkes}', [\App\Http\Controllers\Admin\AlkesController::class, 'update'])->name('alkes.update');
        Route::post('/alkes/{alkes}/stok', [\App\Http\Controllers\Admin\AlkesController::class, 'tambahStok'])->name('alkes.stok');
        Route::delete('/alkes/{alkes}', [\App\Http\Controllers\Admin\AlkesController::class, 'destroy'])->name('alkes.destroy');


        // Karyawan
        Route::get('/karyawan', [\App\Http\Controllers\Admin\KaryawanController::class, 'index'])->name('karyawan');
        Route::post('/karyawan', [\App\Http\Controllers\Admin\KaryawanController::class, 'store'])->name('karyawan.store');
        Route::put('/karyawan/{karyawan}', [\App\Http\Controllers\Admin\KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{karyawan}', [\App\Http\Controllers\Admin\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    });
});