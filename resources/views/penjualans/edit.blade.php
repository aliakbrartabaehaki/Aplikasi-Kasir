<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="col-md-6 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">Tambah Penjualan</div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('penjualans.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Pelanggan (Opsional)</label>
                        <select name="pelanggan_id" class="form-select">
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Penjualan</label>
                        <input type="date" name="tanggal_penjualan" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <div id="produk-list">
                            <div class="produk-item d-flex align-items-center">
                                <select name="produk_id[]" class="form-select produk-select" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                                            {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="jumlah[]" class="form-control ms-2 jumlah-input" placeholder="Jumlah" min="1" required>
                                <button type="button" class="btn btn-danger ms-2" onclick="hapusProduk(this)">X</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="tambahProduk()">+ Tambah Produk</button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Bayar</label>
                        <input type="text" id="total_bayar" name="total_bayar" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('penjualans.index') }}" class="btn btn-secondary mt-2">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
