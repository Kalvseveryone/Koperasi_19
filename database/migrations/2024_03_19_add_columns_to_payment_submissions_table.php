<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payment_submissions', function (Blueprint $table) {
            $table->string('metode_pembayaran')->nullable()->after('tanggal_pembayaran');
            $table->integer('bulan_pembayaran')->nullable()->after('metode_pembayaran');
            $table->integer('tahun_pembayaran')->nullable()->after('bulan_pembayaran');
            $table->string('catatan_admin')->nullable()->after('catatan');
        });
    }

    public function down()
    {
        Schema::table('payment_submissions', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'bulan_pembayaran', 'tahun_pembayaran', 'catatan_admin']);
        });
    }
}; 