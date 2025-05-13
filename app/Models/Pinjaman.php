<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id', 'jumlah_pinjaman', 'status',
    ];

    // Relasi dengan Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

