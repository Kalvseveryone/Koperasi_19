@extends('layouts.app')

@section('title', 'Anggota - KitaAda Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Anggota</h3>
                </div>
                <div class="card-body">
                    <div class="top-actions mb-3">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Anggota
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table id="anggotaTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>No. Telepon</th>
                                    <th>Email</th>
                                    <th class="text-center">Saldo Simpanan</th>
                                    <th class="text-center" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggotas as $anggota)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $anggota->nama }}</td>
                                    <td>{{ $anggota->nik }}</td>
                                    <td>{{ $anggota->no_telepon }}</td>
                                    <td>{{ $anggota->email }}</td>
                                    <td class="text-end">Rp {{ number_format($anggota->saldo_simpanan, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.anggota.show', $anggota->id) }}" class="btn btn-info btn-sm" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.anggota.edit', $anggota->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.anggota.destroy', $anggota->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm" title="Hapus" onclick="confirmDelete(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(button) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Apakah Anda yakin ingin menghapus anggota ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

$(document).ready(function() {
    $('#anggotaTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        lengthMenu: [
            [10, 25, 50, -1],
            ['10', '25', '50', 'Semua']
        ],
        order: [[0, 'asc']]
    });

    @if(session('success') || session('message'))
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") ?? session("message") }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session("error") }}',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
        });
    @endif
});
</script>
@endpush
