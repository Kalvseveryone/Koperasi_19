<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk ditampilkan di dashboard
        $totalAnggota = Anggota::count();
        $totalPinjaman = Pinjaman::sum('jumlah');
        $totalSimpanan = Anggota::sum('saldo_simpanan');
        $totalTransaksi = Transaksi::count();

        return view('admin.dashboard', compact('totalAnggota', 'totalPinjaman', 'totalSimpanan', 'totalTransaksi'));
    }
}
