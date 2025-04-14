<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">

<div class="container mt-5">
    <h1 class="mb-4">Detail Penjualan</h1>

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Detail ID: {{ $detail->id }}</h5>
        </div>
        <div class="card-body">
            <p><strong>Penjualan:</strong> {{ $detail->penjualan->tanggal_penjualan ?? 'Tidak Ada Data' }}</p>
            <p><strong>Produk:</strong> {{ $detail->produk->nama_produk ?? 'Tidak Ada Data' }}</p>
            <p><strong>Jumlah Produk:</strong> {{ $detail->JumlahProduk }}</p>
            <p><strong>Subtotal:</strong> Rp {{ number_format($detail->Subtotal, 0, ',', '.') }}</p>
            <a href="{{ route('detail_penjualans.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
