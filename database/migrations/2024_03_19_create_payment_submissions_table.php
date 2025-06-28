<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_submissions', function (Blueprint $table) {
            $table->id();
            $table->char('anggota_id', 36);
            $table->foreignId('kolektor_id')->constrained('kolektors');
            $table->integer('jumlah_pembayaran');
            $table->date('tanggal_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('anggota_id')->references('id')->on('anggota');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_submissions');
    }
}; 