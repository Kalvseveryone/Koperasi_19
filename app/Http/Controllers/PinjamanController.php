<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function index()
    {
        // Ambil data semua pinjaman
        $pinjaman = Pinjaman::all();
        return view('admin.pinjaman.index', compact('pinjaman'));
    }

    public function create(Request $request)
    {
        // Logika untuk mengajukan pinjaman
        $pinjaman = Pinjaman::create([
            'anggota_id' => $request->anggota_id,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'tanggal_pinjam' => now(),
            'status' => 'pending',
        ]);
        return response()->json($pinjaman);
    }

    public function show($id)
    {
        $pinjaman = Pinjaman::where('anggota_id', $id)->get();
        return response()->json($pinjaman);
    }
}
