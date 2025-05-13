<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/images/logoadakita.png')); ?>">
    <title>Daftar Anggota | Adakita Koperasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f1f1f1);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #2e3a59;
            padding: 30px 20px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: left 0.3s ease;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #1b263b;
            padding-left: 20px;
        }

        .sidebar img {
            max-height: 60px;
            margin-bottom: 30px;
        }

        .sidebar a.active-menu {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-left: 4px solid white;
        }

        .content {
            margin-left: 270px;
            padding: 40px;
            transition: margin-left 0.3s ease;
        }

        h1 {
            font-weight: 600;
            color: #2e3a59;
            margin-bottom: 30px;
        }

        .btn {
            border-radius: 10px;
        }

        .btn-sm {
            border-radius: 8px;
            padding: 5px 12px;
        }

        .table th {
            background-color: #2e3a59;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .container-box {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .logout-btn {
            margin-top: 40px;
        }

        .logout-btn button {
            width: 100%;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            font-size: 28px;
            background: #2e3a59;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0 !important;
                padding: 20px;
            }

            .sidebar-toggle {
                display: block;
            }

            .top-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol toggle sidebar -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>
    <br>
    <br>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="<?php echo e(asset('img/images/logoadakita.png')); ?>" alt="Logo" class="img-fluid">
            <h6 class="mt-2 text-white">Adakita Koperasi</h6>
        </div>

        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active-menu' : ''); ?>">
            🏠 Dashboard
        </a>
        <a href="<?php echo e(route('admin.anggota')); ?>" class="<?php echo e(request()->routeIs('admin.anggota') ? 'active-menu' : ''); ?>">
            👥 Kelola Anggota
        </a>
        <a href="<?php echo e(route('admin.pinjaman')); ?>" class="<?php echo e(request()->routeIs('admin.pinjaman') ? 'active-menu' : ''); ?>">
            💰 Kelola Pinjaman
        </a>
        <a href="<?php echo e(route('admin.kolektor')); ?>" class="<?php echo e(request()->routeIs('admin.kolektor') ? 'active-menu' : ''); ?>">
            🚚 Kelola Kolektor
        </a>
        <a href="<?php echo e(route('admin.laporan')); ?>" class="<?php echo e(request()->routeIs('admin.laporan') ? 'active-menu' : ''); ?>">
            📊 Lihat Laporan Keuangan
        </a>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger w-100 mt-4">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>

    </div>

    <!-- Konten -->
    <div class="content">
        <div class="container-box">
            <h1 class="text-center">📋 Daftar Anggota</h1>

            <div class="top-actions">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Dashboard
                </a>
                <a href="<?php echo e(route('admin.anggota.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Anggota
                </a>
            </div>

            <div class="table-responsive">
                <table id="anggotaTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Saldo Simpanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $anggotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($a->nama); ?></td>
                                <td><?php echo e($a->email); ?></td>
                                <td>Rp <?php echo e(number_format($a->saldo_simpanan, 2, ',', '.')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.anggota.show', $a->id)); ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="<?php echo e(route('admin.anggota.edit', $a->id)); ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.anggota.destroy', $a->id)); ?>" method="POST"
                                        class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#anggotaTable').DataTable({
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "→",
                        previous: "←"
                    }
                }
            });
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>

</html><?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/anggota/anggota.blade.php ENDPATH**/ ?>