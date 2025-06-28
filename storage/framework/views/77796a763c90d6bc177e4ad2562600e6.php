<?php $__env->startSection('title', 'Riwayat Transaksi - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Riwayat Transaksi</h2>
                <a href="<?php echo e(route('anggota.dashboard')); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="mb-4">
                        <form action="<?php echo e(route('anggota.history')); ?>" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="jenis" class="form-label">Jenis Transaksi</label>
                                <select name="jenis" id="jenis" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="simpanan" <?php echo e(request('jenis') == 'simpanan' ? 'selected' : ''); ?>>Simpanan</option>
                                    <option value="pinjaman" <?php echo e(request('jenis') == 'pinjaman' ? 'selected' : ''); ?>>Pinjaman</option>
                                    <option value="angsuran" <?php echo e(request('jenis') == 'angsuran' ? 'selected' : ''); ?>>Angsuran</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Semua</option>
                                    <option value="sukses" <?php echo e(request('status') == 'sukses' ? 'selected' : ''); ?>>Sukses</option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="ditolak" <?php echo e(request('status') == 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo e(request('tanggal_mulai')); ?>">
                            </div>
                            <div class="col-md-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?php echo e(request('tanggal_akhir')); ?>">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?php echo e(route('anggota.history')); ?>" class="btn btn-secondary">Reset Filter</a>
                            </div>
                        </form>
                    </div>

                    <!-- Transactions Table -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($t->created_at->format('d M Y H:i')); ?></td>
                                        <td><?php echo e(ucfirst($t->jenis_transaksi)); ?></td>
                                        <td>
                                            <?php if($t->jenis_transaksi == 'simpanan'): ?>
                                                <?php echo e(ucfirst($t->jenis_simpanan)); ?> 
                                                (<?php echo e(isset($t->type) && $t->type === 'keluar' ? 'Penarikan' : 'Setoran'); ?>)
                                            <?php elseif($t->jenis_transaksi == 'pinjaman'): ?>
                                                Pencairan Pinjaman
                                            <?php elseif($t->jenis_transaksi == 'angsuran'): ?>
                                                Pembayaran Angsuran
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $isNegative = isset($t->type) && $t->type === 'keluar' || $t->jumlah < 0;
                                                $amount = abs($t->jumlah);
                                            ?>
                                            <span class="<?php echo e($isNegative ? 'text-danger' : 'text-success'); ?>">
                                                <?php echo e($isNegative ? '-' : ''); ?>Rp <?php echo e(number_format($amount, 0, ',', '.')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                                $badgeClass = match($t->status) {
                                                    'sukses' => 'success',
                                                    'pending' => 'warning',
                                                    'gagal', 'ditolak' => 'danger',
                                                    default => 'secondary'
                                                };
                                                $statusText = match($t->status) {
                                                    'gagal' => 'Ditolak',
                                                    default => ucfirst($t->status)
                                                };
                                            ?>
                                            <span class="badge bg-<?php echo e($badgeClass); ?>">
                                                <?php echo e($statusText); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada transaksi</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($transaksi->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/anggota/history.blade.php ENDPATH**/ ?>