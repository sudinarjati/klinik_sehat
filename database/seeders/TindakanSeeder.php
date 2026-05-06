<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Tindakan;

class TindakanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Eksisi Clavus',         'harga' => 150000],
            ['nama' => 'Insisi Abses',           'harga' => 100000],
            ['nama' => 'Nebulizer',              'harga' => 80000],
            ['nama' => 'Pasang Tampon Hidung',   'harga' => 250000],
            ['nama' => 'Pasang Kateter',         'harga' => 150000],
            ['nama' => 'Irigasi Telinga',        'harga' => 100000],
            ['nama' => 'Irigasi Mata',           'harga' => 150000],
            ['nama' => 'Ekstraksi Kuku',         'harga' => 150000],
            ['nama' => 'Sirkumsisi',             'harga' => 350000],
            ['nama' => 'Insisi Lipoma',          'harga' => 200000],
            ['nama' => 'Aff Hecting',            'harga' => 75000],
            ['nama' => 'Corpus Alienum Hidung',  'harga' => 50000],
            ['nama' => 'Corpus Alienum Telinga', 'harga' => 50000],
            ['nama' => 'Ekstraksi Serumen',      'harga' => 150000],
            ['nama' => 'Oksigen',                'harga' => 100000],
        ];
        foreach ($data as $d) Tindakan::create($d);
    }
}