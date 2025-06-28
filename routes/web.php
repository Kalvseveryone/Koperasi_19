<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\SimpananTransactionController;
use App\Http\Controllers\LaporanKeuanganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KolektorController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');

    return '✅ Semua cache Laravel berhasil dibersihkan dan dibuat ulang.';
});


// Public routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Include kolektor routes
require __DIR__.'/kolektor.php';

// Root redirect
Route::get('/', function () {
    if (Auth::guard('kolektor')->check()) {
        return redirect()->route('kolektor.dashboard');
    }
    if (Auth::guard('web')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Kelola Anggota
    Route::get('/anggota', [AdminController::class, 'manajemenAnggota'])->name('admin.anggota');
    Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('admin.anggota.create');
    Route::post('/anggota', [AnggotaController::class, 'store'])->name('admin.anggota.store');
    Route::get('/anggota/{id}', [AnggotaController::class, 'show'])->name('admin.anggota.show');
    Route::get('/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('admin.anggota.edit');
    Route::put('/anggota/{id}', [AnggotaController::class, 'update'])->name('admin.anggota.update');
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('admin.anggota.destroy');

    // Kelola Kolektor
    Route::get('/kolektor', [KolektorController::class, 'index'])->name('admin.kolektor');
    Route::get('/kolektor/create', [KolektorController::class, 'create'])->name('admin.kolektor.create');
    Route::post('/kolektor', [KolektorController::class, 'store'])->name('admin.kolektor.store');
    Route::get('/kolektor/{id}', [KolektorController::class, 'show'])->name('admin.kolektor.show');

    // Kelola Kolektor (continued)
    Route::get('/kolektor/{id}/edit', [KolektorController::class, 'edit'])->name('admin.kolektor.edit');
    Route::put('/kolektor/{id}', [KolektorController::class, 'update'])->name('admin.kolektor.update');
    Route::delete('/kolektor/{id}', [KolektorController::class, 'destroy'])->name('admin.kolektor.destroy');

    // Kelola Pinjaman
    Route::get('/pinjaman', [PinjamanController::class, 'index'])->name('admin.pinjaman.index');
    Route::get('/pinjaman/create', [PinjamanController::class, 'create'])->name('admin.pinjaman.create');
    Route::post('/pinjaman', [PinjamanController::class, 'store'])->name('admin.pinjaman.store');
    Route::get('/pinjaman/{id}', [PinjamanController::class, 'show'])->name('admin.pinjaman.show');
    Route::get('/pinjaman/{id}/edit', [PinjamanController::class, 'edit'])->name('admin.pinjaman.edit');
    Route::put('/pinjaman/{id}', [PinjamanController::class, 'update'])->name('admin.pinjaman.update');
    Route::delete('/pinjaman/{id}', [PinjamanController::class, 'destroy'])->name('admin.pinjaman.destroy');
    Route::put('/pinjaman/{id}/verify', [PinjamanController::class, 'verify'])->name('admin.pinjaman.verify');
    Route::put('/pinjaman/verify/{id}', [PinjamanController::class, 'verify'])->name('admin.pinjaman.verify');
    Route::get('/pinjaman/verify/{id}', [PinjamanController::class, 'showVerifyForm'])->name('admin.pinjaman.verify.show');
    Route::get('/pinjaman/add-denda/{id}', [PinjamanController::class, 'showAddDendaForm'])->name('admin.pinjaman.add-denda.show');
    Route::post('/pinjaman/add-denda/{id}', [\App\Http\Controllers\PinjamanController::class, 'addDenda'])->name('admin.pinjaman.add-denda');
    Route::delete('/pinjaman/delete-denda/{id}', [\App\Http\Controllers\PinjamanController::class, 'deleteDenda'])->name('admin.pinjaman.delete-denda');
    

    // Kelola Simpanan
    Route::get('/simpanan', [SimpananTransactionController::class, 'index'])->name('admin.simpanan.index');
    Route::post('/simpanan', [SimpananTransactionController::class, 'store'])->name('admin.simpanan.store');

    // Laporan Keuangan
    Route::get('/laporan', [LaporanKeuanganController::class, 'generateReport'])->name('admin.laporan');
    Route::get('/laporan/export', [LaporanKeuanganController::class, 'exportLaporanKeuangan'])->name('admin.laporan.export');

    // Verifikasi Pembayaran
    Route::get('/payments/pending', [AdminController::class, 'getPendingPayments'])->name('admin.payments.pending');
    Route::get('/payments/verify/{id}', [AdminController::class, 'showPaymentVerification'])->name('admin.payments.verify');
    Route::post('/payments/{id}/verify', [AdminController::class, 'verifyPayment'])->name('admin.payments.verify.submit');
    Route::get('/payments/history', [AdminController::class, 'getPaymentHistory'])->name('admin.payments.history');
});

// Kolektor routes
Route::prefix('kolektor')->middleware(['auth:kolektor', 'role:kolektor'])->group(function () {
    // Dashboard kolektor
    Route::get('/dashboard', [KolektorController::class, 'dashboard'])->name('kolektor.dashboard');

    // Anggota Binaan
    Route::get('/anggota-binaan', [KolektorController::class, 'anggotaBinaan'])->name('kolektor.anggota-binaan');
    Route::get('/anggota-binaan/{id}', [KolektorController::class, 'showAnggotaBinaan'])->name('kolektor.anggota-binaan.show');
    Route::post('/anggota-binaan/{id}/payment', [KolektorController::class, 'recordPayment'])->name('kolektor.anggota-binaan.payment');
    
    // Pembayaran Angsuran
    Route::get('/payments/form/{anggotaId}', [KolektorController::class, 'showPaymentForm'])->name('kolektor.payment.form');
    Route::post('/payments/submit', [KolektorController::class, 'submitPayment'])->name('kolektor.payment.submit');
    Route::get('/payments/history/{anggotaId}', [KolektorController::class, 'getPaymentHistory'])->name('kolektor.payment.history');
});

// Anggota routes
Route::prefix('anggota')->middleware(['auth:anggota'])->group(function () {
    // Dashboard anggota
    Route::get('/dashboard', [\App\Http\Controllers\AnggotaDashboardController::class, 'index'])->name('anggota.dashboard');
    
    // Saldo dan History
    Route::get('/saldo', [\App\Http\Controllers\AnggotaDashboardController::class, 'saldo'])->name('anggota.saldo');
    Route::get('/history', [\App\Http\Controllers\AnggotaDashboardController::class, 'history'])->name('anggota.history');
    
    // Pengajuan Pinjaman
    Route::get('/pinjaman/create', [\App\Http\Controllers\AnggotaDashboardController::class, 'createPinjaman'])->name('anggota.pinjaman.create');
    Route::post('/pinjaman', [\App\Http\Controllers\AnggotaDashboardController::class, 'storePinjaman'])->name('anggota.pinjaman.store');
    Route::get('/pinjaman', [\App\Http\Controllers\AnggotaDashboardController::class, 'listPinjaman'])->name('anggota.pinjaman.index');
});
