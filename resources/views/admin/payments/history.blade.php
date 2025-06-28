@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Histori Pembayaran</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Anggota</th>
                                    <th>Kolektor</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->tanggal_pembayaran->format('d/m/Y') }}</td>
                                        <td>{{ $payment->anggota->nama }}</td>
                                        <td>{{ $payment->kolektor->nama }}</td>
                                        <td>Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</td>
                                        <td>
                                            @if($payment->status === 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->bukti_pembayaran)
                                                <a href="{{ url('storage/' . $payment->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-info">
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 