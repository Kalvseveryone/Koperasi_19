<!-- resources/views/admin/laporan/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
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
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="fw-bold text-primary">📊 Laporan Keuangan</h1>
            <p class="text-muted">Ringkasan data keuangan koperasi Anda secara menyeluruh</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <div class="card-icon text-success"><i class="bi bi-piggy-bank"></i></div>
                        <h5 class="card-title text-success">Total Simpanan</h5>
                        <p class="fs-4 fw-bold">Rp{{ number_format($laporan['total_simpanan'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <div class="card-icon text-danger"><i class="bi bi-cash-stack"></i></div>
                        <h5 class="card-title text-danger">Total Pinjaman</h5>
                        <p class="fs-4 fw-bold">Rp{{ number_format($laporan['total_pinjaman'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <div class="card-icon text-primary"><i class="bi bi-person-badge-fill"></i></div>
                        <h5 class="card-title text-primary">Total Kolektor</h5>
                        <p class="fs-4 fw-bold">{{ $laporan['total_kolektor'] }} orang</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <div class="card-icon text-warning"><i class="bi bi-bar-chart-fill"></i></div>
                        <h5 class="card-title text-warning">Total Transaksi</h5>
                        <p class="fs-4 fw-bold">{{ $laporan['total_transaksi'] }} transaksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <div class="card-icon text-secondary"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <h5 class="card-title text-secondary">Total Denda</h5>
                        <p class="fs-4 fw-bold">Rp{{ number_format($laporan['total_denda'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <form action="{{ route('admin.laporan.export') }}" method="GET">
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 shadow-lg">
                    <i class="bi bi-download me-2"></i>Ekspor Laporan
                </button>
            </form>
        </div>
    </div>

    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
