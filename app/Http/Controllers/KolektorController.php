<?php

namespace App\Http\Controllers;

use App\Models\Kolektor;
use App\Models\Anggota;
use App\Models\Transaksi;
use App\Notifications\PembayaranStatusNotifikasi;
use Illuminate\Http\Request;

class KolektorController extends Controller
{
    // Menambah kolektor
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'anggota_id' => 'required|exists:anggotas,id',
        ]);

        $kolektor = Kolektor::create([
            'nama' => $request->nama,
            'anggota_id' => $request->anggota_id,
        ]);

        return response()->json(['message' => 'Kolektor berhasil ditambahkan', 'kolektor' => $kolektor], 201);
    }

    // Mencatat pembayaran angsuran
    public function recordPayment(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'jumlah_pembayaran' => 'required|numeric|min:1',
            'metode' => 'required|string',
        ]);

        $anggota = Anggota::find($request->anggota_id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        $transaksi = Transaksi::create([
            'anggota_id' => $request->anggota_id,
            'jumlah' => $request->jumlah_pembayaran,
            'jenis_transaksi' => 'pembayaran angsuran',
            'tanggal_transaksi' => now(),
        ]);

        $anggota->saldo_simpanan += $request->jumlah_pembayaran;
        $anggota->save();

        $anggota->notify(new PembayaranStatusNotifikasi([
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'tanggal_jatuh_tempo' => '2025-06-15',
            'status_pinjaman' => 'disetujui',
            'tagihan' => $request->jumlah_pembayaran,
        ]));

        return response()->json(['message' => 'Pembayaran berhasil dicatat dan notifikasi terkirim'], 200);
    }

    // Menghapus kolektor berdasarkan ID
    public function destroy($id)
    {
        $kolektor = Kolektor::find($id);

        if (!$kolektor) {
            return response()->json(['message' => 'Kolektor tidak ditemukan'], 404);
        }

        $kolektor->delete();

        return response()->json(['message' => 'Kolektor berhasil dihapus'], 200);
    }

    // Form tambah kolektor
    public function create()
    {
        $anggotas = Anggota::all();
        return view('admin.kolektor.create', compact('anggotas'));
    }

    // Menampilkan daftar kolektor
    public function index()
    {
        $kolektors = Kolektor::all();
        return view('admin.kolektor.index', compact('kolektors'));
    }

    // Form edit kolektor
    public function edit($id)
    {
        $kolektor = Kolektor::find($id);

        if (!$kolektor) {
            return redirect()->route('admin.kolektor')->with('error', 'Kolektor tidak ditemukan');
        }

        $anggotas = Anggota::all();
        return view('admin.kolektor.edit', compact('kolektor', 'anggotas'));
    }

    // Detail kolektor
    public function show($id)
    {
        $kolektor = Kolektor::with('anggota')->find($id);

        if (!$kolektor) {
            return redirect()->route('admin.kolektor')->with('error', 'Kolektor tidak ditemukan');
        }

        return view('admin.kolektor.show', compact('kolektor'));
    }
}
