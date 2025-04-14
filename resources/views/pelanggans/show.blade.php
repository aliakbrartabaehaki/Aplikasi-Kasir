<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pelanggan</h5>
        </div>
        <div class="card-body">
            <h4 class="card-title">{{ $pelanggan->nama_pelanggan }}</h4>
            <hr>
            <p class="card-text"><strong>Alamat:</strong> {{ $pelanggan->alamat }}</p>
            <p class="card-text"><strong>Nomor Telepon:</strong> {{ $pelanggan->nomor_telepon }}</p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('pelanggans.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    