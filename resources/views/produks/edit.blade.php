<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h3 class="mb-0">Edit Produk</h3>
        </div>
        <div class="card-body">
        <form action="{{ route('produks.update', $produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
                @method('PUT') 
                
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" 
                           value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                </div>
                
                <div class="mb-3">
    <label for="harga" class="form-label">Harga</label>
    <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" step="0.01" name="harga" id="harga" class="form-control" 
               value="{{ old('harga', $produk->harga) }}" required>
    </div>
</div>
    
                
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" 
                           value="{{ old('stok', $produk->stok) }}" required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Produk</label>
                    @if ($produk->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="img-thumbnail" width="150">
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('produks.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
