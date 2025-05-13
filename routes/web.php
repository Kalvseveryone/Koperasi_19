<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\LaporanKeuanganController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KolektorController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login'); // Redirect to login page after logging out
})->name('logout');


// Route untuk login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);  // Menangani proses login

// Dashboard Admin
Route::middleware('auth:sanctum')->get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Kelola Anggota
Route::middleware('auth:sanctum')->get('/admin/anggota', [AdminController::class, 'manajemenAnggota'])->name('admin.anggota');
Route::middleware('auth:sanctum')->get('/admin/anggota/create', [AnggotaController::class, 'create'])->name('admin.anggota.create');  // Form tambah anggota
Route::middleware('auth:sanctum')->post('/admin/anggota', [AnggotaController::class, 'store'])->name('admin.anggota.store');  // Menyimpan anggota
Route::middleware('auth:sanctum')->get('/admin/anggota/{id}', [AnggotaController::class, 'show'])->name('admin.anggota.show');  // Melihat detail anggota
Route::middleware('auth:sanctum')->get('/admin/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('admin.anggota.edit');  // Form edit anggota
Route::middleware('auth:sanctum')->put('/admin/anggota/{id}', [AnggotaController::class, 'update'])->name('admin.anggota.update');  // Update anggota
Route::middleware('auth:sanctum')->delete('/admin/anggota/{id}', [AnggotaController::class, 'destroy'])->name('admin.anggota.destroy');  // Hapus anggota


Route::middleware('auth:sanctum')->get('/admin/kolektor/{id}/edit', [KolektorController::class, 'edit'])->name('admin.kolektor.edit');
Route::middleware('auth:sanctum')->put('/admin/kolektor/{id}', [KolektorController::class, 'update'])->name('admin.kolektor.update');

// Kelola KolektorRoute::middleware('auth:sanctum')->get('/kolektor/{id}', [KolektorController::class, 'show']);
Route::middleware('auth:sanctum')->post('/kolektor', [KolektorController::class, 'store']);  // Menambah Kolektor
Route::middleware('auth:sanctum')->post('/kolektor/payment', [KolektorController::class, 'recordPayment']);  // Mencatat Pembayaran Angsuran

// Route untuk Pinjaman
Route::middleware('auth:sanctum')->get('/admin/kolektor', [KolektorController::class, 'index'])->name('admin.kolektor');  // Daftar kolektor
Route::middleware('auth:sanctum')->get('/admin/kolektor/create', [KolektorController::class, 'create'])->name('admin.kolektor.create');  // Form tambah kolektor
Route::middleware('auth:sanctum')->post('/admin/kolektor', [KolektorController::class, 'store'])->name('admin.kolektor.store');  // Menyimpan kolektor baru
Route::middleware('auth:sanctum')->get('/admin/kolektor/{id}', [KolektorController::class, 'show'])->name('admin.kolektor.show');  // Melihat detail kolektor
Route::middleware('auth:sanctum')->delete('/admin/kolektor/{id}', [KolektorController::class, 'destroy'])->name('admin.kolektor.destroy');  // Menghapus kolektor

// Kelola Pinjaman
Route::middleware('auth:sanctum')->get('/admin/pinjaman', [PinjamanController::class, 'index'])->name('admin.pinjaman');  // Daftar pinjaman
Route::middleware('auth:sanctum')->post('/admin/pinjaman', [PinjamanController::class, 'create'])->name('admin.pinjaman.create');  // Menambah pinjaman

// Laporan Keuangan
Route::middleware('auth:sanctum')->get('/admin/laporan', [LaporanKeuanganController::class, 'generateReport'])->name('admin.laporan');  // Menampilkan laporan keuangan
Route::middleware('auth:sanctum')->get('/admin/laporan/export', [LaporanKeuanganController::class, 'exportLaporanKeuangan'])->name('admin.laporan.export');  // Ekspor laporan keuangan
