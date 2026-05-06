<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'antrian_id',
        'total_bayar',
        'dibayar_pada',
        'kasir_id',
    ];

    protected $casts = [
        'dibayar_pada' => 'datetime',
    ];

    public function antrian(): BelongsTo
    {
        return $this->belongsTo(Antrian::class, 'antrian_id');
    }

    public function kasir(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'kasir_id');
    }

    public function sudahLunas(): bool
    {
        return !is_null($this->dibayar_pada);
    }
}