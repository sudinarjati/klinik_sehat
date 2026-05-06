<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawans = [
            [
                'nama_lengkap' => 'Petugas Pendaftaran',
                'username'     => 'pendaftaran',
                'password'     => 'pendaftaran123',
                'peran'        => 'pendaftaran',
            ],
            [
                'nama_lengkap' => 'Dr. Anur Mustakim',
                'username'     => 'dokter',
                'password'     => 'dokter123',
                'peran'        => 'dokter',
            ],
            [
                'nama_lengkap' => 'Petugas Kasir',
                'username'     => 'kasir',
                'password'     => 'kasir123',
                'peran'        => 'kasir',
            ],
            [
                'nama_lengkap' => 'Petugas Apotek',
                'username'     => 'apoteker',
                'password'     => 'apoteker123',
                'peran'        => 'apoteker',
            ],
        ];

        foreach ($karyawans as $k) {
            Karyawan::create($k);
        }
    }
}