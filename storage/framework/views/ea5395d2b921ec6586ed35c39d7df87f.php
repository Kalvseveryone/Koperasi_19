<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/images/logoadakita.png')); ?>">
    <title>Daftar Kolektor | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f1f1f1);
        }

        h1 {
            font-weight: 600;
            font-size: 2.5rem;
            letter-spacing: 1px;
            color: #2e3a59;
            margin-bottom: 30px;
        }

        .container {
            max-width: 1000px;
            margin-top: 50px;
            transition: margin-left 0.3s ease;
        }

        .table {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table th {
            background-color: #2e3a59;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 10px;
            padding: 5px 10px;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Sidebar */
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
            z-index: 1050;
            transition: transform 0.3s ease;
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
            background-color: #2e3a59;
            font-weight: bold;
        }

        .sidebar a.active-menu {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-left: 4px solid white;
        }

        /* Toggle button */
        .toggle-sidebar {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1100;
            background-color: #2e3a59;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
        }

        /* Responsive behavior */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .container {
                margin-left: 0 !important;
                padding-top: 80px;
            }

            .toggle-sidebar {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .container {
                margin-left: 270px;
            }

            .toggle-sidebar {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Toggle Sidebar Button -->
    <button class="btn toggle-sidebar" onclick="toggleSidebar()">☰</button>

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

    <!-- Main Content -->
    <div class="container">
        <h1 class="text-center">Daftar Kolektor</h1>

        <!-- Button to add new Kolektor -->
        <div class="mb-3 text-end">
            <a href="<?php echo e(route('admin.kolektor.create')); ?>" class="btn btn-primary">Tambah Kolektor</a>
        </div>

        <!-- Table -->
        <table id="kolektorTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $kolektors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($k->id); ?></td>
                        <td><?php echo e($k->nama); ?></td>
                        <td><?php echo e($k->anggota->nama); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.kolektor.show', $k->id)); ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="<?php echo e(route('admin.kolektor.edit', $k->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?php echo e(route('admin.kolektor.destroy', $k->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#kolektorTable').DataTable();
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/kolektor/index.blade.php ENDPATH**/ ?>