@extends('layouts.app')

@section('title', 'Laporan Keuangan - KitaAda Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Keuangan</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.laporan.export') }}" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form action="{{ route('admin.laporan') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary d-block">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Anggota</h5>
                                    <h3>{{ $laporan['total_anggota'] }} orang</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Simpanan</h5>
                                    <h3>Rp {{ number_format($laporan['total_simpanan'], 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pinjaman Aktif</h5>
                                    <h3>Rp {{ number_format($laporan['total_pinjaman'], 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Denda</h5>
                                    <h3>Rp {{ number_format($laporan['total_denda'], 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pinjaman -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Pinjaman</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status Pinjaman</th>
                                            <th>Jumlah Pinjaman</th>
                                            <th>Jumlah Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Pinjaman Aktif</td>
                                            <td>Rp {{ number_format($laporan['total_pinjaman'], 0, ',', '.') }}</td>
                                            <td>{{ $laporan['pinjaman_aktif'] }} transaksi</td>
                                        </tr>
                                        <tr>
                                            <td>Pinjaman Pending</td>
                                            <td>Rp {{ number_format($laporan['total_pinjaman_pending'], 0, ',', '.') }}</td>
                                            <td>{{ $laporan['pinjaman_pending'] }} transaksi</td>
                                        </tr>
                                        <tr>
                                            <td>Pinjaman Ditolak</td>
                                            <td>Rp {{ number_format($laporan['total_pinjaman_ditolak'], 0, ',', '.') }}</td>
                                            <td>{{ $laporan['pinjaman_ditolak'] }} transaksi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jenis Transaksi</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Transaksi</td>
                                            <td>{{ $laporan['total_transaksi'] }} transaksi</td>
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <td>Angsuran</td>
                                            <td>{{ $laporan['total_transaksi'] }} transaksi</td>
                                            <td>Rp {{ number_format($laporan['total_angsuran'], 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Denda Dibayar</td>
                                            <td>{{ $laporan['total_transaksi'] }} transaksi</td>
                                            <td>Rp {{ number_format($laporan['total_denda_bayar'], 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if(isset($laporan['transaksi_periode']))
                    <!-- Transaksi Periode -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Transaksi Periode</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($laporan['transaksi_periode'] as $transaksi)
                                        <tr>
                                            <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ ucfirst($transaksi->jenis_transaksi) }}</td>
                                            <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $transaksi->status == 'sukses' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($transaksi->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($laporan['pinjaman_periode']))
                    <!-- Pinjaman Periode -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pinjaman Periode</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Anggota</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Denda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($laporan['pinjaman_periode'] as $pinjaman)
                                        <tr>
                                            <td>{{ $pinjaman->created_at->format('d M Y') }}</td>
                                            <td>{{ $pinjaman->anggota->nama }}</td>
                                            <td>Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $pinjaman->status == 'pending' ? 'warning' : ($pinjaman->status == 'disetujui' ? 'success' : ($pinjaman->status == 'aktif' ? 'primary' : 'danger')) }}">
                                                    {{ ucfirst($pinjaman->status) }}
                                                </span>
                                            </td>
                                            <td>Rp {{ number_format($pinjaman->denda, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS & Toggle Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
</script>
@endsection
