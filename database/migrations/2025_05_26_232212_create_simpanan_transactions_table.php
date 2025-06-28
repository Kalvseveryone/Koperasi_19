<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simpanan_transactions', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36);
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
            $table->enum('jenis_simpanan', ['pokok', 'wajib', 'sukarela']);
            $table->decimal('jumlah', 12, 2);
            $table->enum('type', ['masuk', 'keluar']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simpanan_transactions');
    }
};
