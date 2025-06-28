@extends('layouts.app')

@section('title', 'Dashboard Anggota - KitaAda Koperasi')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>Selamat Datang, {{ $anggota->nama }}</h2>
        </div>
    </div>

    <div class="row">
        <!-- Saldo Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Saldo Simpanan</h5>
                    <h2 class="text-primary">Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</h2>
                    <a href="{{ route('anggota.saldo') }}" class="btn btn-outline-primary mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>

        <!-- Pinjaman Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Pinjaman</h5>
                    @if($anggota->total_pinjaman > 0)
                        <h2 class="text-danger">Rp {{ number_format($anggota->total_pinjaman, 0, ',', '.') }}</h2>
                        <p class="text-muted">Jangka Waktu: {{ $pinjaman->jangka_waktu ?? 0 }} bulan</p>
                        <p class="text-danger mb-0">Denda: Rp {{ number_format($anggota->total_denda, 0, ',', '.') }}</p>
                    @else
                        <p class="text-muted">Tidak ada pinjaman aktif</p>
                        <a href="{{ route('anggota.pinjaman.create') }}" class="btn btn-primary mt-2">Ajukan Pinjaman</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Menu Cepat</h5>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('anggota.pinjaman.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Lihat Pinjaman
                        </a>
                        <a href="{{ route('anggota.history') }}" class="btn btn-outline-info">
                            <i class="fas fa-history"></i> Riwayat Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaksi Terakhir -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Transaksi Terakhir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi as $t)
                                    <tr>
                                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ ucfirst($t->jenis) }}</td>
                                        <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $t->status == 'sukses' ? 'success' : ($t->status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($t->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
