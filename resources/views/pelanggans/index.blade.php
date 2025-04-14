@extends('temp')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Pelanggan</h4>
            <a href="{{ route('pelanggans.create') }}" class="btn btn-light btn-sm">Tambah Pelanggan</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                            <td>{{ $pelanggan->alamat }}</td>
                            <td>{{ $pelanggan->nomor_telepon }}</td>
                            <td class="text-center">
                                <a href="{{ route('pelanggans.show', $pelanggan->pelanggan_id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('pelanggans.edit', $pelanggan->pelanggan_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('pelanggans.destroy', $pelanggan->pelanggan_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($pelanggans->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada data pelanggan.
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
   @endsection 