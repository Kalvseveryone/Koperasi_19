<?php

namespace App\Http\Controllers;

use App\Models\Kolektor;
use App\Models\Anggota;
use App\Models\Transaksi;
use App\Notifications\PembayaranStatusNotifikasi;
use App\Models\PaymentSubmission;
use Illuminate\Http\Request;

class KolektorController extends Controller
{
    // Menampilkan laporan kolektor
    public function laporan()
    {
        $kolektor = auth()->user();
        $anggotaBinaan = Anggota::where('kolektor_id', $kolektor->id)->get();
        $transaksi = Transaksi::whereIn('anggota_id', $anggotaBinaan->pluck('id'))
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        return view('kolektor.laporan', [
            'anggotaBinaan' => $anggotaBinaan,
            'transaksi' => $transaksi
        ]);
    }
    // Menambah kolektor
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'anggota_id' => 'required|exists:anggota,id',
            'email' => 'required|email|unique:kolektors,email',
            'password' => 'required|string|min:6',
        ]);

        // Check if anggota is already assigned to a kolektor
        $anggota = Anggota::find($request->anggota_id);
        if ($anggota->kolektor_id) {
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['anggota_id' => 'Anggota ini sudah memiliki kolektor.']);
        }

        $kolektor = Kolektor::create([
            'nama' => $request->nama,
            'anggota_id' => $request->anggota_id,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Update anggota's kolektor_id
        $anggota->kolektor_id = $kolektor->id;
        $anggota->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Kolektor berhasil ditambahkan', 'kolektor' => $kolektor], 201);
        }

        return redirect()->route('admin.kolektor')->with('success', 'Kolektor berhasil ditambahkan');
    }

    // Mencatat pembayaran angsuran
    public function recordPayment(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah_pembayaran' => 'required|numeric|min:1',
            'tanggal_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'required|image|max:2048', // max 2MB
        ]);

        $anggota = Anggota::findOrFail($request->anggota_id);
        $kolektor = auth()->guard('kolektor')->user();

        // Upload bukti pembayaran
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        // Buat payment submission baru
        $payment = PaymentSubmission::create([
            'anggota_id' => $anggota->id,
            'kolektor_id' => $kolektor->id,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'bukti_pembayaran' => $buktiPath,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil diajukan',
            'payment' => $payment
        ], 200);
    }

    // Menghapus kolektor berdasarkan ID
    public function destroy($id)
    {
        $kolektor = Kolektor::find($id);

        if (!$kolektor) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['message' => 'Kolektor tidak ditemukan'], 404);
            }
            return redirect()->route('admin.kolektor')->with('error', 'Kolektor tidak ditemukan');
        }

        // Hapus relasi dengan anggota binaan
        Anggota::where('kolektor_id', $id)->update(['kolektor_id' => null]);
        
        $kolektor->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Kolektor berhasil dihapus'], 200);
        }

        return redirect()->route('admin.kolektor')->with('success', 'Kolektor berhasil dihapus');
    }

    // Form tambah kolektor
    public function create()
    {
        // Get only anggota yang belum memiliki kolektor
        $anggotas = Anggota::whereNull('kolektor_id')->get();
        return view('admin.kolektor.create', compact('anggotas'));
    }

    // Menampilkan daftar kolektor
    public function index()
    {
        $kolektors = Kolektor::all();
        return view('admin.kolektor.index', compact('kolektors'));
    }

    // Menampilkan daftar anggota binaan untuk kolektor yang sedang login
    public function anggotaBinaan()
    {
        $kolektor = auth()->guard('kolektor')->user();
        $anggotaBinaan = Anggota::where('kolektor_id', $kolektor->id)->get();
        return view('kolektor.anggota-binaan.index', compact('anggotaBinaan'));
    }

    // Menampilkan detail anggota binaan
    public function showAnggotaBinaan($id)
    {
        $kolektor = auth()->guard('kolektor')->user();
        $anggota = Anggota::where('kolektor_id', $kolektor->id)
                         ->where('id', $id)
                         ->with('paymentSubmissions')
                         ->firstOrFail();
        
        return view('kolektor.anggota-binaan.show', compact('anggota'));
    }

    // Dashboard kolektor
    public function dashboard()
    {
        $kolektor = auth()->user();
        
        // Get statistics
        $totalAnggota = $kolektor->anggotaBinaan()->count();
        
        $today = now()->format('Y-m-d');
        $totalPembayaranHariIni = Transaksi::whereIn('anggota_id', $kolektor->anggotaBinaan()->pluck('id'))
            ->whereDate('tanggal_transaksi', $today)
            ->where('jenis_transaksi', 'pembayaran angsuran')
            ->sum('jumlah');
        
        $startOfMonth = now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = now()->endOfMonth()->format('Y-m-d');
        $totalPembayaranBulanIni = Transaksi::whereIn('anggota_id', $kolektor->anggotaBinaan()->pluck('id'))
            ->whereBetween('tanggal_transaksi', [$startOfMonth, $endOfMonth])
            ->where('jenis_transaksi', 'pembayaran angsuran')
            ->sum('jumlah');
        
        // Get latest activities
        $aktivitasTerbaru = Transaksi::whereIn('anggota_id', $kolektor->anggotaBinaan()->pluck('id'))
            ->with('anggota')
            ->latest()
            ->take(10)
            ->get();
        
        // Get anggota binaan for payment modal
        $anggotaBinaan = $kolektor->anggotaBinaan;
        
        return view('kolektor.dashboard', compact(
            'totalAnggota',
            'totalPembayaranHariIni',
            'totalPembayaranBulanIni',
            'aktivitasTerbaru',
            'anggotaBinaan'
        ));
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

    public function payment(Request $request, $id)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric|min:1',
            'metode' => 'required|in:tunai,transfer'
        ]);

        $anggota = Anggota::findOrFail($id);

        // Buat transaksi baru
        $transaksi = new Transaksi();
        $transaksi->anggota_id = $anggota->id;
        $transaksi->kolektor_id = auth()->guard('kolektor')->id();
        $transaksi->jenis_transaksi = 'pembayaran';
        $transaksi->jumlah = $request->jumlah_pembayaran;
        $transaksi->metode_pembayaran = $request->metode;
        $transaksi->tanggal_transaksi = now();
        $transaksi->save();

        // Update saldo anggota
        $anggota->saldo_simpanan += $request->jumlah_pembayaran;
        $anggota->save();

        // Kirim notifikasi ke anggota
        $anggota->notify(new PembayaranStatusNotifikasi($transaksi));

        return response()->json([
            'message' => 'Pembayaran berhasil dicatat',
            'transaksi' => $transaksi
        ]);
    }

    public function update(Request $request, $id)
    {
        $kolektor = Kolektor::find($id);

        if (!$kolektor) {
            return redirect()->route('admin.kolektor')->with('error', 'Kolektor tidak ditemukan');
        }

        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:kolektors,email,' . $id,
            'anggota_id' => 'required|exists:anggota,id',
        ];

        // Validasi password jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6';
        }

        $request->validate($rules);

        // Check if new anggota is already assigned to another kolektor
        if ($request->anggota_id !== $kolektor->anggota_id) {
            $existingKolektor = Anggota::where('id', $request->anggota_id)
                ->whereNotNull('kolektor_id')
                ->where('kolektor_id', '!=', $id)
                ->exists();

            if ($existingKolektor) {
                return back()
                    ->withInput()
                    ->withErrors(['anggota_id' => 'Anggota ini sudah memiliki kolektor lain.']);
            }

            // Update old anggota's kolektor_id to null
            Anggota::where('kolektor_id', $kolektor->id)
                ->update(['kolektor_id' => null]);

            // Update new anggota's kolektor_id
            Anggota::where('id', $request->anggota_id)
                ->update(['kolektor_id' => $id]);
        }

        // Update data kolektor
        $kolektor->nama = $request->nama;
        $kolektor->email = $request->email;
        $kolektor->anggota_id = $request->anggota_id;

        // Update password jika diisi (akan di-hash oleh mutator di model)
        if ($request->filled('password')) {
            $kolektor->password = $request->password;
        }

        $kolektor->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Kolektor berhasil diperbarui', 'kolektor' => $kolektor]);
        }

        return redirect()
            ->route('admin.kolektor')
            ->with('success', 'Kolektor berhasil diperbarui');
    }

    // Submit payment for verification
    public function submitPayment(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'jumlah_pembayaran' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'bukti_pembayaran' => 'nullable|image|max:2048', // Max 2MB
            'tanggal_pembayaran' => 'required|date',
            'bulan_pembayaran' => 'required|integer|between:1,12',
            'tahun_pembayaran' => 'required|integer|min:2000'
        ]);

        $kolektor = auth()->guard('kolektor')->user();
        
        // Check if anggota is under this kolektor
        $anggota = Anggota::where('id', $request->anggota_id)
                         ->where('kolektor_id', $kolektor->id)
                         ->firstOrFail();

        // Check if payment for this month already exists
        $existingPayment = PaymentSubmission::where('anggota_id', $request->anggota_id)
            ->where('bulan_pembayaran', $request->bulan_pembayaran)
            ->where('tahun_pembayaran', $request->tahun_pembayaran)
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existingPayment) {
            return response()->json([
                'message' => 'Pembayaran untuk periode ini sudah ada'
            ], 422);
        }

        // Handle file upload if exists
        $buktiPath = null;
        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
        }

        // Create payment submission
        $submission = PaymentSubmission::create([
            'anggota_id' => $request->anggota_id,
            'kolektor_id' => $kolektor->id,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_pembayaran' => $buktiPath,
            'status' => 'pending',
            'bulan_pembayaran' => $request->bulan_pembayaran,
            'tahun_pembayaran' => $request->tahun_pembayaran
        ]);

        return response()->json([
            'message' => 'Pengajuan pembayaran berhasil disubmit',
            'submission' => $submission
        ]);
    }

    // Get payment history for anggota
    public function getPaymentHistory($anggotaId)
    {
        $kolektor = auth()->guard('kolektor')->user();
        
        // Check if anggota is under this kolektor
        $anggota = Anggota::where('id', $anggotaId)
                         ->where('kolektor_id', $kolektor->id)
                         ->firstOrFail();

        $payments = PaymentSubmission::where('anggota_id', $anggotaId)
                                   ->with(['anggota', 'kolektor'])
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return response()->json([
            'payments' => $payments
        ]);
    }

    // Show payment submission form
    public function showPaymentForm($anggotaId)
    {
        $kolektor = auth()->guard('kolektor')->user();
        
        // Check if anggota is under this kolektor
        $anggota = Anggota::where('id', $anggotaId)
                         ->where('kolektor_id', $kolektor->id)
                         ->firstOrFail();

        return view('kolektor.payments.submit', [
            'anggota' => $anggota,
            'bulan' => [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ],
            'tahun' => range(date('Y') - 1, date('Y') + 1)
        ]);
    }
}
