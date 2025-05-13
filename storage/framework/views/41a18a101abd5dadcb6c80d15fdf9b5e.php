<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fff3e0);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }


        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 25px;
        }

        .card-header h2 {
            margin: 0;
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
        }

        label {
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0056b3, #0090d1);
        }

        .btn-secondary {
            border-radius: 50px;
            font-weight: 600;
        }

        .text-center {
            margin-top: 30px;
        }

        .fa-arrow-left {
            margin-right: 8px;
        }

        .form-icon {
            margin-right: 8px;
            color: #007bff;
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

            .container {
                margin-left: 0 !important;
                padding-top: 80px;
            }
        }

        .container {
            margin-left: 270px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-body {
            animation: fadeInUp 0.5s ease;
        }
    </style>
</head>

<body>

    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center">
            <img src="<?php echo e(asset('img/images/logoadakita.png')); ?>" alt="Logo" class="img-fluid mb-2">
            <h6>Adakita Koperasi</h6>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active-menu' : ''); ?>">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.anggota')); ?>" class="<?php echo e(request()->routeIs('admin.anggota') ? 'active-menu' : ''); ?>">
            <i class="fas fa-users me-2"></i> Kelola Anggota
        </a>
        <a href="<?php echo e(route('admin.pinjaman')); ?>" class="<?php echo e(request()->routeIs('admin.pinjaman') ? 'active-menu' : ''); ?>">
            <i class="fas fa-hand-holding-usd me-2"></i> Kelola Pinjaman
        </a>
        <a href="<?php echo e(route('admin.kolektor')); ?>" class="<?php echo e(request()->routeIs('admin.kolektor') ? 'active-menu' : ''); ?>">
            <i class="fas fa-truck me-2"></i> Kelola Kolektor
        </a>
        <a href="<?php echo e(route('admin.laporan')); ?>" class="<?php echo e(request()->routeIs('admin.laporan') ? 'active-menu' : ''); ?>">
            <i class="fas fa-chart-line me-2"></i> Laporan Keuangan
        </a>
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger w-100 mt-4">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2><i class="fas fa-user-edit me-2"></i>Edit Data Anggota</h2>
            </div>
            <div class="card-body px-4 py-4">
                <form action="<?php echo e(route('admin.anggota.update', $anggota->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="nama" class="form-label"><i class="fas fa-user form-icon"></i>Nama:</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo e($anggota->nama); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="fas fa-envelope form-icon"></i>Email:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo e($anggota->email); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="fas fa-lock form-icon"></i>Password:</label>
                        <input type="password" name="password" id="password" class="form-control" value=""
                            placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label"><i
                                class="fas fa-map-marker-alt form-icon"></i>Alamat:</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo e($anggota->alamat); ?>"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="saldo_simpanan" class="form-label"><i class="fas fa-wallet form-icon"></i>Saldo
                            Simpanan:</label>
                        <input type="number" name="saldo_simpanan" id="saldo_simpanan" class="form-control"
                            value="<?php echo e($anggota->saldo_simpanan); ?>" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('admin.anggota')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Anggota
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>

</html><?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/anggota/edit.blade.php ENDPATH**/ ?>