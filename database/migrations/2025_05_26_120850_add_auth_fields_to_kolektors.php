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
        Schema::table('kolektors', function (Blueprint $table) {
            $table->string('email')->unique()->after('nama');
            $table->string('password')->after('email');
            $table->rememberToken();
        });

        Schema::table('anggota', function (Blueprint $table) {
            $table->foreignId('kolektor_id')->nullable()->after('id')->constrained('kolektors')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropForeign(['kolektor_id']);
            $table->dropColumn('kolektor_id');
        });

        Schema::table('kolektors', function (Blueprint $table) {
            $table->dropColumn(['email', 'password', 'remember_token']);
        });
    }
};
