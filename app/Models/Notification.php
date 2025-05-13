<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    // Non-auto incrementing ID
    public $incrementing = false;
    protected $keyType = 'string'; // Menggunakan UUID sebagai primary key

    // Menghasilkan UUID saat model dibuat
    protected static function boot()
    {
        parent::boot();

        // Generate UUID sebelum data disimpan
        static::creating(function ($notification) {
            $notification->id = (string) Str::uuid();  // Generate UUID
        });
    }

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = ['type', 'notifiable_id', 'notifiable_type', 'data', 'read_at'];
}
