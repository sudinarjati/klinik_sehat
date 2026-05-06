<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeriksaan extends Model
{
    protected $fillable = [
        'antrian_id',
        'diagnosa_utama',
        'catatan_tambahan',
        'perlu_observasi',
        'biaya_konsultasi',
        'tindakan',
        'lab',
        'resep_obat',
        'total_biaya',
    ];

    protected $casts = [
        'tindakan'        => 'array',
        'lab'             => 'array',
        'resep_obat'      => 'array',
        'perlu_observasi' => 'boolean',
    ];

    public function antrian(): BelongsTo
    {
        return $this->belongsTo(Antrian::class, 'antrian_id');
    }

    public function hitungTotal(): int
    {
        $total = $this->biaya_konsultasi ?? 0;

        if ($this->tindakan) {
            foreach ($this->tindakan as $t) {
                $total += (int)($t['harga'] ?? 0);
            }
        }

        if ($this->resep_obat) {
            foreach ($this->resep_obat as $o) {
                $total += (int)($o['harga_satuan'] ?? 0) * (int)($o['jumlah'] ?? 1);
            }
        }

        return $total;
    }
}