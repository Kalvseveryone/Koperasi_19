<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    // Metode untuk menambah anggota
    public function store(Request $request)
    {
        // Validasi input data anggota
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|max:255|unique:anggota,nik',
                'no_telepon' => 'required|string|max:20',
                'email' => 'required|email|unique:anggota,email',
                'password' => 'required|string|min:6',
                'alamat' => 'required|string',
                'saldo_simpanan' => 'nullable|numeric|min:0',
            ]);

        // Buat anggota baru
        $anggota = Anggota::create([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'alamat' => $validated['alamat'],
            'saldo_simpanan' => $validated['saldo_simpanan'] ?? 0,
        ]);

        // Kembalikan respons sukses
        return redirect()->route('admin.anggota')->with('message', 'Anggota berhasil ditambahkan');
    }

    // Metode untuk mengupdate anggota berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input data anggota
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:anggota,nik,' . $id,
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:anggota,email,' . $id,
            'password' => 'nullable|string|min:6',
            'alamat' => 'required|string',
            'saldo_simpanan' => 'nullable|numeric|min:0',
        ]);

        // Mencari anggota berdasarkan ID
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return redirect()->route('admin.anggota')->with('error', 'Anggota tidak ditemukan');
        }

        // Update data anggota
        $anggota->update([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'no_telepon' => $validated['no_telepon'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $anggota->password,
            'alamat' => $validated['alamat'],
            'saldo_simpanan' => $validated['saldo_simpanan'] ?? $anggota->saldo_simpanan,
        ]);

        // Redirect dengan parameter success
        return redirect()->route('admin.anggota')->with('message', 'Anggota berhasil diperbarui');
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
            return redirect()->route('admin.anggota')->with('error', 'Anggota tidak ditemukan');
        }

        // Hapus anggota
        $anggota->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.anggota')->with('message', 'Anggota berhasil dihapus');
    }

    public function index()
    {
        $anggotas = Anggota::all();
        return view('admin.anggota.anggota', compact('anggotas'));
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

    public function history(Request $request)
    {
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 20);
        
        // Get the authenticated user
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Get the anggota associated with the user
        $anggota = Anggota::where('email', $user->email)->first();
        
        if (!$anggota) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        // Get transaction history
        $transactions = \App\Models\Transaksi::where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return response()->json([
            'data' => $transactions->items(),
            'meta' => [
                'current_page' => $transactions->currentPage(),
                'last_page' => $transactions->lastPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total()
            ]
        ]);
    }
}