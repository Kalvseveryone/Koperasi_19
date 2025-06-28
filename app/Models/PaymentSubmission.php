<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'kolektor_id',
        'jumlah_pembayaran',
        'tanggal_pembayaran',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'catatan_admin',
        'bulan_pembayaran',
        'tahun_pembayaran'
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah_pembayaran' => 'decimal:2',
        'bulan_pembayaran' => 'integer',
        'tahun_pembayaran' => 'integer'
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function kolektor()
    {
        return $this->belongsTo(Kolektor::class);
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Payment method constants
    const METHOD_CASH = 'tunai';
    const METHOD_TRANSFER = 'transfer';
} 