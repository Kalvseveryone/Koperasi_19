@extends('layouts.app')

@section('title', 'Daftar Anggota Binaan')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Anggota Binaan</h5>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>No. Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Saldo Simpanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggotaBinaan as $index => $anggota)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $anggota->nama }}</td>
                            <td>{{ $anggota->nik }}</td>
                            <td>{{ $anggota->no_telepon }}</td>
                            <td>{{ $anggota->email }}</td>
                            <td>{{ $anggota->alamat }}</td>
                            <td>Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('kolektor.anggota-binaan.show', $anggota->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada anggota binaan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showPaymentModal(anggotaId, anggotaNama) {
    // Set form values
    document.getElementById('anggota_id').value = anggotaId;
    document.getElementById('anggota_nama').value = anggotaNama;
    
    // Show modal
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();
}

function submitPayment() {
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');
    const formData = new FormData(form);
    const anggotaId = document.getElementById('anggota_id').value;

    // Disable form inputs and submit button
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => input.disabled = true);
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

    // Submit form
    fetch('{{ route("kolektor.anggota-binaan.payment", ':id') }}'.replace(':id', anggotaId), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Hide modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        modal.hide();

        // Show success message
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
    })
    .finally(() => {
        // Re-enable form inputs and submit button
        inputs.forEach(input => input.disabled = false);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan';
    });
}

// Reset form when modal is hidden
document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.reset();
    form.querySelectorAll('input, select').forEach(el => el.disabled = false);
    submitBtn.disabled = false;
    submitBtn.innerHTML = 'Simpan';
});
</script>
@endpush
