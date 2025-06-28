<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->decimal('total_pinjaman', 10, 2)->default(0)->after('saldo_simpanan');
            $table->decimal('total_denda', 10, 2)->default(0)->after('total_pinjaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropColumn(['total_pinjaman', 'total_denda']);
        });
    }
}; 