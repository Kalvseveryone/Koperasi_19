@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Anggota</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.anggota') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <p>{{ $anggota->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <p>{{ $anggota->nik }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">No. Telepon</label>
                                <p>{{ $anggota->no_telepon }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <p>{{ $anggota->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat</label>
                                <p>{{ $anggota->alamat }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Saldo Simpanan</label>
                                <p>Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <p>
                                    <span class="badge bg-{{ $anggota->status === 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($anggota->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn btn-warning text-white me-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
