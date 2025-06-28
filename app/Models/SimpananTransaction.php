<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimpananTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'jenis_simpanan',
        'jumlah',
        'type',
        'keterangan'
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }
}
