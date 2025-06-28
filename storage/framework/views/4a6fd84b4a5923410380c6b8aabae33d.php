<?php $__env->startSection('title', 'Detail Anggota Binaan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.modal-backdrop {
    z-index: 1040 !important;
}
.modal {
    z-index: 1050 !important;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Anggota</h5>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" onclick="showPaymentModal()">
                                <i class="bi bi-plus-circle"></i> Ajukan Pembayaran
                            </button>
                            <a href="<?php echo e(route('kolektor.anggota-binaan')); ?>" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama</th>
                                    <td><?php echo e($anggota->nama); ?></td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td><?php echo e($anggota->nik); ?></td>
                                </tr>
                                <tr>
                                    <th>No. Telepon</th>
                                    <td><?php echo e($anggota->no_telepon); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo e($anggota->email); ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?php echo e($anggota->alamat); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Saldo Simpanan</th>
                                    <td>Rp <?php echo e(number_format($anggota->saldo_simpanan, 0, ',', '.')); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-<?php echo e($anggota->status === 'aktif' ? 'success' : 'danger'); ?>">
                                            <?php echo e(ucfirst($anggota->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Bergabung</th>
                                    <td><?php echo e($anggota->created_at->format('d F Y')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Pembayaran</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $anggota->paymentSubmissions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($payment->tanggal_pembayaran->format('d/m/Y')); ?></td>
                                    <td>Rp <?php echo e(number_format($payment->jumlah_pembayaran, 0, ',', '.')); ?></td>
                                    <td>
                                        <?php if($payment->status === 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php elseif($payment->status === 'approved'): ?>
                                            <span class="badge bg-success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($payment->catatan ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada riwayat pembayaran</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Ajukan Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="anggota_id" value="<?php echo e($anggota->id); ?>">
                    
                    <div class="mb-3">
                        <label for="jumlah_pembayaran" class="form-label">Jumlah Pembayaran (Rp)</label>
                        <input type="number" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" required>
                    </div>

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="">Pilih metode pembayaran</option>
                            <option value="tunai">Tunai</option>
                            <option value="transfer">Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bulan_pembayaran" class="form-label">Bulan Pembayaran</label>
                                <select class="form-control" id="bulan_pembayaran" name="bulan_pembayaran" required>
                                    <option value="">Pilih bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_pembayaran" class="form-label">Tahun Pembayaran</label>
                                <select class="form-control" id="tahun_pembayaran" name="tahun_pembayaran" required>
                                    <option value="">Pilih tahun</option>
                                    <?php for($year = date('Y') - 1; $year <= date('Y') + 1; $year++): ?>
                                        <option value="<?php echo e($year); ?>" <?php echo e($year == date('Y') ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/*" required>
                        <small class="text-muted">Upload bukti pembayaran (maksimal 2MB)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');

    // Show modal function
    window.showPaymentModal = function() {
        modal.show();
    };

    // Handle form submission
    submitBtn.addEventListener('click', function() {
        const formData = new FormData(form);

        // Disable form inputs and submit button
        form.querySelectorAll('input, select').forEach(el => el.disabled = true);
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

        fetch('<?php echo e(route("kolektor.payment.submit")); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        })
        .then(response => response.json())
        .then(data => {
            modal.hide();
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
            form.querySelectorAll('input, select').forEach(el => el.disabled = false);
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Simpan';
        });
    });

    // Reset form when modal is hidden
    document.getElementById('paymentModal').addEventListener('hidden.bs.modal', function () {
        form.reset();
        form.querySelectorAll('input, select').forEach(el => el.disabled = false);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan';
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/kolektor/anggota-binaan/show.blade.php ENDPATH**/ ?>