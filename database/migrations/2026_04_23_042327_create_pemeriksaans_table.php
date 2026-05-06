<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('antrian_id');
            $table->foreign('antrian_id')->references('id')->on('antreans')->cascadeOnDelete();
            $table->text('diagnosa_utama');
            $table->text('catatan_tambahan')->nullable();
            $table->boolean('perlu_observasi')->default(false);
            $table->integer('biaya_konsultasi')->default(50000);
            $table->json('tindakan')->nullable();
            $table->json('resep_obat')->nullable();
            $table->integer('total_biaya')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};