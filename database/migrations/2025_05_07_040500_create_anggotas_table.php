<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('anggota', function (Blueprint $table) {
        $table->char('id', 36)->primary();  // Menggunakan UUID sebagai primary key
        $table->string('nama');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('alamat');
        $table->decimal('simpanan_pokok', 10, 2)->default(0);
        $table->decimal('simpanan_wajib', 10, 2)->default(0);
        $table->decimal('simpanan_sukarela', 10, 2)->default(0);
        $table->decimal('saldo_simpanan', 10, 2)->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
