@extends('layouts.app')

@section('title', 'Edit Pinjaman')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Pinjaman</h5>
                        <a href="{{ route('admin.pinjaman.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pinjaman.update', $pinjaman->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="anggota_id" class="form-label">Anggota</label>
                                    <select class="form-control @error('anggota_id') is-invalid @enderror" id="anggota_id" name="anggota_id" required>
                                        <option value="">Pilih Anggota</option>
                                        @foreach($anggotas as $anggota)
                                            <option value="{{ $anggota->id }}" {{ $pinjaman->anggota_id == $anggota->id ? 'selected' : '' }}>
                                                {{ $anggota->nama }} - {{ $anggota->nik }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('anggota_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah Pinjaman (Rp)</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                           id="jumlah" name="jumlah" value="{{ old('jumlah', $pinjaman->jumlah) }}" 
                                           min="1000" required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="jangka_waktu" class="form-label">Jangka Waktu (Bulan)</label>
                                    <input type="number" class="form-control @error('jangka_waktu') is-invalid @enderror" 
                                           id="jangka_waktu" name="jangka_waktu" value="{{ old('jangka_waktu', $pinjaman->jangka_waktu) }}" 
                                           min="1" max="60" required>
                                    @error('jangka_waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tujuan" class="form-label">Tujuan Pinjaman</label>
                                    <textarea class="form-control @error('tujuan') is-invalid @enderror" 
                                              id="tujuan" name="tujuan" rows="3" maxlength="255" required>{{ old('tujuan', $pinjaman->tujuan) }}</textarea>
                                    @error('tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ $pinjaman->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="aktif" {{ $pinjaman->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="lunas" {{ $pinjaman->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                        <option value="ditolak" {{ $pinjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                    <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                           id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="{{ old('tanggal_pinjam', $pinjaman->tanggal_pinjam ? (is_string($pinjaman->tanggal_pinjam) ? $pinjaman->tanggal_pinjam : $pinjaman->tanggal_pinjam->format('Y-m-d')) : '') }}" required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lunas" class="form-label">Tanggal Lunas</label>
                                    <input type="date" class="form-control @error('tanggal_lunas') is-invalid @enderror" 
                                           id="tanggal_lunas" name="tanggal_lunas" 
                                           value="{{ old('tanggal_lunas', $pinjaman->tanggal_lunas ? (is_string($pinjaman->tanggal_lunas) ? $pinjaman->tanggal_lunas : $pinjaman->tanggal_lunas->format('Y-m-d')) : '') }}">
                                    <small class="text-muted">Kosongkan jika belum lunas</small>
                                    @error('tanggal_lunas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="denda" class="form-label">Denda (Rp)</label>
                                    <input type="number" class="form-control @error('denda') is-invalid @enderror" 
                                           id="denda" name="denda" value="{{ old('denda', $pinjaman->denda ?? 0) }}" 
                                           min="0" step="1000">
                                    @error('denda')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                              id="catatan" name="catatan" rows="3" maxlength="500">{{ old('catatan', $pinjaman->catatan) }}</textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide tanggal lunas if status is not lunas
    const statusSelect = document.getElementById('status');
    const tanggalLunasField = document.getElementById('tanggal_lunas');
    const tanggalLunasLabel = tanggalLunasField.previousElementSibling;
    
    function toggleTanggalLunas() {
        if (statusSelect.value === 'lunas') {
            tanggalLunasField.style.display = 'block';
            tanggalLunasLabel.style.display = 'block';
            tanggalLunasField.required = true;
        } else {
            tanggalLunasField.style.display = 'none';
            tanggalLunasLabel.style.display = 'none';
            tanggalLunasField.required = false;
            tanggalLunasField.value = '';
        }
    }
    
    statusSelect.addEventListener('change', toggleTanggalLunas);
    toggleTanggalLunas(); // Run on page load
});
</script>
@endpush 