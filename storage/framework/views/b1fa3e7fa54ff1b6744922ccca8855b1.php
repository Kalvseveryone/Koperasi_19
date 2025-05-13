<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kolektor | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #dff6f0, #eaf4fc);
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            animation: fadeInUp 0.5s ease;
        }

        h1 {
            text-align: center;
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px 15px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
        }

        .input-group-text {
            background-color: #f0f2f5;
            border-radius: 12px 0 0 12px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0b5ed7, #0aa2c0);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            transition: left 0.3s ease;
            z-index: 1000;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 12px 0;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active-menu {
            background-color: #1b263b;
        }

        .sidebar img {
            max-height: 60px;
            margin-bottom: 20px;
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            font-size: 24px;
            background: #2e3a59;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            padding-left: 0;
        }

        @media (min-width: 769px) {
            .center-wrapper {
                margin-left: 250px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .center-wrapper {
                margin-left: 0;
                padding-top: 80px;
            }
        }
    </style>
</head>

<body>

    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

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

    <!-- Centered Form -->
    <div class="center-wrapper">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card w-100" style="max-width: 600px;">
                <h1>Edit Kolektor</h1>

                <form action="<?php echo e(route('admin.kolektor.update', $kolektor->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama" class="form-label">Nama Kolektor</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="<?php echo e($kolektor->nama); ?>" required>
                        </div>
                    </div>

                    <!-- Anggota -->
                    <div class="mb-4">
                        <label for="anggota_id" class="form-label">Pilih Anggota</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                            <select name="anggota_id" id="anggota_id" class="form-control" required>
                                <?php $__currentLoopData = $anggotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($anggota->id); ?>"
                                        <?php echo e($anggota->id == $kolektor->anggota_id ? 'selected' : ''); ?>>
                                        <?php echo e($anggota->nama); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="<?php echo e(route('admin.kolektor')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kolektor
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>

</html>
<?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/kolektor/edit.blade.php ENDPATH**/ ?>