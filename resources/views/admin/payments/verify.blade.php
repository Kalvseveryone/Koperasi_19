@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran - KitaAda Koperasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifikasi Pembayaran</div>

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

                    <div class="mb-4">
                        <h5>Detail Pembayaran</h5>
                        <table class="table">
                            <tr>
                                <th>Anggota</th>
                                <td>{{ $payment->anggota->nama }}</td>
                            </tr>
                            <tr>
                                <th>Kolektor</th>
                                <td>{{ $payment->kolektor->nama }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <td>{{ $payment->tanggal_pembayaran->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
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
                        </table>
                    </div>

                    <form method="POST" action="{{ route('admin.payments.verify.submit', $payment->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_approved" value="approved" required>
                                <label class="form-check-label" for="status_approved">
                                    Setujui
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_rejected" value="rejected" required>
                                <label class="form-check-label" for="status_rejected">
                                    Tolak
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                            <a href="{{ route('admin.payments.pending') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 