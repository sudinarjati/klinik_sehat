<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropUnique(['nomor_rm']);
        });
    }

    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->unique('nomor_rm');
        });
    }
};