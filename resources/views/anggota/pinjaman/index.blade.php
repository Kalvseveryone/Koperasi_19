@extends('layouts.app')

@section('title', 'Daftar Pinjaman - KitaAda Koperasi')

@section('content')
<script>
function showDetailModal(nama, jumlah, denda, jangka, tujuan) {
    document.getElementById('detail-nama').textContent = nama;
    document.getElementById('detail-jumlah').textContent = 'Rp ' + jumlah;
    document.getElementById('detail-denda').textContent = 'Rp ' + denda;
    document.getElementById('detail-jangka').textContent = jangka + ' bulan';
    document.getElementById('detail-tujuan').textContent = tujuan;
    var modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}
</script>
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Daftar Pinjaman</h2>
                <div>
                    <a href="{{ route('anggota.dashboard') }}" class="btn btn-secondary me-2">Kembali</a>
                    <a href="{{ route('anggota.pinjaman.create') }}" class="btn btn-primary">Ajukan Pinjaman</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jumlah</th>
                                    <th>Denda</th>
                                    <th>Jangka Waktu</th>
                                    <th>Status</th>
                                    <th>Tujuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pinjaman as $p)
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($p->denda, 0, ',', '.') }}</td>
                                        <td>{{ $p->jangka_waktu }} bulan</td>
                                        <td>
                                            @if($p->status == 'ditolak')
                                                <div class="d-flex flex-column gap-1">
                                                    <span class="badge bg-danger">Ditolak</span>
                                                    <small class="text-danger" style="font-size: 11px; line-height: 1.2;">
                                                        {{ $p->catatan }}
                                                    </small>
                                                </div>
                                            @else
                                                <span class="badge bg-{{ $p->status == 'pending' ? 'warning' : ($p->status == 'aktif' ? 'success' : 'info') }}">
                                                    {{ ucfirst($p->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $p->tujuan }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="showDetailModal('{{ $p->anggota->nama }}', '{{ number_format($p->jumlah, 0, ',', '.') }}', '{{ number_format($p->denda, 0, ',', '.') }}', '{{ $p->jangka_waktu }}', '{{ $p->tujuan }}')">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pinjaman</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $pinjaman->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pinjaman -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pinjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-bold">Nama:</label>
                        <div id="detail-nama"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Jumlah Pinjaman:</label>
                        <div id="detail-jumlah"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Denda:</label>
                        <div id="detail-denda"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Jangka Waktu:</label>
                        <div id="detail-jangka"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Tujuan:</label>
                        <div id="detail-tujuan"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
