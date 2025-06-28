<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KolektorController;

Route::middleware(['auth:kolektor'])->group(function () {
    // Dashboard kolektor
    Route::get('/dashboard', function () {
        return view('kolektor.dashboard');
    })->name('kolektor.dashboard');

    // Anggota binaan routes
    Route::get('/anggota-binaan', [KolektorController::class, 'anggotaBinaan'])
         ->name('kolektor.anggota-binaan');
    
    Route::get('/anggota-binaan/{id}', [KolektorController::class, 'detailAnggota'])
         ->name('kolektor.anggota.detail');
    
    Route::post('/anggota-binaan/record-payment', [KolektorController::class, 'recordPayment'])
         ->name('kolektor.anggota.record-payment');
    
    // Laporan routes
    Route::get('/laporan', [KolektorController::class, 'laporan'])
         ->name('kolektor.laporan');
});
