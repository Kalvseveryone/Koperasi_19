<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/images/logoadakita.png')); ?>">
    <title>Laporan Keuangan | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
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
            z-index: 1000;
            transition: left 0.3s ease;
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
        .sidebar a.active-menu {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-left: 4px solid white;
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

        main {
            margin-left: 250px;
            padding: 40px 20px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
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

            main {
                margin-left: 0;
                padding-top: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- Toggle Button -->
    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="<?php echo e(asset('img/images/logoadakita.png')); ?>" alt="Logo" class="img-fluid" style="width: 120px;">
            <h6 class="mt-2 text-white">Adakita Koperasi</h6>
        </div>

        <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active-menu' : ''); ?>">
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
    <main>
        <div class="container-fluid">

            <div class="text-center mb-5" data-aos="fade-down">
                <h1 class="fw-bold text-primary">📊 Laporan Keuangan</h1>
                <p class="text-muted">Ringkasan data keuangan koperasi Anda secara menyeluruh</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <div class="card-icon text-success"><i class="bi bi-piggy-bank"></i></div>
                            <h5 class="card-title">Total Simpanan</h5>
                            <p class="fs-4 fw-bold">Rp<?php echo e(number_format($laporan['total_simpanan'], 0, ',', '.')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <div class="card-icon text-danger"><i class="bi bi-cash-stack"></i></div>
                            <h5 class="card-title">Total Pinjaman</h5>
                            <p class="fs-4 fw-bold">Rp<?php echo e(number_format($laporan['total_pinjaman'], 0, ',', '.')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <div class="card-icon text-info"><i class="bi bi-person-badge-fill"></i></div>
                            <h5 class="card-title">Total Kolektor</h5>
                            <p class="fs-4 fw-bold"><?php echo e($laporan['total_kolektor']); ?> orang</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <div class="card-icon text-warning"><i class="bi bi-bar-chart-fill"></i></div>
                            <h5 class="card-title">Total Transaksi</h5>
                            <p class="fs-4 fw-bold"><?php echo e($laporan['total_transaksi']); ?> transaksi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <div class="card-icon text-secondary"><i class="bi bi-exclamation-triangle-fill"></i></div>
                            <h5 class="card-title">Total Denda</h5>
                            <p class="fs-4 fw-bold">Rp<?php echo e(number_format($laporan['total_denda'], 0, ',', '.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <form action="<?php echo e(route('admin.laporan.export')); ?>" method="GET">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 shadow-lg">
                        <i class="bi bi-download me-2"></i>Ekspor Laporan
                    </button>
                </form>
            </div>

        </div>
    </main>

    <!-- AOS & Toggle Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

</body>
</html>
<?php /**PATH C:\laragon\www\sistemkoperasi\resources\views/admin/laporan/index.blade.php ENDPATH**/ ?>