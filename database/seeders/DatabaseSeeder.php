<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KaryawanSeeder::class,
            AdminSeeder::class,
            TindakanSeeder::class,
            LabSeeder::class,
            ObatSeeder::class,
        ]);
    }
}