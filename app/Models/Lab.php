<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    protected $fillable = ['nama', 'harga', 'aktif'];
    protected $casts    = ['aktif' => 'boolean'];
}