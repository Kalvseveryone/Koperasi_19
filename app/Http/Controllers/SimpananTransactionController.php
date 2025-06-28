<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\SimpananTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananTransactionController extends Controller
{
    public function index()
    {
        $transactions = SimpananTransaction::with('anggota')->latest()->get();
        $anggotas = Anggota::all();
        return view('admin.simpanan.index', compact('transactions', 'anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'type' => 'required|in:masuk,keluar',
            'keterangan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request) {
            // Create transaction record
            SimpananTransaction::create($request->all());

            // Update anggota's simpanan balance
            $anggota = Anggota::findOrFail($request->anggota_id);
            $field = 'simpanan_' . $request->jenis_simpanan;
            $amount = $request->type === 'masuk' ? $request->jumlah : -$request->jumlah;
            $anggota->$field += $amount;
            $anggota->saldo_simpanan += $amount;
            $anggota->save();
        });

        return redirect()->route('admin.simpanan.index')
            ->with('success', 'Transaksi simpanan berhasil ditambahkan');
    }
}
