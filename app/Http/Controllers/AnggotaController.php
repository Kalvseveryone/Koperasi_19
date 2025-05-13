<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    // Metode untuk menambah anggota
    public function store(Request $request)
    {
        // Validasi input data anggota
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggotas,email',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'saldo_simpanan' => 'required|numeric|min:0',
        ]);

        // Buat anggota baru
        $anggota = Anggota::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'alamat' => $validated['alamat'],
            'saldo_simpanan' => $validated['saldo_simpanan'],
        ]);

        // Kembalikan respons sukses
        return response()->json(['message' => 'Anggota berhasil ditambahkan', 'anggota' => $anggota], 201);
    }

    // Metode untuk mengupdate anggota berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input data anggota
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggotas,email,' . $id,
            'password' => 'nullable|string|min:6',
            'alamat' => 'required|string',
            'saldo_simpanan' => 'required|numeric|min:0',
        ]);

        // Mencari anggota berdasarkan ID
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        // Update data anggota
        $anggota->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $anggota->password,
            'alamat' => $validated['alamat'],
            'saldo_simpanan' => $validated['saldo_simpanan'],
        ]);

        // Kembalikan respons sukses
        return response()->json(['message' => 'Anggota berhasil diperbarui', 'anggota' => $anggota], 200);
    }

    // Metode untuk menampilkan data anggota berdasarkan ID
    public function show($id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            // Kalau anggota tidak ditemukan, bisa redirect atau tampilkan halaman error
            return redirect()->route('admin.anggota.index')->with('error', 'Anggota tidak ditemukan');
        }

        // Tampilkan view dan kirim data anggota
        return view('admin.anggota.show', compact('anggota'));
    }


    // Metode untuk menampilkan saldo simpanan anggota berdasarkan ID
    public function showSimpanan($id)
    {
        // Mencari anggota berdasarkan ID
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        // Kembalikan saldo simpanan anggota
        return response()->json(['saldo_simpanan' => $anggota->saldo_simpanan], 200);
    }

    // Metode untuk menghapus anggota berdasarkan ID
    public function destroy($id)
    {
        // Mencari anggota berdasarkan ID
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        // Hapus anggota
        $anggota->delete();

        // Kembalikan respons sukses
        return response()->json(['message' => 'Anggota berhasil dihapus'], 200);
    }

    public function index()
    {
        $anggota = Anggota::all();
        return view('admin.anggota.index', compact('anggota'));
    }
    public function create()
    {
        return view('admin.anggota.create');  // Menampilkan view form pembuatan anggota
    }
    public function edit($id)
    {
        // Mencari anggota berdasarkan ID
        $anggota = Anggota::find($id);

        // Jika anggota tidak ditemukan, tampilkan error
        if (!$anggota) {
            return redirect()->route('admin.anggota')->with('error', 'Anggota tidak ditemukan');
        }

        // Kembalikan view dengan data anggota
        return view('admin.anggota.edit', compact('anggota'));
    }


}







