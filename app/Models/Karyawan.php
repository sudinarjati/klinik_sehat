<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Karyawan extends Model
{
    protected $fillable = ['nama_lengkap', 'username', 'password', 'peran'];

    protected $hidden = ['password'];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function antreans(): HasMany
    {
        return $this->hasMany(Antrian::class, 'dokter_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'kasir_id');
    }

    public function getLabelPeranAttribute(): string
    {
        return match($this->peran) {
            'pendaftaran' => 'Pendaftaran',
            'dokter'      => 'Dokter',
            'kasir'       => 'Kasir',
            'apoteker'    => 'Apoteker',
            default       => 'Tidak Diketahui',
        };
    }
}