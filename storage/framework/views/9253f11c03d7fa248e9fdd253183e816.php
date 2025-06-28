<?php $__env->startSection('title', 'Daftar Pinjaman - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<script>
function showDetailModal(nama, jumlah, denda, jangka, tujuan) {
    document.getElementById('detail-nama').textContent = nama;
    document.getElementById('detail-jumlah').textContent = 'Rp ' + jumlah;
    document.getElementById('detail-denda').textContent = 'Rp ' + denda;
    document.getElementById('detail-jangka').textContent = jangka + ' bulan';
    document.getElementById('detail-tujuan').textContent = tujuan;
    var modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}
</script>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Daftar Pinjaman</h2>
                <div>
                    <a href="<?php echo e(route('anggota.dashboard')); ?>" class="btn btn-secondary me-2">Kembali</a>
                    <a href="<?php echo e(route('anggota.pinjaman.create')); ?>" class="btn btn-primary">Ajukan Pinjaman</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jumlah</th>
                                    <th>Denda</th>
                                    <th>Jangka Waktu</th>
                                    <th>Status</th>
                                    <th>Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pinjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($p->created_at->format('d M Y')); ?></td>
                                        <td>Rp <?php echo e(number_format($p->jumlah, 0, ',', '.')); ?></td>
                                        <td>Rp <?php echo e(number_format($p->denda, 0, ',', '.')); ?></td>
                                        <td><?php echo e($p->jangka_waktu); ?> bulan</td>
                                        <td>
                                            <?php if($p->status == 'ditolak'): ?>
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    <small class="text-danger" style="font-size: 11px; line-height: 1.2;">
                                                        <?php echo e($p->catatan); ?>

                                                    </small>
                                                </div>
                                            <?php else: ?>
                                                <span class="badge bg-<?php echo e($p->status == 'pending' ? 'warning' : ($p->status == 'aktif' ? 'success' : 'info')); ?>">
                                                    <?php echo e(ucfirst($p->status)); ?>

                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($p->tujuan); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="showDetailModal('<?php echo e($p->anggota->nama); ?>', '<?php echo e(number_format($p->jumlah, 0, ',', '.')); ?>', '<?php echo e(number_format($p->denda, 0, ',', '.')); ?>', '<?php echo e($p->jangka_waktu); ?>', '<?php echo e($p->tujuan); ?>')">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pinjaman</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($pinjaman->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pinjaman -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Nama:</label>
                        <div id="detail-nama"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Jumlah Pinjaman:</label>
                        <div id="detail-jumlah"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Denda:</label>
                        <div id="detail-denda"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Jangka Waktu:</label>
                        <div id="detail-jangka"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Tujuan:</label>
                        <div id="detail-tujuan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/anggota/pinjaman/index.blade.php ENDPATH**/ ?>