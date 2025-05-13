<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kolektor;
use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil data statistik untuk Dashboard
        $totalAnggota = Anggota::count();
        $totalKolektor = Kolektor::count();
        return view('admin.dashboard', compact('totalAnggota', 'totalKolektor'));
    }

    public function manajemenAnggota()
    {
        // Ambil data anggota untuk manajemen
        $anggotas = Anggota::all();
        return view('admin.anggota.anggota', compact('anggotas'));
    }

    public function manajemenKolektor()
    {
        // Ambil data kolektor untuk manajemen
        $kolektors = Kolektor::all();
        return view('admin.kolektor.index', compact('kolektors'));
    }

    public function laporanKeuangan()
    {
        // Ambil data laporan keuangan
        $laporan = [
            'total_simpanan' => Anggota::sum('saldo_simpanan'),
            'total_pinjaman' => Pinjaman::sum('jumlah_pinjaman'),
            'total_kolektor' => Kolektor::count(),
            'total_transaksi' => Transaksi::count(),
        ];
        return view('admin.laporan-keuangan', compact('laporan'));
    }

    public function rekapHarian()
    {
        // Ambil data rekap harian
        $rekapHarian = Transaksi::whereDate('tanggal_transaksi', today())->get();
        return view('admin.rekap-harian', compact('rekapHarian'));
    }
}