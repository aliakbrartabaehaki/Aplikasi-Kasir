<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 500px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 20px;
        }
        .produk-item {
            gap: 5px;
        }
        .btn-sm {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <div class="form-container">
        <h4 class="text-center">Tambah Penjualan</h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('penjualans.store') }}" method="POST">
            {{ csrf_field() }}

            <div class="mb-2">
                <label class="form-label">Pelanggan</label>
                <select name="pelanggan_id" class="form-select">
                    <option value="">Pilih Pelanggan (Opsional)</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->pelanggan_id }}">{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">Tanggal Penjualan</label>
                <input type="date" name="tanggal_penjualan" class="form-control" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Produk</label>
                <div id="produk-list">
                    <div class="produk-item d-flex align-items-center">
                        <select name="produk_id[]" class="form-select produk-select" required onchange="updateSubtotal(this)">
                            <option value="">Pilih Produk</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga }}">
                                    {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        <input type="number" name="jumlah[]" class="form-control jumlah-input" placeholder="Qty" min="1" required oninput="updateSubtotal(this)" style="width: 70px;">
                        <input type="text" name="subtotal[]" class="form-control subtotal-input" placeholder="Subtotal" readonly style="width: 100px;">
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(this)">X</button>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-2" onclick="tambahProduk()">Tambah Produk</button>
            </div>

            <div class="mb-2">
                <label class="form-label">Total Bayar</label>
                <input type="text" id="total_bayar" name="total_bayar" class="form-control" readonly>
            </div>

            <div class="mb-2">
                <label class="form-label">Jumlah Bayar</label>
                <input type="number" name="jumlah_bayar" class="form-control" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-select">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                <a href="{{ route('penjualans.index') }}" class="btn btn-secondary btn-sm">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
function tambahProduk() {
    let produkList = document.getElementById("produk-list");
    let produkItem = document.createElement("div");
    produkItem.className = "produk-item d-flex align-items-center";

    produkItem.innerHTML = `
        <select name="produk_id[]" class="form-select produk-select" required onchange="updateSubtotal(this)">
            <option value="">Pilih Produk</option>
            @foreach($produks as $produk)
                <option value="{{ $produk->produk_id }}" data-harga="{{ $produk->harga }}">
                    {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </option>
            @endforeach
        </select>
        <input type="number" name="jumlah[]" class="form-control jumlah-input" placeholder="Qty" min="1" required oninput="updateSubtotal(this)" style="width: 70px;">
        <input type="text" name="subtotal[]" class="form-control subtotal-input" placeholder="Subtotal" readonly style="width: 100px;">
        <button type="button" class="btn btn-danger btn-sm" onclick="hapusProduk(this)">X</button>
    `;

    produkList.appendChild(produkItem);
}

function hapusProduk(button) {
    button.parentElement.remove();
    hitungTotal();
}

function updateSubtotal(element) {
    let produkItem = element.closest(".produk-item");
    let produkSelect = produkItem.querySelector(".produk-select");
    let jumlahInput = produkItem.querySelector(".jumlah-input");
    let subtotalInput = produkItem.querySelector(".subtotal-input");

    let harga = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-harga");
    let jumlah = jumlahInput.value;

    if (harga && jumlah) {
        subtotalInput.value = harga * jumlah;
    } else {
        subtotalInput.value = 0;
    }
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    let subtotalInputs = document.querySelectorAll(".subtotal-input");

    subtotalInputs.forEach(subtotal => {
        total += parseInt(subtotal.value) || 0;
    });

    document.getElementById("total_bayar").value = total;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
