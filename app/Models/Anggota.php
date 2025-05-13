<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Anggota extends Model
{
    use HasFactory, Notifiable;

    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false; // Menonaktifkan auto increment

    protected $fillable = [
        'nama', 'email', 'password', 'alamat', 'saldo_simpanan',
    ];

    // Membuat UUID otomatis saat membuat data
    protected static function booted()
    {
        static::creating(function ($anggota) {
            $anggota->id = (string) Str::uuid(); // Menambahkan UUID
        });
    }

    // Relasi, jika diperlukan
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }
}


