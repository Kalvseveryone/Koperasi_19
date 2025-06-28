<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();
        return view('admin.simpanan.index', compact('anggotas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'simpanan_pokok' => 'required|numeric|min:0',
            'simpanan_wajib' => 'required|numeric|min:0',
            'simpanan_sukarela' => 'required|numeric|min:0',
        ]);

        $anggota = Anggota::findOrFail($id);
        
        $anggota->simpanan_pokok = $request->simpanan_pokok;
        $anggota->simpanan_wajib = $request->simpanan_wajib;
        $anggota->simpanan_sukarela = $request->simpanan_sukarela;
        $anggota->saldo_simpanan = $request->simpanan_pokok + $request->simpanan_wajib + $request->simpanan_sukarela;
        
        $anggota->save();

        return redirect()->route('admin.simpanan.index')
            ->with('success', 'Data simpanan berhasil diperbarui');
    }
}
