

<?php $__env->startSection('title', 'Verifikasi Pembayaran - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifikasi Pembayaran</div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <h5>Detail Pembayaran</h5>
                        <table class="table">
                            <tr>
                                <th>Anggota</th>
                                <td><?php echo e($payment->anggota->nama); ?></td>
                            </tr>
                            <tr>
                                <th>Kolektor</th>
                                <td><?php echo e($payment->kolektor->nama); ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <td><?php echo e($payment->tanggal_pembayaran->format('d/m/Y')); ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>Rp <?php echo e(number_format($payment->jumlah_pembayaran, 0, ',', '.')); ?></td>
                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <td>
                                    <?php if($payment->bukti_pembayaran): ?>
                                        <a href="<?php echo e(url('storage/' . $payment->bukti_pembayaran)); ?>" target="_blank" class="btn btn-sm btn-info">
                                            Lihat Bukti
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <form method="POST" action="<?php echo e(route('admin.payments.verify.submit', $payment->id)); ?>">
                        <?php echo csrf_field(); ?>
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
                            <a href="<?php echo e(route('admin.payments.pending')); ?>" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/payments/verify.blade.php ENDPATH**/ ?>