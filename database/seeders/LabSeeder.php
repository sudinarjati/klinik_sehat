<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Lab;

class LabSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Darah Rutin',          'harga' => 100000],
            ['nama' => 'H2TL',                 'harga' => 80000],
            ['nama' => 'Widal',                'harga' => 80000],
            ['nama' => 'Paket H2TL + Widal',   'harga' => 160000],
            ['nama' => 'Hema Lengkap',         'harga' => 95000],
            ['nama' => 'Trigliserida',         'harga' => 50000],
            ['nama' => 'Cholesterol Total',    'harga' => 40000],
            ['nama' => 'HDL',                  'harga' => 50000],
            ['nama' => 'LDL',                  'harga' => 50000],
            ['nama' => 'Asam Urat',            'harga' => 35000],
            ['nama' => 'Gula Darah Sewaktu',   'harga' => 40000],
            ['nama' => 'Gula Darah Puasa',     'harga' => 40000],
            ['nama' => 'Gula Darah 2PP',       'harga' => 40000],
            ['nama' => 'HbA1C',                'harga' => 175000],
            ['nama' => 'SGOT',                 'harga' => 50000],
            ['nama' => 'SGPT',                 'harga' => 50000],
            ['nama' => 'Ureum',                'harga' => 50000],
            ['nama' => 'Creatinin',            'harga' => 50000],
            ['nama' => 'HbsAg',                'harga' => 100000],
            ['nama' => 'HIV',                  'harga' => 100000],
            ['nama' => 'Sifilis',              'harga' => 100000],
            ['nama' => 'Urin Rutin',           'harga' => 40000],
            ['nama' => 'Tes Narkoba',          'harga' => 120000],
            ['nama' => 'Anti Dengue',          'harga' => 120000],
            ['nama' => 'Golongan Darah',       'harga' => 75000],
            ['nama' => 'NS1 + H2TL',           'harga' => 200000],
        ];
        foreach ($data as $d) Lab::create($d);
    }
}