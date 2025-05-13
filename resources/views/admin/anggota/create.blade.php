<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Tambah Anggota | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(to bottom right, #e3f2fd, #ffffff);
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
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: #ffffff;
        }

        h1 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control {
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .header-icon {
            font-size: 40px;
            color: #0d6efd;
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

    <br>
    <br>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center">
            <img src="{{ asset('img/images/logoadakita.png') }}" alt="Logo" class="img-fluid mb-2">
            <h6>Adakita Koperasi</h6>
        </div>
        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
            <i class="fas fa-home me-2"></i> Dashboard
        </a>
        <a href="{{ route('admin.anggota') }}" class="{{ request()->routeIs('admin.anggota') ? 'active-menu' : '' }}">
            <i class="fas fa-users me-2"></i> Kelola Anggota
        </a>
        <a href="{{ route('admin.pinjaman') }}" class="{{ request()->routeIs('admin.pinjaman') ? 'active-menu' : '' }}">
            <i class="fas fa-hand-holding-usd me-2"></i> Kelola Pinjaman
        </a>
        <a href="{{ route('admin.kolektor') }}" class="{{ request()->routeIs('admin.kolektor') ? 'active-menu' : '' }}">
            <i class="fas fa-truck me-2"></i> Kelola Kolektor
        </a>
        <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active-menu' : '' }}">
            <i class="fas fa-chart-line me-2"></i> Laporan Keuangan
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100 mt-4">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
    <div class="container">
        <div class="card text-center">
            <div class="header-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h1>Tambah Anggota Baru</h1>

            <form action="{{ route('admin.anggota.store') }}" method="POST" class="text-start">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="saldo_simpanan" class="form-label">Saldo Simpanan</label>
                    <input type="number" name="saldo_simpanan" class="form-control" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Tambah Anggota</button>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.anggota') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Anggota
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS + Icons -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</body>

</html>