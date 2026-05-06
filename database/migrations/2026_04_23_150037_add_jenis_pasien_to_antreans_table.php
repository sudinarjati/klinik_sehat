<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->enum('jenis_pasien', ['lokal', 'luar_negeri'])->default('lokal')->after('jenis_kelamin');
        });
    }

    public function down(): void
    {
        Schema::table('antreans', function (Blueprint $table) {
            $table->dropColumn('jenis_pasien');
        });
    }
};