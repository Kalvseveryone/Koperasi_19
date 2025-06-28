@extends('layouts.app')

@section('title', 'Ajukan Pinjaman - KitaAda Koperasi')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Ajukan Pinjaman</h2>
                <a href="{{ route('anggota.pinjaman.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('anggota.pinjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="jumlah" class="form-label">Jumlah Pinjaman</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" 
                                       name="jumlah" 
                                       value="{{ old('jumlah') }}"
                                       min="100000"
                                       required>
                            </div>
                            <small class="text-muted">Minimal Rp 100.000</small>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jangka_waktu" class="form-label">Jangka Waktu (Bulan)</label>
                            <select class="form-select @error('jangka_waktu') is-invalid @enderror" 
                                    id="jangka_waktu" 
                                    name="jangka_waktu" 
                                    required>
                                <option value="">Pilih jangka waktu</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('jangka_waktu') == $i ? 'selected' : '' }}>
                                        {{ $i }} bulan
                                    </option>
                                @endfor
                            </select>
                            @error('jangka_waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tujuan" class="form-label">Tujuan Pinjaman</label>
                            <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                                      id="tujuan" 
                                      name="tujuan" 
                                      rows="3" 
                                      required>{{ old('tujuan') }}</textarea>
                            <small class="text-muted">Jelaskan tujuan penggunaan dana pinjaman</small>
                            @error('tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Pinjaman</h5>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <strong>Syarat Pinjaman:</strong>
                            <ul class="mt-2">
                                <li>Minimal pinjaman Rp 100.000</li>
                                <li>Maksimal jangka waktu 12 bulan</li>
                                <li>Harus memiliki simpanan aktif</li>
                            </ul>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <strong>Proses Persetujuan:</strong>
                            <p class="mt-2 mb-0">
                                Pengajuan pinjaman akan diproses dalam waktu 1-3 hari kerja.
                                Anda akan mendapat notifikasi setelah pinjaman disetujui.
                            </p>
                        </li>
                        <li>
                            <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                            <strong>Penting:</strong>
                            <p class="mt-2 mb-0">
                                Pastikan data yang diisi benar dan sesuai dengan kebutuhan Anda.
                                Pengajuan tidak dapat dibatalkan setelah disetujui.
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
