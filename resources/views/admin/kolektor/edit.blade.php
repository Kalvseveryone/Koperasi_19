@extends('layouts.app')
@section('title', 'Edit Kolektor')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Kolektor</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.kolektor') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <form action="{{ route('admin.kolektor.update', $kolektor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kolektor</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                id="nama" name="nama" value="{{ old('nama', $kolektor->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email', $kolektor->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Anggota -->
                        <div class="mb-4">
                        <label for="anggota_id" class="form-label">Pilih Anggota</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-people-fill"></i></span>
                            <select name="anggota_id" id="anggota_id" 
                                class="form-control @error('anggota_id') is-invalid @enderror" required>
                                <option value="">Pilih Anggota</option>
                                @foreach ($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}"
                                        {{ old('anggota_id', $kolektor->anggota_id) == $anggota->id ? 'selected' : '' }}>
                                        {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('anggota_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save-fill me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.kolektor') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kolektor
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
