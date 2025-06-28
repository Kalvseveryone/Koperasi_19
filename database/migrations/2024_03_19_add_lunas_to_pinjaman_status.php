<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // MySQL doesn't support modifying enum directly, so we need to recreate the column
        DB::statement("ALTER TABLE pinjaman MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'aktif', 'lunas') DEFAULT 'pending'");
    }

    public function down()
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE pinjaman MODIFY COLUMN status ENUM('pending', 'disetujui', 'ditolak', 'aktif') DEFAULT 'pending'");
    }
}; 