<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('obats', function (Blueprint $table) {
            $table->string('satuan_jual')->default('tablet')->after('satuan');
            $table->integer('isi_per_satuan')->default(1)->after('satuan_jual');
        });
    }
    public function down(): void {
        Schema::table('obats', function (Blueprint $table) {
            $table->dropColumn(['satuan_jual', 'isi_per_satuan']);
        });
    }
};