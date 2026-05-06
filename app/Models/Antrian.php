<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Antrian extends Model
{
    protected $table = 'antreans';

protected $fillable = [
    'nomor_rm',
    'nomor_antrian',
    'tanggal_kunjungan',
    'nama_lengkap',
    'tanggal_lahir',
    'jenis_kelamin',
    'jenis_pasien',
    'nomor_hp',
    'nama_ibu_kandung',
    'alamat',
    'status',
    'dokter_id',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'tanggal_lahir'     => 'date',
    ];

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'dokter_id');
    }

    public function pemeriksaan(): HasOne
    {
        return $this->hasOne(Pemeriksaan::class, 'antrian_id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'antrian_id');
    }

    public function getUmurAttribute(): ?int
    {
        if (!$this->tanggal_lahir) return null;
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'menunggu_dokter'  => 'Menunggu Dokter',
            'dipanggil_dokter' => 'Dipanggil Dokter',
            'sedang_diperiksa' => 'Sedang Diperiksa',
            'menunggu_kasir'   => 'Menunggu Kasir',
            'menunggu_obat'    => 'Menunggu Obat',
            'selesai'          => 'Selesai',
            default            => $this->status,
        };
    }

    public function getBadgeClassAttribute(): string
    {
        return match($this->status) {
            'menunggu_dokter'  => 'badge-warning',
            'dipanggil_dokter' => 'badge-info',
            'sedang_diperiksa' => 'badge-primary',
            'menunggu_kasir'   => 'badge-warning',
            'menunggu_obat'    => 'badge-info',
            'selesai'          => 'badge-success',
            default            => 'badge-secondary',
        };
    }

    public static function nomorBerikutnya(): int
    {
        $today = now()->toDateString();
        $max = static::whereDate('tanggal_kunjungan', $today)->max('nomor_antrian');
        return ($max ?? 0) + 1;
    }
    public static function generateNomorRM(): string
    {
        // Ambil semua nomor RM yang sudah ada, cari yang tertinggi
        $last = static::whereNotNull('nomor_rm')
            ->orderByRaw('CAST(nomor_rm AS UNSIGNED) DESC')
            ->value('nomor_rm');

        if (!$last) {
            return '00001';
        }

        $lastNumber = (int) $last;
        return str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    }
}