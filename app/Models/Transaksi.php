<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id', 'jumlah', 'jenis_transaksi', 'tanggal_transaksi'
    ];

    // Relasi, misalnya Transaksi milik Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

