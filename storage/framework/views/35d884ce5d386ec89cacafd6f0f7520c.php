

<?php $__env->startSection('title', 'Pembayaran Pending - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pembayaran Pending</h5>
                    <a href="<?php echo e(route('admin.payments.history')); ?>" class="btn btn-info">
                        <i class="fas fa-history"></i> Lihat Histori Pembayaran
                    </a>
                </div>

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
                                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($payment->tanggal_pembayaran->format('d/m/Y')); ?></td>
                                        <td><?php echo e($payment->anggota->nama); ?></td>
                                        <td><?php echo e($payment->kolektor->nama); ?></td>
                                        <td>Rp <?php echo e(number_format($payment->jumlah_pembayaran, 0, ',', '.')); ?></td>
                                        <td>
                                            <?php if($payment->bukti_pembayaran): ?>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#buktiModal<?php echo e($payment->id); ?>">
                                                    Lihat Bukti
                                                </button>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">Pending</span>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.payments.verify', $payment->id)); ?>" class="btn btn-sm btn-primary">
                                                Verifikasi
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal Bukti Pembayaran -->
                                    <?php if($payment->bukti_pembayaran): ?>
                                    <div class="modal fade" id="buktiModal<?php echo e($payment->id); ?>" tabindex="-1" aria-labelledby="buktiModalLabel<?php echo e($payment->id); ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="buktiModalLabel<?php echo e($payment->id); ?>">Bukti Pembayaran - <?php echo e($payment->anggota->nama); ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="<?php echo e(url('storage/' . $payment->bukti_pembayaran)); ?>" class="img-fluid" alt="Bukti Pembayaran">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada pembayaran yang pending</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php echo e($payments->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.modal-body img {
    max-height: 80vh;
    width: auto;
    margin: 0 auto;
}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/payments/pending.blade.php ENDPATH**/ ?>