<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = ['nama', 'satuan', 'stok', 'harga_beli', 'harga_jual', 'aktif'];
    protected $casts    = ['aktif' => 'boolean'];
}