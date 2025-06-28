<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->date('tanggal_lunas')->nullable()->after('tanggal_pinjam');
        });
    }

    public function down()
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn('tanggal_lunas');
        });
    }
}; 