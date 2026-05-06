<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Amoxicillin 500mg',  'satuan' => 'tablet', 'stok' => 200, 'harga_beli' => 800,   'harga_jual' => 1500],
            ['nama' => 'Ibuprofen 400mg',    'satuan' => 'tablet', 'stok' => 150, 'harga_beli' => 1000,  'harga_jual' => 2000],
            ['nama' => 'Paracetamol 500mg',  'satuan' => 'tablet', 'stok' => 300, 'harga_beli' => 400,   'harga_jual' => 800],
            ['nama' => 'Antasida',           'satuan' => 'tablet', 'stok' => 100, 'harga_beli' => 600,   'harga_jual' => 1200],
            ['nama' => 'Vitamin C 500mg',    'satuan' => 'tablet', 'stok' => 200, 'harga_beli' => 500,   'harga_jual' => 1000],
            ['nama' => 'Vitamin B Complex',  'satuan' => 'tablet', 'stok' => 100, 'harga_beli' => 900,   'harga_jual' => 1800],
            ['nama' => 'OBH Combi',          'satuan' => 'botol',  'stok' => 80,  'harga_beli' => 15000, 'harga_jual' => 25000],
            ['nama' => 'Oralit',             'satuan' => 'sachet', 'stok' => 150, 'harga_beli' => 1500,  'harga_jual' => 2500],
            ['nama' => 'Metformin 500mg',    'satuan' => 'tablet', 'stok' => 100, 'harga_beli' => 1200,  'harga_jual' => 2200],
            ['nama' => 'Cetirizine 10mg',    'satuan' => 'tablet', 'stok' => 120, 'harga_beli' => 800,   'harga_jual' => 1500],
            ['nama' => 'Salep Betametason',  'satuan' => 'tube',   'stok' => 50,  'harga_beli' => 10000, 'harga_jual' => 18000],
            ['nama' => 'Antimo',             'satuan' => 'tablet', 'stok' => 80,  'harga_beli' => 1500,  'harga_jual' => 3000],
        ];
        foreach ($data as $d) Obat::create($d);
    }
}