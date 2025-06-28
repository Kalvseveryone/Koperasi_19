<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36); // UUID
            $table->decimal('jumlah', 10, 2);
            $table->integer('jangka_waktu');
            $table->string('tujuan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'aktif'])->default('pending');
            $table->text('catatan')->nullable();
            $table->date('tanggal_pinjam')->useCurrent();
            $table->timestamps();
            
            // Menambahkan index untuk anggota_id
            $table->index('anggota_id');

            // Foreign key dengan cascade delete
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
