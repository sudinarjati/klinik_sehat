<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antreans', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_antrian');
            $table->date('tanggal_kunjungan');
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('nomor_hp');
            $table->string('nama_ibu_kandung');
            $table->text('alamat');
            $table->enum('status', [
                'menunggu_dokter',
                'dipanggil_dokter',
                'sedang_diperiksa',
                'menunggu_kasir',
                'menunggu_obat',
                'selesai'
            ])->default('menunggu_dokter');
            $table->unsignedBigInteger('dokter_id')->nullable();
            $table->foreign('dokter_id')->references('id')->on('karyawans')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antreans');
    }
};