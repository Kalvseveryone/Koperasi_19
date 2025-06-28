<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kolektor extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'nama',
        'anggota_id',
        'email',
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi dengan Anggota (akun kolektor)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    // Relasi dengan Anggota binaan
    public function anggotaBinaan()
    {
        return $this->hasMany(Anggota::class);
    }
}

