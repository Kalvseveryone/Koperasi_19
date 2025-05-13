<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <title>Daftar Pinjaman | Adakita Koperasi</title>

    <!-- Bootstrap & DataTables CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(120deg, #f0f4f7, #d9e2ec);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2e3a59;
            color: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
        }

        .sidebar img {
            max-height: 60px;
            margin-bottom: 20px;
        }

        .sidebar h6 {
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 10px 0;
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

        .sidebar .btn-logout {
            margin-top: 30px;
        }

        .content {
            margin-left: 270px;
            padding: 40px 20px;
            flex-grow: 1;
            transition: margin-left 0.3s ease-in-out;
        }

        .container-custom {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        table.dataTable thead {
            background-color: #1e3a8a;
            color: white;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border-radius: 8px;
            padding: 6px 10px;
            border: 1px solid #ccc;
        }

        .hamburger {
            display: none;
            background-color: #2e3a59;
            color: white;
            border: none;
            font-size: 24px;
            padding: 10px 20px;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }

            .hamburger {
                display: block;
            }

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <!-- Toggle Button -->
    <button class="hamburger" onclick="toggleSidebar()">☰</button>

    <div class="wrapper">
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
            <a href="{{ route('admin.anggota') }}"
                class="{{ request()->routeIs('admin.anggota') ? 'active-menu' : '' }}">
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
            <a href="{{ route('admin.laporan') }}"
                class="{{ request()->routeIs('admin.laporan') ? 'active-menu' : '' }}">
                📊 Lihat Laporan Keuangan
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger w-100 mt-4">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>

        </div>

        <div class="content">
            <div class="container-custom">
                <h1>Daftar Pinjaman</h1>

                <div class="table-responsive">
                    <table id="pinjamanTable" class="table table-striped table-bordered display nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Anggota ID</th>
                                <th>Jumlah Pinjaman</th>
                                <th>Status</th>
                                <th>Tanggal Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pinjaman as $p)
                                <tr>
                                    <td>{{ $p->id }}</td>
                                    <td>{{ $p->anggota_id }}</td>
                                    <td>Rp {{ number_format($p->jumlah_pinjaman, 2, ',', '.') }}</td>
                                    <td>{{ $p->status }}</td>
                                    <td>{{ $p->tanggal_pinjam }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pinjamanTable').DataTable({
                responsive: true
            });
        });

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Optional: close sidebar if clicking outside (mobile only)
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('sidebar');
            const button = document.querySelector('.hamburger');
            if (!sidebar.contains(e.target) && !button.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>

</html>