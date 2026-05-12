<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'nama', 'satuan', 'satuan_beli', 'satuan_jual', 'konversi',
        'stok', 'harga_beli', 'harga_jual', 'aktif'
    ];
}