<?php $__env->startSection('title', 'Anggota - KitaAda Koperasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Anggota</h3>
                </div>
                <div class="card-body">
                    <div class="top-actions mb-3">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="<?php echo e(route('admin.anggota.create')); ?>" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Anggota
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table id="anggotaTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>No. Telepon</th>
                                    <th>Email</th>
                                    <th class="text-center">Saldo Simpanan</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $anggotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($anggota->nama); ?></td>
                                    <td><?php echo e($anggota->nik); ?></td>
                                    <td><?php echo e($anggota->no_telepon); ?></td>
                                    <td><?php echo e($anggota->email); ?></td>
                                    <td class="text-end">Rp <?php echo e(number_format($anggota->saldo_simpanan, 0, ',', '.')); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.anggota.show', $anggota->id)); ?>" class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.anggota.edit', $anggota->id)); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.anggota.destroy', $anggota->id)); ?>" method="POST" class="d-inline delete-form">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus anggota ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

$(document).ready(function() {
    $('#anggotaTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Semua']
        ],
        order: [[0, 'asc']]
    });

    <?php if(session('success') || session('message')): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: '<?php echo e(session("success") ?? session("message")); ?>',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        });
    <?php endif; ?>

    <?php if(session('error')): ?>
        Swal.fire({
            title: 'Error!',
            text: '<?php echo e(session("error")); ?>',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/anggota/anggota.blade.php ENDPATH**/ ?>