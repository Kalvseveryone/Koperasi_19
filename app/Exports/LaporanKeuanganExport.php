<?php

namespace App\Exports;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Kolektor;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanKeuanganExport implements FromCollection
{
    public function collection()
    {
        // Menyiapkan data dalam bentuk array untuk diekspor ke Excel
        return collect([
            ['Total Simpanan' => Anggota::sum('saldo_simpanan')],
            ['Total Pinjaman' => Pinjaman::sum('jumlah_pinjaman')],
            ['Total Kolektor' => Kolektor::count()],
            ['Total Transaksi' => Transaksi::count()],
            ['Total Denda' => Transaksi::where('jenis_transaksi', 'denda')->sum('jumlah')],
        ]);
    }
}
