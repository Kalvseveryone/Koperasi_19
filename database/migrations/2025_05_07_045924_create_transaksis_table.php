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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36); // Ubah tipe menjadi char(36) untuk UUID
            $table->decimal('jumlah', 10, 2);  // Misalnya untuk jumlah transaksi
            $table->string('jenis_transaksi');  // Misalnya 'setoran' atau 'penarikan'
            $table->timestamp('tanggal_transaksi')->default(DB::raw('CURRENT_TIMESTAMP'));  // Waktu transaksi
            $table->timestamps();
            
            // Menambahkan index untuk anggota_id
            $table->index('anggota_id');

            // Menambahkan foreign key dengan cascade delete
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
