<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KolektorController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AdminController;


// Route untuk registrasi user baru
Route::post('register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|string|in:anggota,admin',  // Role bisa memilih 'anggota' atau 'admin'
    ]);

    // Membuat user dengan role 'anggota' secara default
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,  // Role bisa berupa 'anggota' atau 'admin' yang dipilih saat registrasi
    ]);

    return response()->json(['message' => 'User registered successfully']);
});

// Route untuk login dan mendapatkan token
Route::post('login', function (Request $request) {
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:8',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('Personal Access Token')->plainTextToken;

    return response()->json(['token' => $token]);
});

// Middleware untuk mendapatkan informasi user yang terautentikasi
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk Anggota
Route::middleware('auth:sanctum')->get('/anggota/{id}/simpanan', [AnggotaController::class, 'showSimpanan']);  // Melihat saldo simpanan
Route::middleware('auth:sanctum')->post('/anggota', [AnggotaController::class, 'store']);  // Menambah anggota
Route::middleware('auth:sanctum')->get('/anggota/{id}', [AnggotaController::class, 'show']);  // Melihat detail anggota
Route::middleware('auth:sanctum')->put('/anggota/{id}', [AnggotaController::class, 'update']);  // Mengupdate data anggota

// Route untuk Menghapus Anggota oleh Admin
Route::middleware(['auth:sanctum', 'role:admin'])->delete('/anggota/{id}', [AnggotaController::class, 'destroy']);  // Menghapus anggota oleh admin

// Route untuk Kolektor
Route::middleware('auth:sanctum')->get('/kolektor/{id}', [KolektorController::class, 'show']);  // Melihat kolektor
Route::middleware('auth:sanctum')->post('/kolektor', [KolektorController::class, 'store']);  // Menambah Kolektor
Route::middleware('auth:sanctum')->post('/kolektor/payment', [KolektorController::class, 'recordPayment']);  // Mencatat Pembayaran Angsuran

// Route untuk Menghapus Kolektor oleh Admin
Route::middleware(['auth:sanctum', 'role:admin'])->delete('/kolektor/{id}', [KolektorController::class, 'destroy']);  // Menghapus kolektor oleh admin

// Route untuk Pinjaman
Route::middleware('auth:sanctum')->post('/pinjaman', [PinjamanController::class, 'create']);  // Membuat pinjaman baru
Route::middleware('auth:sanctum')->get('/pinjaman/{id}', [PinjamanController::class, 'show']);  // Melihat detail pinjaman

// Route untuk Laporan Keuangan
Route::middleware('auth:sanctum')->get('/laporan-keuangan', [LaporanKeuanganController::class, 'generateReport']);  // Menghasilkan laporan keuangan
Route::middleware('auth:sanctum')->get('/laporan-keuangan/export', [LaporanKeuanganController::class, 'exportLaporanKeuangan']); // Ekspor laporan keuangan


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/anggota', [AdminController::class, 'manajemenAnggota'])->name('admin.anggota');
    Route::get('/admin/kolektor', [AdminController::class, 'manajemenKolektor'])->name('admin.kolektor');
    Route::get('/admin/laporan-keuangan', [AdminController::class, 'laporanKeuangan'])->name('admin.laporanKeuangan');
    Route::get('/admin/rekap-harian', [AdminController::class, 'rekapHarian'])->name('admin.rekapHarian');
});
