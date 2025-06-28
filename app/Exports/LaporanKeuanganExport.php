<?php

namespace App\Exports;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Kolektor;
use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Menyiapkan data laporan
        $data = [
            [
                'no' => 1,
                'jenis' => 'Total Anggota',
                'total' => Anggota::count(),
                'format' => 'number'
            ],
            [
                'no' => 2,
                'jenis' => 'Total Simpanan',
                'total' => Anggota::sum('saldo_simpanan'),
                'format' => 'currency'
            ],
            [
                'no' => 3,
                'jenis' => 'Total Pinjaman',
                'total' => Pinjaman::sum('jumlah'),
                'format' => 'currency'
            ],
            [
                'no' => 4,
                'jenis' => 'Total Kolektor',
                'total' => Kolektor::count(),
                'format' => 'number'
            ],
            [
                'no' => 5,
                'jenis' => 'Total Transaksi',
                'total' => Transaksi::count(),
                'format' => 'number'
            ],
            [
                'no' => 6,
                'jenis' => 'Total Denda',
                'total' => Transaksi::where('jenis_transaksi', 'denda')->sum('jumlah'),
                'format' => 'currency'
            ],
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis Laporan',
            'Total',
        ];
    }

    public function map($row): array
    {
        $total = $row['format'] === 'currency' 
            ? 'Rp' . number_format($row['total'], 0, ',', '.') 
            : $row['total'] . ($row['jenis'] === 'Total Kolektor' ? ' orang' : ' transaksi');

        return [
            $row['no'],
            $row['jenis'],
            $total,
        ];
    }
}
