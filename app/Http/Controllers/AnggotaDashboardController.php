<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Transaksi;
use App\Models\SimpananTransaction;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaDashboardController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();
        $pinjaman = Pinjaman::where('anggota_id', $anggota->id)
            ->where('status', 'aktif')
            ->first();
        
        // Get regular transactions
        $transaksi = Transaksi::where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                return (object) [
                    'id' => $t->id,
                    'created_at' => $t->created_at,
                    'jenis' => $t->jenis_transaksi,
                    'jumlah' => $t->jumlah,
                    'status' => $t->status,
                    'type' => 'regular'
                ];
            });

        // Get savings transactions
        $simpananTransaksi = SimpananTransaction::where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                return (object) [
                    'id' => $t->id,
                    'created_at' => $t->created_at,
                    'jenis' => $t->jenis_simpanan,
                    'jumlah' => $t->type === 'keluar' ? -$t->jumlah : $t->jumlah,
                    'status' => 'sukses',
                    'type' => 'simpanan'
                ];
            });

        // Merge and sort all transactions
        $allTransaksi = collect()
            ->concat($transaksi)
            ->concat($simpananTransaksi)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('anggota.dashboard', [
            'anggota' => $anggota,
            'pinjaman' => $pinjaman,
            'transaksi' => $allTransaksi
        ]);
    }

    public function saldo()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.saldo', [
            'anggota' => $anggota
        ]);
    }

    public function history(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();
        
        // Get pinjaman yang ditolak
        $pinjamanDitolak = Pinjaman::where('anggota_id', $anggota->id)
            ->where('status', 'ditolak')
            ->get()
            ->map(function ($pinjaman) {
                return (object) [
                    'id' => $pinjaman->id,
                    'created_at' => $pinjaman->created_at,
                    'jenis_transaksi' => 'pinjaman',
                    'jumlah' => $pinjaman->jumlah,
                    'status' => 'ditolak',
                    'keterangan' => $pinjaman->catatan ?? 'Pengajuan pinjaman ditolak',
                    'jenis_simpanan' => null
                ];
            });

        // Get simpanan transactions
        $simpananQuery = SimpananTransaction::where('anggota_id', $anggota->id);
        
        // Apply date filters to simpanan if needed
        if ($request->filled('tanggal_mulai')) {
            $simpananQuery->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $simpananQuery->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $simpananTransaksi = $simpananQuery->get()
            ->map(function ($simpanan) {
                return (object) [
                    'id' => $simpanan->id,
                    'created_at' => $simpanan->created_at,
                    'jenis_transaksi' => 'simpanan',
                    'jumlah' => $simpanan->type === 'keluar' ? -$simpanan->jumlah : $simpanan->jumlah,
                    'status' => 'sukses',
                    'keterangan' => $simpanan->keterangan ?? 'Transaksi simpanan ' . $simpanan->jenis_simpanan,
                    'jenis_simpanan' => $simpanan->jenis_simpanan,
                    'type' => $simpanan->type
                ];
            });

        // Get transaksi normal
        $query = Transaksi::where('anggota_id', $anggota->id);

        // Filter by jenis transaksi
        if ($request->filled('jenis')) {
            if ($request->jenis === 'simpanan') {
                $query->where('jenis_transaksi', null); // No regular transactions
                $simpananTransaksi = $simpananTransaksi; // Keep all simpanan
            } else {
                $query->where('jenis_transaksi', $request->jenis);
                $simpananTransaksi = collect(); // No simpanan
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'ditolak') {
                $query->where('status', 'gagal');
            } else {
                $query->where('status', $request->status);
            }
            
            // Filter simpanan based on status
            if ($request->status !== 'sukses') {
                $simpananTransaksi = collect(); // Simpanan are always successful
            }
        }

        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }

        $transaksi = $query->get();
        
        // Merge and sort all transactions
        $allTransaksi = collect()
            ->concat($transaksi)
            ->concat($pinjamanDitolak)
            ->concat($simpananTransaksi)
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination
        $page = $request->get('page', 1);
        $perPage = 10;
        $items = $allTransaksi->forPage($page, $perPage);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $allTransaksi->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('anggota.history', [
            'transaksi' => $paginator
        ]);
    }

    public function createPinjaman()
    {
        $anggota = Auth::guard('anggota')->user();
        $activePinjaman = Pinjaman::where('anggota_id', $anggota->id)
            ->where('status', 'aktif')
            ->first();

        if ($activePinjaman) {
            return redirect()->route('anggota.dashboard')
                ->with('error', 'Anda masih memiliki pinjaman aktif.');
        }

        return view('anggota.pinjaman.create');
    }

    public function storePinjaman(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:100000',
            'jangka_waktu' => 'required|numeric|min:1|max:12',
            'tujuan' => 'required|string|max:255'
        ]);

        $anggota = Auth::guard('anggota')->user();
        
        $pinjaman = new Pinjaman();
        $pinjaman->anggota_id = $anggota->id;
        $pinjaman->jumlah = $request->jumlah;
        $pinjaman->jangka_waktu = $request->jangka_waktu;
        $pinjaman->tujuan = $request->tujuan;
        $pinjaman->status = 'pending';
        $pinjaman->tanggal_pinjam = now();
        $pinjaman->save();

        return redirect()->route('anggota.pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

    public function listPinjaman()
    {
        $anggota = Auth::guard('anggota')->user();
        $pinjaman = Pinjaman::where('anggota_id', $anggota->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('anggota.pinjaman.index', [
            'pinjaman' => $pinjaman
        ]);
    }
}
