<?php $__env->startSection('title', 'Laporan Keuangan - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Keuangan</h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('admin.laporan.export')); ?>" class="btn btn-success">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form action="<?php echo e(route('admin.laporan')); ?>" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo e(request('tanggal_mulai')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Akhir</label>
                                    <input type="date" name="tanggal_akhir" class="form-control" value="<?php echo e(request('tanggal_akhir')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary d-block">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Ringkasan -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Anggota</h5>
                                    <h3><?php echo e($laporan['total_anggota']); ?> orang</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Simpanan</h5>
                                    <h3>Rp <?php echo e(number_format($laporan['total_simpanan'], 0, ',', '.')); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pinjaman Aktif</h5>
                                    <h3>Rp <?php echo e(number_format($laporan['total_pinjaman'], 0, ',', '.')); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Denda</h5>
                                    <h3>Rp <?php echo e(number_format($laporan['total_denda'], 0, ',', '.')); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pinjaman -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Pinjaman</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status Pinjaman</th>
                                            <th>Jumlah Pinjaman</th>
                                            <th>Jumlah Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Pinjaman Aktif</td>
                                            <td>Rp <?php echo e(number_format($laporan['total_pinjaman'], 0, ',', '.')); ?></td>
                                            <td><?php echo e($laporan['pinjaman_aktif']); ?> transaksi</td>
                                        </tr>
                                        <tr>
                                            <td>Pinjaman Pending</td>
                                            <td>Rp <?php echo e(number_format($laporan['total_pinjaman_pending'], 0, ',', '.')); ?></td>
                                            <td><?php echo e($laporan['pinjaman_pending']); ?> transaksi</td>
                                        </tr>
                                        <tr>
                                            <td>Pinjaman Ditolak</td>
                                            <td>Rp <?php echo e(number_format($laporan['total_pinjaman_ditolak'], 0, ',', '.')); ?></td>
                                            <td><?php echo e($laporan['pinjaman_ditolak']); ?> transaksi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Detail Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Jenis Transaksi</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Total Transaksi</td>
                                            <td><?php echo e($laporan['total_transaksi']); ?> transaksi</td>
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <td>Angsuran</td>
                                            <td><?php echo e($laporan['total_transaksi']); ?> transaksi</td>
                                            <td>Rp <?php echo e(number_format($laporan['total_angsuran'], 0, ',', '.')); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Denda Dibayar</td>
                                            <td><?php echo e($laporan['total_transaksi']); ?> transaksi</td>
                                            <td>Rp <?php echo e(number_format($laporan['total_denda_bayar'], 0, ',', '.')); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <?php if(isset($laporan['transaksi_periode'])): ?>
                    <!-- Transaksi Periode -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Transaksi Periode</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $laporan['transaksi_periode']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($transaksi->created_at->format('d M Y H:i')); ?></td>
                                            <td><?php echo e(ucfirst($transaksi->jenis_transaksi)); ?></td>
                                            <td>Rp <?php echo e(number_format($transaksi->jumlah, 0, ',', '.')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($transaksi->status == 'sukses' ? 'success' : ($transaksi->status == 'pending' ? 'warning' : 'danger')); ?>">
                                                    <?php echo e(ucfirst($transaksi->status)); ?>

                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if(isset($laporan['pinjaman_periode'])): ?>
                    <!-- Pinjaman Periode -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pinjaman Periode</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Anggota</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Denda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $laporan['pinjaman_periode']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pinjaman): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($pinjaman->created_at->format('d M Y')); ?></td>
                                            <td><?php echo e($pinjaman->anggota->nama); ?></td>
                                            <td>Rp <?php echo e(number_format($pinjaman->jumlah, 0, ',', '.')); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo e($pinjaman->status == 'pending' ? 'warning' : ($pinjaman->status == 'disetujui' ? 'success' : ($pinjaman->status == 'aktif' ? 'primary' : 'danger'))); ?>">
                                                    <?php echo e(ucfirst($pinjaman->status)); ?>

                                                </span>
                                            </td>
                                            <td>Rp <?php echo e(number_format($pinjaman->denda, 0, ',', '.')); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AOS & Toggle Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/laporan/index.blade.php ENDPATH**/ ?>