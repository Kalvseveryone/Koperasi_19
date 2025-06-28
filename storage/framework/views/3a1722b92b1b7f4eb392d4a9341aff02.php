<?php $__env->startSection('title', 'Daftar Anggota Binaan'); ?>

<?php $__env->startSection('content'); ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $anggotaBinaan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($anggota->nama); ?></td>
                            <td><?php echo e($anggota->nik); ?></td>
                            <td><?php echo e($anggota->no_telepon); ?></td>
                            <td><?php echo e($anggota->email); ?></td>
                            <td><?php echo e($anggota->alamat); ?></td>
                            <td>Rp <?php echo e(number_format($anggota->saldo_simpanan, 0, ',', '.')); ?></td>
                            <td>
                                <a href="<?php echo e(route('kolektor.anggota-binaan.show', $anggota->id)); ?>" 
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada anggota binaan</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
    fetch('<?php echo e(route("kolektor.anggota-binaan.payment", ':id')); ?>'.replace(':id', anggotaId), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/kolektor/anggota-binaan/index.blade.php ENDPATH**/ ?>