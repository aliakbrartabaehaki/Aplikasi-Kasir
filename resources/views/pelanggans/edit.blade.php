<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Pelanggan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pelanggans.update', $pelanggan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ $pelanggan->alamat }}" required>
                </div>
                
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" class="form-control" value="{{ $pelanggan->nomor_telepon }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
