<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ✅ Import Sanctum
use Illuminate\Support\Str;

class Anggota extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // ✅ Tambahkan HasApiTokens

    protected $table = 'anggota';

    // Menggunakan UUID sebagai primary key
    protected $keyType = 'string';
    public $incrementing = false; // Non-incremental ID

    protected $fillable = [
        'nama', 'email', 'password', 'alamat',
        'nik', 'no_telepon',
        'saldo_simpanan', 'total_pinjaman', 'total_denda',
        'kolektor_id'
    ];

    protected static function booted()
    {
        static::creating(function ($anggota) {
            $anggota->id = (string) Str::uuid(); // UUID untuk primary key
        });
    }

    // Relasi ke pinjaman
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    // Relasi ke kolektor
    public function kolektor()
    {
        return $this->belongsTo(Kolektor::class);
    }

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Relasi ke payment submissions
    public function paymentSubmissions()
    {
        return $this->hasMany(PaymentSubmission::class);
    }

    // Update total pinjaman dan denda
    public function updateTotalPinjamanDanDenda()
    {
        $activePinjaman = $this->pinjaman()
            ->where('status', 'aktif')
            ->first();

        if ($activePinjaman) {
            $this->total_pinjaman = $activePinjaman->jumlah;
            $this->total_denda = $activePinjaman->denda;
        } else {
            $this->total_pinjaman = 0;
            $this->total_denda = 0;
        }

        $this->save();
    }
}