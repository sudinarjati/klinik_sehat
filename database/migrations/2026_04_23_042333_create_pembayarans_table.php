<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('antrian_id');
            $table->foreign('antrian_id')->references('id')->on('antreans')->cascadeOnDelete();
            $table->integer('total_bayar');
            $table->timestamp('dibayar_pada')->nullable();
            $table->unsignedBigInteger('kasir_id')->nullable();
            $table->foreign('kasir_id')->references('id')->on('karyawans')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};