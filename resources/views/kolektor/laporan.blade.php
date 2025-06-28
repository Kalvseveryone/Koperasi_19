@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Kolektor</h2>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Ringkasan Anggota Binaan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Total Simpanan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggotaBinaan as $anggota)
                        <tr>
                            <td>{{ $anggota->nama }}</td>
                            <td>Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</td>
                            <td>
                                @if($anggota->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-warning">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Riwayat Transaksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Anggota</th>
                            <th>Jenis Transaksi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $t)
                        <tr>
                            <td>{{ $t->tanggal_transaksi->format('d/m/Y H:i') }}</td>
                            <td>{{ $t->anggota->nama }}</td>
                            <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                            <td>Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
