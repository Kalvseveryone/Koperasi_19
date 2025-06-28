@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-4">Dashboard Admin</h1>

    <div class="row">
        <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-3">Total Anggota</h5>
                    <p class="card-text display-6 fw-bold mb-0">{{ $totalAnggota }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success mb-3">Total Pinjaman</h5>
                    <p class="card-text display-6 fw-bold mb-0">{{ $totalPinjaman }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-info mb-3">Total Simpanan</h5>
                    <p class="card-text display-6 fw-bold mb-0">{{ $totalSimpanan }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning mb-3">Total Transaksi</h5>
                    <p class="card-text display-6 fw-bold mb-0">{{ $totalTransaksi }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
