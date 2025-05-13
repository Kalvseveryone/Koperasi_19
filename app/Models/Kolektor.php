<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kolektor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'anggota_id',
    ];

    // Relasi dengan Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

