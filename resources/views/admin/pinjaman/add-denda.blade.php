@extends('layouts.app')

@section('title', 'Tambah Denda - KitaAda Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Denda untuk {{ $pinjaman->anggota->nama }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.pinjaman.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informasi Pinjaman</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td width="150">Nama Anggota</td>
                                    <td>: {{ $pinjaman->anggota->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Pinjaman</td>
                                    <td>: Rp {{ number_format($pinjaman->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Denda Saat Ini</td>
                                    <td>: Rp {{ number_format($pinjaman->denda, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>: <span class="badge bg-primary">{{ ucfirst($pinjaman->status) }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.pinjaman.add-denda', $pinjaman->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="denda" class="form-label">Jumlah Denda</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('denda') is-invalid @enderror" 
                                               id="denda" 
                                               name="denda" 
                                               value="{{ old('denda') }}"
                                               min="0"
                                               step="1000"
                                               required>
                                    </div>
                                    @error('denda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan (Alasan Denda)</label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                              id="keterangan" 
                                              name="keterangan" 
                                              rows="3" 
                                              required>{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-plus"></i> Tambah Denda
                                    </button>
                                    <a href="{{ route('admin.pinjaman.index') }}" class="btn btn-secondary">
                                        Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 