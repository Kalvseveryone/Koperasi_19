<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kolektor;
use App\Models\Pinjaman;
use App\Models\Transaksi;
use App\Models\PaymentSubmission;
use Illuminate\Http\Request;
use App\Notifications\PaymentVerificationNotification;

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
        $anggotas = Anggota::latest('created_at')->get();
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
            'total_pinjaman' => Pinjaman::sum('jumlah'),
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

    // Get all pending payment submissions
    public function getPendingPayments()
    {
        $pendingPayments = PaymentSubmission::with(['anggota', 'kolektor'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.payments.pending', [
            'payments' => $pendingPayments
        ]);
    }

    // Show payment verification form
    public function showPaymentVerification($id)
    {
        $payment = PaymentSubmission::with(['anggota', 'kolektor'])
            ->findOrFail($id);

        if ($payment->status !== 'pending') {
            return redirect()->route('admin.payments.pending')
                ->with('error', 'Pembayaran ini sudah diverifikasi');
        }

        return view('admin.payments.verify', [
            'payment' => $payment
        ]);
    }

    // Verify payment submission
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $submission = PaymentSubmission::findOrFail($id);
        
        if ($submission->status !== 'pending') {
            return response()->json([
                'message' => 'Pembayaran ini sudah diverifikasi'
            ], 400);
        }

        $submission->status = $request->status;
        $submission->save();

        // If approved, update the anggota's balance
        if ($request->status === 'approved') {
            $anggota = Anggota::find($submission->anggota_id);
            $anggota->saldo_simpanan += $submission->jumlah_pembayaran;
            $anggota->save();
        }

        return redirect()->route('admin.payments.pending')->with('success', 'Verifikasi pembayaran berhasil');
    }

    // Get payment history
    public function getPaymentHistory()
    {
        $payments = PaymentSubmission::with(['anggota', 'kolektor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.payments.history', [
            'payments' => $payments
        ]);
    }
}