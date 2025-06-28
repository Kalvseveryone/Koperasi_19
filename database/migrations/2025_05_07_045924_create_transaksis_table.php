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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36); // UUID
            $table->decimal('jumlah', 10, 2);
            $table->string('jenis_transaksi'); // 'simpanan', 'pinjaman', 'angsuran'
            $table->string('jenis_simpanan')->nullable(); // 'pokok', 'wajib', 'sukarela'
            $table->string('status')->default('pending'); // 'pending', 'sukses', 'gagal'
            $table->timestamp('tanggal_transaksi')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            
            // Menambahkan index untuk anggota_id
            $table->index('anggota_id');

            // Menambahkan foreign key dengan cascade delete
            $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
