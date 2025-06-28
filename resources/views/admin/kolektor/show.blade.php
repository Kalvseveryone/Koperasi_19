@extends('layouts.app')

@section('title', 'Detail Kolektor - KitaAda Koperasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Kolektor</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('admin.kolektor') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-light" style="width: 200px;">Nama Kolektor</th>
                                <td>{{ $kolektor->nama }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Email</th>
                                <td>{{ $kolektor->email }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal Bergabung</th>
                                <td>{{ $kolektor->created_at->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.kolektor.edit', $kolektor->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kolektor.destroy', $kolektor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kolektor ini?')">
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
