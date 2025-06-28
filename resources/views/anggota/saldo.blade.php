@extends('layouts.app')

@section('title', 'Detail Saldo - KitaAda Koperasi')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Detail Saldo</h2>
                <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Saldo Simpanan Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Saldo Simpanan</h5>
                    <div class="mt-4">
                        <h1 class="text-primary">Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</h1>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            Saldo simpanan adalah jumlah uang yang Anda miliki di koperasi.
                            Saldo ini dapat digunakan untuk membayar angsuran pinjaman atau ditarik sesuai ketentuan.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Simpanan Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Simpanan</h5>
                    <div class="mt-3">
                        <p><strong>Jenis Simpanan:</strong></p>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="fas fa-piggy-bank text-primary me-2"></i>
                                Simpanan Pokok
                                <small class="d-block text-muted">Simpanan wajib saat pertama kali menjadi anggota</small>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-wallet text-success me-2"></i>
                                Simpanan Wajib
                                <small class="d-block text-muted">Simpanan rutin bulanan sebagai anggota</small>
                            </li>
                            <li>
                                <i class="fas fa-coins text-warning me-2"></i>
                                Simpanan Sukarela
                                <small class="d-block text-muted">Simpanan tambahan yang dapat dilakukan sewaktu-waktu</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Simpanan -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Simpanan</h5>
                    <div class="table-responsive mt-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis Simpanan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $simpananTransaksi = \App\Models\SimpananTransaction::where('anggota_id', $anggota->id)
                                        ->latest()
                                        ->take(5)
                                        ->get();
                                @endphp
                                @forelse($simpananTransaksi as $t)
                                    <tr>
                                        <td>{{ $t->created_at->format('d M Y') }}</td>
                                        <td>{{ ucfirst($t->jenis_simpanan) }}</td>
                                        <td>
                                            @if($t->type === 'keluar')
                                                <span class="text-danger">- Rp {{ number_format($t->jumlah, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-success">+ Rp {{ number_format($t->jumlah, 0, ',', '.') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">Sukses</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada riwayat simpanan</td>
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
