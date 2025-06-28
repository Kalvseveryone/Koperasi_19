

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Histori Pembayaran</h5>
                </div>

                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

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
                                    <th>Status</th>
                                    <th>Bukti</th>
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
                                            <?php if($payment->status === 'approved'): ?>
                                                <span class="badge bg-success">Disetujui</span>
                                            <?php elseif($payment->status === 'rejected'): ?>
                                                <span class="badge bg-danger">Ditolak</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Pending</span>
                                            <?php endif; ?>
                                        </td>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pembayaran</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($payments->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/payments/history.blade.php ENDPATH**/ ?>