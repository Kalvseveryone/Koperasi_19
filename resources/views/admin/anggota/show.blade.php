<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Detail Anggota | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #eef2f3, #d9e2ec);
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            border: none;
            background-color: #fff;
        }
        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px;
        }
        .list-group-item {
            border: none;
            font-size: 1rem;
        }
        .list-group-item strong {
            display: inline-block;
            width: 150px;
            color: #333;
        }
        .btn {
            border-radius: 30px;
            font-weight: 500;
        }
        .btn i {
            margin-right: 5px;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
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

    <!-- Main content -->
    <div class="container">
        <div class="card shadow rounded-4">
            <div class="card-header d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x me-3"></i>
                <h3 class="mb-0">Detail Anggota</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item"><strong>ID:</strong> {{ $anggota->id }}</li>
                    <li class="list-group-item"><strong>Nama:</strong> {{ $anggota->nama }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $anggota->email }}</li>
                    <li class="list-group-item"><strong>Alamat:</strong> {{ $anggota->alamat }}</li>
                    <li class="list-group-item"><strong>Saldo Simpanan:</strong> Rp{{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</li>
                </ul>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>

                    <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('admin.anggota') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Anggota
            </a>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>
