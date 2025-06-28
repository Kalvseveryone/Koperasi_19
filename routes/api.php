<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\API\MobileAuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KolektorController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AdminController;

// ✅ Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [MobileAuthController::class, 'login']);
    Route::post('/logout', [MobileAuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user', [MobileAuthController::class, 'me'])->middleware('auth:sanctum');
});

// ✅ Route untuk mendapatkan user login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Route untuk Anggota
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/anggota/{id}/simpanan', [AnggotaController::class, 'showSimpanan']);
    Route::post('/anggota', [AnggotaController::class, 'store']);
    Route::get('/anggota/{id}', [AnggotaController::class, 'show']);
    Route::put('/anggota/{id}', [AnggotaController::class, 'update']);
    Route::get('/anggota/history', [AnggotaController::class, 'history']);
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->middleware('role:admin');
});

// ✅ Route untuk Kolektor
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/kolektor/{id}', [KolektorController::class, 'show']);
    Route::post('/kolektor', [KolektorController::class, 'store']);
    Route::post('/kolektor/payment', [KolektorController::class, 'recordPayment']);
    Route::post('/kolektor/payment/submit', [KolektorController::class, 'submitPayment']);
    Route::get('/kolektor/payment/history/{anggotaId}', [KolektorController::class, 'getPaymentHistory']);
    Route::get('/kolektor/payment/form/{anggotaId}', [KolektorController::class, 'showPaymentForm']);
    Route::delete('/kolektor/{id}', [KolektorController::class, 'destroy'])->middleware('role:admin');
});

// ✅ Route untuk Pinjaman
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pinjaman', [PinjamanController::class, 'apiIndex']);
    Route::get('/pinjaman/{id}', [PinjamanController::class, 'apiShow']);
    Route::post('/pinjaman', [PinjamanController::class, 'apiCreate']);
});

// ✅ Route untuk Laporan Keuangan
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'generateReport']);
    Route::get('/laporan-keuangan/export', [LaporanKeuanganController::class, 'exportLaporanKeuangan']);
});

// ✅ Route untuk Admin Panel (gunakan hanya jika admin login juga via token)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/anggota', [AdminController::class, 'manajemenAnggota'])->name('admin.anggota');
    Route::get('/admin/kolektor', [AdminController::class, 'manajemenKolektor'])->name('admin.kolektor');
    Route::get('/admin/laporan-keuangan', [AdminController::class, 'laporanKeuangan'])->name('admin.laporanKeuangan');
    Route::get('/admin/rekap-harian', [AdminController::class, 'rekapHarian'])->name('admin.rekapHarian');
    Route::get('/admin/payments/pending', [AdminController::class, 'getPendingPayments']);
    Route::get('/admin/payments/verify/{id}', [AdminController::class, 'showPaymentVerification']);
    Route::post('/admin/payments/{id}/verify', [AdminController::class, 'verifyPayment']);
    Route::get('/admin/payments/history', [AdminController::class, 'getPaymentHistory']);
});
