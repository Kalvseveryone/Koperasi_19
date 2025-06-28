@extends('layouts.app')

@section('title', 'Riwayat Transaksi - KitaAda Koperasi')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Riwayat Transaksi</h2>
                <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="mb-4">
                        <form action="{{ route('anggota.history') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="jenis" class="form-label">Jenis Transaksi</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="simpanan" {{ request('jenis') == 'simpanan' ? 'selected' : '' }}>Simpanan</option>
                                    <option value="pinjaman" {{ request('jenis') == 'pinjaman' ? 'selected' : '' }}>Pinjaman</option>
                                    <option value="angsuran" {{ request('jenis') == 'angsuran' ? 'selected' : '' }}>Angsuran</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="sukses" {{ request('status') == 'sukses' ? 'selected' : '' }}>Sukses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('anggota.history') }}" class="btn btn-secondary">Reset Filter</a>
                            </div>
                        </form>
                    </div>

                    <!-- Transactions Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi as $t)
                                    <tr>
                                        <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ ucfirst($t->jenis_transaksi) }}</td>
                                        <td>
                                            @if($t->jenis_transaksi == 'simpanan')
                                                {{ ucfirst($t->jenis_simpanan) }} 
                                                ({{ isset($t->type) && $t->type === 'keluar' ? 'Penarikan' : 'Setoran' }})
                                            @elseif($t->jenis_transaksi == 'pinjaman')
                                                Pencairan Pinjaman
                                            @elseif($t->jenis_transaksi == 'angsuran')
                                                Pembayaran Angsuran
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $isNegative = isset($t->type) && $t->type === 'keluar' || $t->jumlah < 0;
                                                $amount = abs($t->jumlah);
                                            @endphp
                                            <span class="{{ $isNegative ? 'text-danger' : 'text-success' }}">
                                                {{ $isNegative ? '-' : '' }}Rp {{ number_format($amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match($t->status) {
                                                    'sukses' => 'success',
                                                    'pending' => 'warning',
                                                    'gagal', 'ditolak' => 'danger',
                                                    default => 'secondary'
                                                };
                                                $statusText = match($t->status) {
                                                    'gagal' => 'Ditolak',
                                                    default => ucfirst($t->status)
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $transaksi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
