@extends('layouts.app')

@section('title', 'Dashboard Kolektor')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Statistik -->
        <div class="col-md-12 mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Anggota Binaan</h6>
                            <h3 class="mb-0">{{ $totalAnggota ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Pembayaran Hari Ini</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalPembayaranHariIni ?? 0, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6 class="text-muted">Total Pembayaran Bulan Ini</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalPembayaranBulanIni ?? 0, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Cepat -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Menu Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('kolektor.anggota-binaan') }}" class="btn btn-outline-primary w-100 mb-3">
                                <i class="bi bi-people"></i> Lihat Anggota Binaan
                            </a>
                        </div>
                       
                        <div class="col-md-4">
                            <a href="{{ route('kolektor.laporan') }}" class="btn btn-outline-info w-100 mb-3">
                                <i class="bi bi-file-text"></i> Lihat Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        
    </div>
</div>

<!-- Modal Catat Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catat Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select class="form-select" name="anggota_id" required>
                            <option value="">Pilih anggota</option>
                            @foreach($anggotaBinaan ?? [] as $anggota)
                                <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" name="jumlah_pembayaran" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select class="form-select" name="metode" required>
                            <option value="">Pilih metode</option>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="submitPayment()">Simpan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showPaymentModal() {
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

function submitPayment() {
    const form = document.getElementById('paymentForm');
    const formData = new FormData(form);

    fetch('{{ route("kolektor.anggota-binaan.payment", ['id' => ':id']) }}'.replace(':id', formData.get('anggota_id')), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message
            }).then(() => {
                location.reload();
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Terjadi kesalahan! Silakan coba lagi.'
        });
    });
}
</script>
@endpush
