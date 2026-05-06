<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_lengkap' => 'Manager Klinik',
            'username'     => 'admin',
            'password'     => 'admin123',
        ]);
    }
}