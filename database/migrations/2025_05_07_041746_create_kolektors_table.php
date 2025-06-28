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
    Schema::create('kolektors', function (Blueprint $table) {
        $table->id();  // ID untuk kolektor
        $table->char('anggota_id', 36);  // Kolom anggota_id dengan tipe UUID
        $table->string('nama');
        $table->timestamps();

        // Menambahkan foreign key constraint
        $table->foreign('anggota_id')->references('id')->on('anggota')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kolektors');
    }
};
