<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    // API Methods for mobile app
    public function apiIndex(Request $request)
    {
        $user = $request->user();
        
        // If user is anggota, get their pinjaman
        if ($user instanceof \App\Models\Anggota) {
            $pinjaman = Pinjaman::where('anggota_id', $user->id)
                ->with('anggota')
                ->orderBy('created_at', 'desc')
                ->get();
                
            return response()->json([
                'success' => true,
                'message' => 'Pinjaman data retrieved successfully',
                'data' => $pinjaman
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 401);
    }

    public function apiShow(Request $request, $id)
    {
        $user = $request->user();
        
        // If user is anggota, get their specific pinjaman
        if ($user instanceof \App\Models\Anggota) {
            $pinjaman = Pinjaman::where('id', $id)
                ->where('anggota_id', $user->id)
                ->with('anggota')
                ->first();
                
            if ($pinjaman) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pinjaman detail retrieved successfully',
                    'data' => $pinjaman
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Pinjaman not found'
            ], 404);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 401);
    }

    public function apiCreate(Request $request)
    {
        $user = $request->user();
        
        // If user is anggota, create pinjaman for them
        if ($user instanceof \App\Models\Anggota) {
            $request->validate([
                'jumlah' => 'required|numeric|min:1000',
                'jangka_waktu' => 'required|integer|min:1|max:60',
                'tujuan' => 'required|string|max:255'
            ]);

            $pinjaman = Pinjaman::create([
                'anggota_id' => $user->id,
                'jumlah' => $request->jumlah,
                'jangka_waktu' => $request->jangka_waktu,
                'tujuan' => $request->tujuan,
                'tanggal_pinjam' => now(),
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pinjaman application submitted successfully',
                'data' => $pinjaman
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access'
        ], 401);
    }

    // Existing admin methods
    public function index()
    {
        $pinjaman = Pinjaman::with('anggota')->orderBy('id', 'desc')->get();
        return view('admin.pinjaman.index', compact('pinjaman'));
    }

    public function create(Request $request)
    {
        // Logika untuk mengajukan pinjaman
        $pinjaman = Pinjaman::create([
            'anggota_id' => $request->anggota_id,
            'jumlah' => $request->jumlah,
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

    public function edit($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        $anggotas = \App\Models\Anggota::all();
        return view('admin.pinjaman.edit', compact('pinjaman', 'anggotas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah' => 'required|numeric|min:1000',
            'jangka_waktu' => 'required|integer|min:1|max:60',
            'tujuan' => 'required|string|max:255',
            'status' => 'required|in:pending,aktif,lunas,ditolak',
            'tanggal_pinjam' => 'required|date',
            'tanggal_lunas' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'denda' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        
        // Simpan data lama untuk perbandingan
        $jumlahLama = $pinjaman->jumlah;
        $dendaLama = $pinjaman->denda;
        
        // Update data pinjaman
        $pinjaman->update([
            'anggota_id' => $request->anggota_id,
            'jumlah' => $request->jumlah,
            'jangka_waktu' => $request->jangka_waktu,
            'tujuan' => $request->tujuan,
            'status' => $request->status,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_lunas' => $request->tanggal_lunas,
            'denda' => $request->denda ?? 0,
            'catatan' => $request->catatan
        ]);

        // Update total pinjaman dan denda anggota
        $pinjaman->anggota->updateTotalPinjamanDanDenda();

        // Jika ada perubahan jumlah atau denda, catat transaksi
        if ($jumlahLama != $request->jumlah || $dendaLama != ($request->denda ?? 0)) {
            $selisihJumlah = $request->jumlah - $jumlahLama;
            $selisihDenda = ($request->denda ?? 0) - $dendaLama;
            
            if ($selisihJumlah != 0) {
                Transaksi::create([
                    'anggota_id' => $request->anggota_id,
                    'jumlah' => $selisihJumlah,
                    'jenis_transaksi' => 'pinjaman',
                    'status' => 'sukses',
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Penyesuaian jumlah pinjaman'
                ]);
            }
            
            if ($selisihDenda != 0) {
                Transaksi::create([
                    'anggota_id' => $request->anggota_id,
                    'jumlah' => $selisihDenda,
                    'jenis_transaksi' => 'denda',
                    'status' => 'sukses',
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Penyesuaian denda pinjaman'
                ]);
            }
        }

        return redirect()->route('admin.pinjaman.index')
            ->with('success', 'Data pinjaman berhasil diperbarui.');
    }

    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,ditolak',
            'catatan' => 'required_if:status,ditolak|string|nullable'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        
        if ($request->status === 'aktif') {
            $pinjaman->status = 'aktif';
        } else {
            $pinjaman->status = 'ditolak';
            $pinjaman->catatan = $request->catatan;
        }
        
        $pinjaman->save();

        // Update total pinjaman dan denda anggota
        $pinjaman->anggota->updateTotalPinjamanDanDenda();

        return redirect()->route('admin.pinjaman.index')
            ->with('success', 'Status pinjaman berhasil diperbarui.');
    }
    
    public function showVerifyForm($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        return view('admin.pinjaman.verify', compact('pinjaman'));
    }

    public function showAddDendaForm($id)
    {
        $pinjaman = Pinjaman::with('anggota')->findOrFail($id);
        return view('admin.pinjaman.add-denda', compact('pinjaman'));
    }

    public function addDenda(Request $request, $id)
    {
        $request->validate([
            'denda' => 'required|numeric|min:0',
            'keterangan' => 'required|string'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        
        // Update denda
        $pinjaman->denda += $request->denda;
        $pinjaman->save();

        // Catat transaksi denda
        Transaksi::create([
            'anggota_id' => $pinjaman->anggota_id,
            'jumlah' => $request->denda,
            'jenis_transaksi' => 'denda',
            'status' => 'sukses',
            'tanggal_transaksi' => now(),
            'keterangan' => $request->keterangan
        ]);

        // Update total denda anggota
        $pinjaman->anggota->updateTotalPinjamanDanDenda();

        return redirect()->route('admin.pinjaman.index')
            ->with('success', 'Denda berhasil ditambahkan.');
    }

    public function deleteDenda(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string'
        ]);

        $pinjaman = Pinjaman::findOrFail($id);
        
        // Hapus seluruh denda
        $dendaSebelumnya = $pinjaman->denda;
        $pinjaman->denda = 0;
        $pinjaman->save();

        // Catat transaksi penghapusan denda
        Transaksi::create([
            'anggota_id' => $pinjaman->anggota_id,
            'jumlah' => -$dendaSebelumnya, // Nilai negatif untuk menandakan pengurangan
            'jenis_transaksi' => 'denda',
            'status' => 'sukses',
            'tanggal_transaksi' => now(),
            'keterangan' => 'Penghapusan denda: ' . $request->keterangan
        ]);

        // Update total denda anggota
        $pinjaman->anggota->updateTotalPinjamanDanDenda();

        return redirect()->route('admin.pinjaman.index')
            ->with('success', 'Denda berhasil dihapus.');
    }

    public function destroy($id)
    {
        try {
            $pinjaman = Pinjaman::findOrFail($id);
            $anggota = $pinjaman->anggota;
            $pinjaman->delete();
            
            // Update total pinjaman dan denda anggota
            $anggota->updateTotalPinjamanDanDenda();
            
            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pinjaman berhasil dihapus.'
                ]);
            }
            
            return redirect()->route('admin.pinjaman.index')
                ->with('success', 'Pinjaman berhasil dihapus.');
                
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus pinjaman.'
                ], 500);
            }
            
            return redirect()->route('admin.pinjaman.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pinjaman.');
        }
    }
}