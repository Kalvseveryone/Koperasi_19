<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman';

    protected $fillable = [
        'anggota_id',
        'jumlah',
        'denda',
        'jangka_waktu',
        'tujuan',
        'status',
        'tanggal_pinjam',
        'tanggal_lunas',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_lunas' => 'date',
        'jumlah' => 'decimal:2',
        'denda' => 'decimal:2',
    ];

    // Relasi dengan Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

