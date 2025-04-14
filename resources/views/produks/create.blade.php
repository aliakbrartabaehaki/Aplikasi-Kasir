<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">Tambah Produk</div>
        <div class="card-body">
            <form action="{{ route('produks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                    @error('nama_produk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            <!-- Harga -->
<div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}">
        @error('harga')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>


                <!-- Stok -->
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}">
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar</label>
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan & Kembali -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('produks.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
