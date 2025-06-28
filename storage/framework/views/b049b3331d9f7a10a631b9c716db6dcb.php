<?php $__env->startSection('title', 'Manajemen Simpanan - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Simpanan</h3>
                </div>
                <div class="card-body">
                    <!-- Tabel Saldo Simpanan -->
                    <h4>Saldo Simpanan Anggota</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <th>Simpanan Pokok</th>
                                    <th>Simpanan Wajib</th>
                                    <th>Simpanan Sukarela</th>
                                    <th>Total Simpanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $anggotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($anggota->nama); ?></td>
                                    <td>Rp <?php echo e(number_format($anggota->simpanan_pokok, 2, ',', '.')); ?></td>
                                    <td>Rp <?php echo e(number_format($anggota->simpanan_wajib, 2, ',', '.')); ?></td>
                                    <td>Rp <?php echo e(number_format($anggota->simpanan_sukarela, 2, ',', '.')); ?></td>
                                    <td>Rp <?php echo e(number_format($anggota->saldo_simpanan, 2, ',', '.')); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSimpananModal" data-anggota-id="<?php echo e($anggota->id); ?>" data-anggota-nama="<?php echo e($anggota->nama); ?>">
                                            Tambah Simpanan
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Riwayat Transaksi -->
                    <h4>Riwayat Transaksi Simpanan</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Anggota</th>
                                    <th>Jenis Simpanan</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($transaction->created_at->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo e($transaction->anggota->nama); ?></td>
                                    <td><?php echo e(ucfirst($transaction->jenis_simpanan)); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($transaction->type === 'masuk' ? 'success' : 'danger'); ?>">
                                            <?php echo e(ucfirst($transaction->type)); ?>

                                        </span>
                                    </td>
                                    <td>Rp <?php echo e(number_format($transaction->jumlah, 2, ',', '.')); ?></td>
                                    <td><?php echo e($transaction->keterangan ?? '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Simpanan -->
<div class="modal fade" id="addSimpananModal" tabindex="-1" aria-labelledby="addSimpananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSimpananModalLabel">Tambah Simpanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.simpanan.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="anggota_id" id="anggota_id">
                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <input type="text" class="form-control" id="anggota_nama" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jenis Simpanan</label>
                        <select name="jenis_simpanan" class="form-control" required>
                            <option value="">Pilih Jenis Simpanan</option>
                            <option value="pokok">Simpanan Pokok</option>
                            <option value="wajib">Simpanan Wajib</option>
                            <option value="sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tipe Transaksi</label>
                        <select name="type" class="form-control" required>
                            <option value="masuk">Masuk (Setor)</option>
                            <option value="keluar">Keluar (Tarik)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" required min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addSimpananModal = document.getElementById('addSimpananModal');
        if (addSimpananModal) {
            addSimpananModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const anggotaId = button.getAttribute('data-anggota-id');
                const anggotaNama = button.getAttribute('data-anggota-nama');
                const modal = this;
                modal.querySelector('#anggota_id').value = anggotaId;
                modal.querySelector('#anggota_nama').value = anggotaNama;
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/simpanan/index.blade.php ENDPATH**/ ?>