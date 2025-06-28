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
            'total_anggota' => Anggota::count(),
            'total_simpanan' => Anggota::sum('saldo_simpanan'),
            'total_pinjaman' => Pinjaman::whereIn('status', ['aktif', 'disetujui'])->sum('jumlah'),
            'total_pinjaman_pending' => Pinjaman::where('status', 'pending')->sum('jumlah'),
            'total_pinjaman_ditolak' => Pinjaman::where('status', 'ditolak')->sum('jumlah'),
            'total_denda' => Pinjaman::sum('denda'),
            'total_kolektor' => Kolektor::count(),
            'total_transaksi' => Transaksi::count(),
            'pinjaman_aktif' => Pinjaman::where('status', 'aktif')->count(),
            'pinjaman_pending' => Pinjaman::where('status', 'pending')->count(),
            'pinjaman_ditolak' => Pinjaman::where('status', 'ditolak')->count(),
            'total_angsuran' => Transaksi::where('jenis_transaksi', 'angsuran')->sum('jumlah'),
            'total_denda_bayar' => Transaksi::where('jenis_transaksi', 'denda')->sum('jumlah'),
        ];

        // Filter berdasarkan tanggal jika ada
        if ($request->filled(['tanggal_mulai', 'tanggal_akhir'])) {
            $laporan['transaksi_periode'] = Transaksi::whereBetween('created_at', [
                $request->tanggal_mulai,
                $request->tanggal_akhir
            ])->get();
            
            $laporan['pinjaman_periode'] = Pinjaman::whereBetween('created_at', [
                $request->tanggal_mulai,
                $request->tanggal_akhir
            ])->get();
        }

        return view('admin.laporan.index', compact('laporan'));
    }

    // Fungsi untuk mengekspor laporan keuangan ke Excel
    public function exportLaporanKeuangan(Request $request)
    {
        return Excel::download(new LaporanKeuanganExport, 'laporan_keuangan.xlsx');
    }
}
