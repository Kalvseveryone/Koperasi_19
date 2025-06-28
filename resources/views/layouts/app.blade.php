<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title') - Kitaada</title>

    <link rel="icon" type="image/png" href="{{ asset('img/images/logoadakita.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; min-height: 100vh; }
        .sidebar {
            background-color: #2a7a7e; min-height: 100vh; width: 250px;
            position: fixed; left: 0; top: 0; z-index: 100; padding: 20px 0;
            transition: left 0.3s ease-in-out;
        }
        .sidebar.collapsed { left: -250px; }
        .sidebar img { max-width: 80px; margin-bottom: 10px; }
        .sidebar a {
            display: block; color: white; text-decoration: none;
            padding: 15px 20px; transition: background-color 0.3s; font-size: 16px;
        }
        .sidebar a:hover, .sidebar a.active-menu { background-color: rgba(255, 255, 255, 0.1); }
        .toggle-sidebar {
            position: fixed; left: 20px; top: 20px; z-index: 101;
            background: #2a7a7e; color: white; border: none;
            padding: 10px 15px; display: none; border-radius: 4px;
        }
        .close-sidebar {
            position: absolute; top: 10px; right: 15px; background: none;
            border: none; color: white; font-size: 28px; line-height: 1;
            padding: 0 5px; cursor: pointer;
            display: none; /* Sembunyikan secara default untuk desktop */
        }
        .main-content {
            margin-left: 250px; padding: 20px;
            transition: margin-left 0.3s ease-in-out;
            min-height: 100vh; position: relative; z-index: 1;
        }
        .main-content.expanded { margin-left: 0; }
        .card {
            border: none; border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .modal-open { overflow: hidden; padding-right: 0 !important; }
        .modal { background: rgba(0, 0, 0, 0.3); }
        .modal-backdrop { display: none; }
        .modal-dialog { margin: 1.75rem auto; max-width: 500px; }
        .modal-content { border: none; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
        .card-header { background-color: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
        .btn-primary { background-color: #2a7a7e; border-color: #2a7a7e; }
        .btn-primary:hover { background-color: #236366; border-color: #236366; }
        .header {
            background: white; padding: 1rem; margin: -20px -20px 20px -20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .header h4 { color: #2a7a7e; font-weight: 600; }
        .user-info {
            display: flex; align-items: center; padding: 0.5rem 1rem;
            background: #f8f9fa; border-radius: 50px;
        }
        .user-info span { color: #2a7a7e; }
        .user-info .badge {
            background-color: #2a7a7e !important; font-weight: normal;
        }
        
        /* Styles untuk mobile */
        @media (max-width: 768px) {
            .main-content { margin-left: 0; width: 100%; padding-top: 80px; }
            .main-content.expanded { margin-left: 0; }
            .sidebar { z-index: 1000; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
            .sidebar.collapsed { left: -250px; }
            .toggle-sidebar { display: block; position: fixed; top: 15px; left: 15px; z-index: 1001; }
            
            .close-sidebar {
                display: block; /* Tampilkan kembali tombol close di mobile */
            }
            .sidebar.collapsed .close-sidebar { display: none; }
        }
    </style>
</head>
<body>
    <button class="btn toggle-sidebar" onclick="toggleSidebar()">☰</button>

    <div class="sidebar" id="sidebar">
        <button class="close-sidebar" onclick="toggleSidebar()" aria-label="Close sidebar">&times;</button>
        <div class="text-center mb-4">
            <img src="{{ asset('img/images/logoadakita.png') }}" alt="Logo" class="img-fluid">
            <h6 class="mt-2 text-white">Kitaada Koperasi</h6>
        </div>

        @if(auth()->guard('kolektor')->check())
            <a href="{{ route('kolektor.dashboard') }}" class="{{ request()->routeIs('kolektor.dashboard') ? 'active-menu' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('kolektor.anggota-binaan') }}" class="{{ request()->routeIs('kolektor.anggota-binaan*') ? 'active-menu' : '' }}">👥 Anggota Binaan</a>
        @elseif(auth()->guard('anggota')->check())
            <a href="{{ route('anggota.dashboard') }}" class="{{ request()->routeIs('anggota.dashboard') ? 'active-menu' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('anggota.saldo') }}" class="{{ request()->routeIs('anggota.saldo') ? 'active-menu' : '' }}">💰 Saldo Simpanan</a>
            <a href="{{ route('anggota.pinjaman.index') }}" class="{{ request()->routeIs('anggota.pinjaman.*') ? 'active-menu' : '' }}">💳 Pinjaman</a>
            <a href="{{ route('anggota.history') }}" class="{{ request()->routeIs('anggota.history') ? 'active-menu' : '' }}">📋 Riwayat Transaksi</a>
        @elseif(auth()->check())
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.anggota') }}" class="{{ request()->routeIs('admin.anggota*') ? 'active-menu' : '' }}">👥 Anggota</a>
            <a href="{{ route('admin.kolektor') }}" class="{{ request()->routeIs('admin.kolektor*') ? 'active-menu' : '' }}">👨‍💼 Kolektor</a>
            <a href="{{ route('admin.payments.pending') }}" class="{{ request()->routeIs('admin.payments*') ? 'active-menu' : '' }}">💰 Pembayaran</a>
            <a href="{{ route('admin.pinjaman.index') }}" class="{{ request()->routeIs('admin.pinjaman*') ? 'active-menu' : '' }}">💳 Pinjaman</a>
            <a href="{{ route('admin.simpanan.index') }}" class="{{ request()->routeIs('admin.simpanan*') ? 'active-menu' : '' }}">💵 Simpanan</a>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan*') ? 'active-menu' : '' }}">📊 Laporan</a>
        @endif

        @if(auth()->guard('kolektor')->check() || auth()->check() || auth()->guard('anggota')->check())
            <form method="POST" action="{{ route('logout') }}" class="mt-auto mb-3 px-3">
                @csrf
                <button type="submit" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        @endif
    </div>

    <div class="main-content" id="main-content">
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                {{-- <h4 class="mb-0">@yield('title')</h4> --}}
                <div></div> {{-- Kosongkan bagian kiri agar layout tetap seimbang --}}
                @if(auth()->guard('kolektor')->check() || auth()->check() || auth()->guard('anggota')->check())
                    <div class="user-info d-flex align-items-center">
                        <span class="me-2">
                            @if(auth()->guard('kolektor')->check()) {{ auth()->guard('kolektor')->user()->nama }}
                            @elseif(auth()->guard('anggota')->check()) {{ auth()->guard('anggota')->user()->nama }}
                            @else {{ auth()->user()->name }}
                            @endif
                        </span>
                        <span class="badge bg-primary">
                            @if(auth()->guard('kolektor')->check()) Kolektor
                            @elseif(auth()->guard('anggota')->check()) Anggota
                            @else Admin
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Main Content --}}
        @yield('content')
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('main-content').classList.toggle('expanded');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            if (window.innerWidth <= 768) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
            mainContent.addEventListener('click', function() {
                if (window.innerWidth <= 768 && !sidebar.classList.contains('collapsed')) {
                    toggleSidebar();
                }
            });
        });
    </script>

    @stack('scripts')

    @if(session('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif
    @if(session('error'))
        <script>
            Swal.fire({ icon: 'error', title: 'Error!', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
        </script>
    @endif
</body>
</html>