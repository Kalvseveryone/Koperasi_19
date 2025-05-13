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
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36); // Ubah tipe menjadi char(36) untuk UUID
            $table->decimal('jumlah_pinjaman', 10, 2);
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');  // Default status adalah 'pending'
            $table->timestamp('tanggal_pinjam')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            
            // Menambahkan index untuk anggota_id
            $table->index('anggota_id');

            // Foreign key dengan cascade delete
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamen');
    }
};
