<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/images/logoadakita.png')); ?>">
    <title>Dashboard Admin | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #ffffff);
            color: #333;
        }

        h1 {
            color: #2a7a7e;
            font-weight: 700;
            margin: 30px 0;
        }

        .card {
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2a7a7e;
        }

        .card-text {
            font-size: 1.8rem;
            font-weight: bold;
            color: #007bff;
        }

        .btn-primary {
            background-color: #2a7a7e;
            border-color: #2a7a7e;
            border-radius: 25px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
            transform: scale(1.05);
        }

        .container-fluid {
            padding-left: 270px;
            transition: padding-left 0.3s ease;
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
            box-shadow: 2px 0 12px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 12px 0;
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #1b263b;
            padding-left: 20px;
        }

        .sidebar a.active-menu {
            background-color: #007bff;
            font-weight: bold;
        }

        .sidebar img {
            max-height: 80px;
            margin-bottom: 20px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1049;
        }

        .overlay.show {
            display: block;
        }

        .toggle-btn {
            background-color: #2e3a59;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            margin: 20px;
            z-index: 1060;
            position: fixed;
            top: 10px;
            left: 10px;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .container-fluid {
                padding-left: 0 !important;
                padding-top: 100px;
            }

            .content h1 {
                padding: 0 15px;
                z-index: 1;
                position: relative;
                text-align: center;
            }

            .toggle-btn {
                display: block;
            }

            .overlay.show {
                display: block;
            }
        }

        @media (min-width: 768px) {
            .toggle-btn {
                display: none;
            }

            .overlay {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    

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

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Toggle Button for Mobile Sidebar -->
    <button class="toggle-btn" onclick="toggleSidebar()">&#9776;</button>

    <div class="content container-fluid">
        <h1 class="text-center">Dashboard Admin</h1>

        <div class="row px-3">
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Anggota</h5>
                        <p class="card-text"><?php echo e($totalAnggota); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Pinjaman</h5>
                        <p class="card-text"><?php echo e($totalPinjaman); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Simpanan</h5>
                        <p class="card-text"><?php echo e($totalSimpanan); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Transaksi</h5>
                        <p class="card-text"><?php echo e($totalTransaksi); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('overlay').classList.toggle('show');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>