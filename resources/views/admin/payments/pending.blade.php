@extends('layouts.app')

@section('title', 'Pembayaran Pending - KitaAda Koperasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pembayaran Pending</h5>
                    <a href="{{ route('admin.payments.history') }}" class="btn btn-info">
                        <i class="fas fa-history"></i> Lihat Histori Pembayaran
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
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
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
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
                                            @if($payment->bukti_pembayaran)
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $payment->id }}">
                                                    Lihat Bukti
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.payments.verify', $payment->id) }}" class="btn btn-sm btn-primary">
                                                Verifikasi
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Bukti Pembayaran -->
                                    @if($payment->bukti_pembayaran)
                                    <div class="modal fade" id="buktiModal{{ $payment->id }}" tabindex="-1" aria-labelledby="buktiModalLabel{{ $payment->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel{{ $payment->id }}">Bukti Pembayaran - {{ $payment->anggota->nama }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ url('storage/' . $payment->bukti_pembayaran) }}" class="img-fluid" alt="Bukti Pembayaran">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada pembayaran yang pending</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.modal-body img {
    max-height: 80vh;
    width: auto;
    margin: 0 auto;
}
</style>
@endpush
@endsection 