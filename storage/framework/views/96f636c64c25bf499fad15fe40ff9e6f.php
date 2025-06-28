

<?php $__env->startSection('title', 'Daftar Pinjaman - KitaAda Koperasi'); ?>


<?php $__env->startSection('title', 'Daftar Pinjaman'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Pinjaman</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pinjamanTable" class="table table-striped table-bordered display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Anggota</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Denda</th>
                            <th>Jangka Waktu</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            <th>Tanggal Pinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pinjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($p->anggota->nama); ?></td>
                            <td>Rp <?php echo e(number_format($p->jumlah, 2, ',', '.')); ?></td>
                            <td>Rp <?php echo e(number_format($p->denda, 2, ',', '.')); ?></td>
                            <td><?php echo e($p->jangka_waktu); ?> bulan</td>
                            <td><?php echo e($p->tujuan); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($p->status == 'pending' ? 'warning' : ($p->status == 'aktif' ? 'primary' : ($p->status == 'lunas' ? 'success' : 'danger'))); ?>">
                                    <?php echo e(ucfirst($p->status)); ?>

                                </span>
                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($p->tanggal_pinjam)->format('d-m-Y')); ?></td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    
                                    <a href="<?php echo e(route('admin.pinjaman.edit', $p->id)); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <?php if($p->status == 'pending'): ?>
                                        
                                        <button type="button" class="btn btn-sm btn-success btn-verify"
                                            data-id="<?php echo e($p->id); ?>" data-nama="<?php echo e($p->anggota->nama); ?>">
                                            <i class="fas fa-check"></i> Verifikasi
                                        </button>
                                    <?php endif; ?>

                                    <?php if($p->status == 'aktif'): ?>
                                        
                                        <button type="button" class="btn btn-sm btn-warning btn-add-denda"
                                            data-id="<?php echo e($p->id); ?>" data-nama="<?php echo e($p->anggota->nama); ?>">
                                            <i class="fas fa-exclamation-triangle"></i> Tambah Denda
                                        </button>

                                        <?php if($p->denda > 0): ?>
                                            
                                            <button type="button" class="btn btn-sm btn-info btn-delete-denda"
                                                data-id="<?php echo e($p->id); ?>" data-nama="<?php echo e($p->anggota->nama); ?>" data-denda="<?php echo e($p->denda); ?>">
                                                <i class="fas fa-eraser"></i> Hapus Denda
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deletePinjaman(<?php echo e($p->id); ?>)">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
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

<div class="modal fade" id="verifikasiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pinjaman: <span id="verifikasiNamaAnggota"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verifikasiForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif">Aktif</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
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

<div class="modal fade" id="dendaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Denda untuk: <span id="dendaNamaAnggota"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="dendaForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Denda</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="denda" class="form-control" required min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
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

<div class="modal fade" id="hapusDendaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus Denda dari: <span id="hapusDendaNamaAnggota"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="hapusDendaForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <p>Anda akan menghapus denda. Harap dicatat, ini akan menghapus **seluruh** jumlah denda yang ada.</p>
                    <p>Jumlah denda saat ini: <strong id="jumlahDendaSaatIni"></strong></p>
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Alasan Penghapusan)</label>
                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Semua Denda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi untuk hapus pinjaman (dari kode Anda, sudah bagus)
    function deletePinjaman(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa mengembalikan data pinjaman ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/pinjaman/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Terhapus!', 'Data pinjaman telah dihapus.', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        // Inisialisasi DataTable
        const pinjamanTable = $('#pinjamanTable').DataTable({
            responsive: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });

        // --- SCRIPT UNTUK MODAL DINAMIS ---

        // 1. Event listener untuk tombol Verifikasi
        $('#pinjamanTable tbody').on('click', '.btn-verify', function() {
            const pinjamanId = $(this).data('id');
            const namaAnggota = $(this).data('nama');
            
            // Set URL action form
            const url = `/admin/pinjaman/verify/${pinjamanId}`;
            $('#verifikasiForm').attr('action', url);

            // Set nama anggota di judul modal
            $('#verifikasiNamaAnggota').text(namaAnggota);

            // Tampilkan modal
            const verifikasiModal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
            verifikasiModal.show();
        });

        // 2. Event listener untuk tombol Tambah Denda
        $('#pinjamanTable tbody').on('click', '.btn-add-denda', function() {
            const pinjamanId = $(this).data('id');
            const namaAnggota = $(this).data('nama');
            
            // Set URL action form
            const url = `/admin/pinjaman/add-denda/${pinjamanId}`;
            $('#dendaForm').attr('action', url);
            
            // Set nama anggota di judul modal
            $('#dendaNamaAnggota').text(namaAnggota);

            // Tampilkan modal
            const dendaModal = new bootstrap.Modal(document.getElementById('dendaModal'));
            dendaModal.show();
        });

        // 3. Event listener untuk tombol Hapus Denda
        $('#pinjamanTable tbody').on('click', '.btn-delete-denda', function() {
            const pinjamanId = $(this).data('id');
            const namaAnggota = $(this).data('nama');
            const jumlahDenda = $(this).data('denda');
            
            // Format denda ke format Rupiah
            const formattedDenda = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(jumlahDenda);

            // Set URL action form
            const url = `/admin/pinjaman/delete-denda/${pinjamanId}`;
            $('#hapusDendaForm').attr('action', url);
            
            // Set data di dalam modal
            $('#hapusDendaNamaAnggota').text(namaAnggota);
            $('#jumlahDendaSaatIni').text(formattedDenda);

            // Tampilkan modal
            const hapusDendaModal = new bootstrap.Modal(document.getElementById('hapusDendaModal'));
            hapusDendaModal.show();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sistemkoperasinew\resources\views/admin/pinjaman/index.blade.php ENDPATH**/ ?>