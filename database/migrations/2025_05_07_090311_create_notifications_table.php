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
        Schema::create('notifications', function (Blueprint $table) {
            $table->char('id', 36)->primary();  // Menyimpan UUID sebagai primary key
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->char('notifiable_id', 36);  // Ubah menjadi char(36) untuk UUID
            $table->string('notifiable_type');
            $table->timestamps();

            // Jika ingin menambahkan foreign key constraint
            $table->foreign('notifiable_id')->references('id')->on('anggota')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
