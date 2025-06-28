<?php $__env->startSection('title', 'Ajukan Pinjaman - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Ajukan Pinjaman</h2>
                <a href="<?php echo e(route('anggota.pinjaman.index')); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('anggota.pinjaman.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="jumlah" class="form-label">Jumlah Pinjaman</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['jumlah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="jumlah" 
                                       name="jumlah" 
                                       value="<?php echo e(old('jumlah')); ?>"
                                       min="100000"
                                       required>
                            </div>
                            <small class="text-muted">Minimal Rp 100.000</small>
                            <?php $__errorArgs = ['jumlah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label for="jangka_waktu" class="form-label">Jangka Waktu (Bulan)</label>
                            <select class="form-select <?php $__errorArgs = ['jangka_waktu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="jangka_waktu" 
                                    name="jangka_waktu" 
                                    required>
                                <option value="">Pilih jangka waktu</option>
                                <?php for($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e(old('jangka_waktu') == $i ? 'selected' : ''); ?>>
                                        <?php echo e($i); ?> bulan
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <?php $__errorArgs = ['jangka_waktu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label for="tujuan" class="form-label">Tujuan Pinjaman</label>
                            <textarea class="form-control <?php $__errorArgs = ['tujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="tujuan" 
                                      name="tujuan" 
                                      rows="3" 
                                      required><?php echo e(old('tujuan')); ?></textarea>
                            <small class="text-muted">Jelaskan tujuan penggunaan dana pinjaman</small>
                            <?php $__errorArgs = ['tujuan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Pinjaman</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <strong>Syarat Pinjaman:</strong>
                            <ul class="mt-2">
                                <li>Minimal pinjaman Rp 100.000</li>
                                <li>Maksimal jangka waktu 12 bulan</li>
                                <li>Harus memiliki simpanan aktif</li>
                            </ul>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <strong>Proses Persetujuan:</strong>
                            <p class="mt-2 mb-0">
                                Pengajuan pinjaman akan diproses dalam waktu 1-3 hari kerja.
                                Anda akan mendapat notifikasi setelah pinjaman disetujui.
                            </p>
                        </li>
                        <li>
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            <strong>Penting:</strong>
                            <p class="mt-2 mb-0">
                                Pastikan data yang diisi benar dan sesuai dengan kebutuhan Anda.
                                Pengajuan tidak dapat dibatalkan setelah disetujui.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/anggota/pinjaman/create.blade.php ENDPATH**/ ?>