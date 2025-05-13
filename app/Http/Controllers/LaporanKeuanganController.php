<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Kolektor;
use App\Models\Transaksi;
use Maatwebsite\Excel\Facades\Excel;  // Import Excel
use App\Exports\LaporanKeuanganExport;  // Import LaporanKeuanganExport
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    // Fungsi untuk membuat laporan keuangan
    public function generateReport(Request $request)
    {
        // Data untuk laporan keuangan
        $laporan = [
            'total_simpanan' => Anggota::sum('saldo_simpanan'),
            'total_pinjaman' => Pinjaman::sum('jumlah_pinjaman'),
            'total_kolektor' => Kolektor::count(),
            'total_transaksi' => Transaksi::count(),
            'total_denda' => Transaksi::where('jenis_transaksi', 'denda')->sum('jumlah'),
        ];

        return view('admin.laporan.index', compact('laporan'));
    }

    // Fungsi untuk mengekspor laporan keuangan ke Excel
    public function exportLaporanKeuangan(Request $request)
    {
        return Excel::download(new LaporanKeuanganExport, 'laporan_keuangan.xlsx');
    }
}
