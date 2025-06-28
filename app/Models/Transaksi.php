<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'anggota_id',
        'jumlah',
        'jenis_transaksi',
        'jenis_simpanan',
        'status',
        'tanggal_transaksi',
        'keterangan'
    ];

    // Constants for jenis_transaksi
    const JENIS_SIMPANAN = 'simpanan';
    const JENIS_PINJAMAN = 'pinjaman';
    const JENIS_ANGSURAN = 'angsuran';
    const JENIS_DENDA = 'denda';

    // Constants for jenis_simpanan
    const SIMPANAN_POKOK = 'pokok';
    const SIMPANAN_WAJIB = 'wajib';
    const SIMPANAN_SUKARELA = 'sukarela';

    // Constants for status
    const STATUS_PENDING = 'pending';
    const STATUS_SUKSES = 'sukses';
    const STATUS_GAGAL = 'gagal';

    // Relasi, misalnya Transaksi milik Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

