<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Tambah Kolektor | Adakita Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #dfe9f3, #ffffff);
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 35px 40px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #0dcaf0;
            box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            background: linear-gradient(to right, #0d6efd, #0dcaf0);
            border: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0b5ed7, #0aa2c0);
        }

        @keyframes fadeIn {
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
            margin-left: 250px;
            padding: 20px;
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
        <a href="{{ route('admin.pinjaman') }}" class="{{ request()->routeIs('admin.pinjaman') ? 'active-menu' : '' }}">
            💰 Kelola Pinjaman
        </a>
        <a href="{{ route('admin.kolektor') }}" class="{{ request()->routeIs('admin.kolektor') ? 'active-menu' : '' }}">
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
    <div class="center-wrapper">
        <div class="form-container">
            <h1>Tambah Kolektor</h1>

            <form action="{{ route('admin.kolektor.store') }}" method="POST">
                @csrf

                <!-- Input Nama -->
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Kolektor</label>
                    <input type="text" id="nama" name="nama" class="form-control" required
                        placeholder="Masukkan nama kolektor">
                </div>

                <!-- Pilih Anggota -->
                <div class="mb-4">
                    <label for="anggota_id" class="form-label">Pilih Anggota</label>
                    <select name="anggota_id" id="anggota_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Anggota --</option>
                        @foreach ($anggotas as $anggota)
                            <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Kolektor
                </button>

                <div class="mt-4 text-center">
                    <a href="{{ route('admin.kolektor') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kolektor
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

</body>

</html>
