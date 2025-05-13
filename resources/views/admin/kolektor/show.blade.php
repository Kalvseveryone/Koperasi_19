<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Kartu Nama Kolektor | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f2f4f6;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-table {
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 600px;
            animation: fadeInUp 0.5s ease;
        }

        .card-table h2 {
            text-align: center;
            color: #2a7a7e;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .table td {
            padding: 12px 10px;
            vertical-align: middle;
            font-size: 1.05rem;
            color: #343a40;
        }

        .table td.label {
            font-weight: 600;
            width: 40%;
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .btn-edit {
            display: block;
            width: fit-content;
            margin: 0 auto;
            padding: 8px 20px;
            font-size: 0.95rem;
            border-radius: 8px;
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

        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    </style>
</head>

<body>

    <button class="sidebar-toggle" onclick="toggleSidebar()">☰</button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset('img/images/logoadakita.png') }}" alt="Logo" class="img-fluid">
            <h6 class="mt-2 text-white">Adakita Koperasi</h6>
        </div>

        <a href="{{ route('admin.dashboard') }}"
            class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
            🏠 Dashboard
        </a>
        <a href="{{ route('admin.anggota') }}" class="{{ request()->routeIs('admin.anggota') ? 'active-menu' : '' }}">
            👥 Kelola Anggota
        </a>
        <a href="{{ route('admin.pinjaman') }}"
            class="{{ request()->routeIs('admin.pinjaman') ? 'active-menu' : '' }}">
            💰 Kelola Pinjaman
        </a>
        <a href="{{ route('admin.kolektor') }}"
            class="{{ request()->routeIs('admin.kolektor') ? 'active-menu' : '' }}">
            🚚 Kelola Kolektor
        </a>
        <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active-menu' : '' }}">
            📊 Lihat Laporan Keuangan
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger w-100 mt-4">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <!-- Konten Tengah -->
    <div class="container">
        <div class="center-wrapper">
            <div class="card-table">
                <h2>Detail Kolektor</h2>
                <table class="table table-bordered">
                    <tr>
                        <td class="label">Nama Kolektor</td>
                        <td>{{ $kolektor->nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Anggota</td>
                        <td>{{ $kolektor->anggota->nama }}</td>
                    </tr>
                </table>

                <a href="{{ route('admin.kolektor.edit', $kolektor->id) }}" class="btn btn-primary btn-edit">
                    Edit Kolektor
                </a>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.kolektor') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kolektor
                    </a>
                </div>
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
