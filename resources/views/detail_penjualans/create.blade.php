<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Detail Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0 text-center">Tambah Detail Penjualan</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('detail_penjualans.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="penjualan_id" class="form-label">Nama Pelanggan</label>
                    <select class="form-select" name="penjualan_id" id="penjualan_id" required>
                        <option value="" disabled selected>Pilih Pelanggan</option>
                        @foreach($penjualans as $penjualan)
                            <option value="{{ $penjualan->id }}">{{ $penjualan->pelanggan->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="produk-container">
                    <div class="produk-row row mb-3">
                        <div class="col-md-4">
                            <label>Produk:</label>
                            <select name="produk_id[]" class="form-select produk-select" required>
                                <option value="">Pilih Produk</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga }}">
                                        {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Jumlah:</label>
                            <input type="number" name="JumlahProduk[]" class="form-control jumlah-input" min="1" value="1" required>
                        </div>

                        <div class="col-md-3">
                            <label>Subtotal:</label>
                            <input type="text" class="form-control subtotal-input" readonly value="Rp 0">
                        </div>

                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-produk mt-4">Hapus</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="tambah-produk" class="btn btn-success">Tambah Produk</button>
                <h4 class="mt-3">Total Harga: <span id="total-harga">Rp 0</span></h4>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('detail_penjualans.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.produk-row').forEach(row => {
            let select = row.querySelector('.produk-select');
            let harga = select.options[select.selectedIndex].getAttribute('data-harga');
            harga = harga ? parseFloat(harga) : 0; // Pastikan harga tidak undefined
            let jumlah = parseInt(row.querySelector('.jumlah-input').value || 1);
            let subtotal = harga * jumlah;
            row.querySelector('.subtotal-input').value = "Rp " + subtotal.toLocaleString("id-ID");
            total += subtotal;
        });
        document.getElementById('total-harga').textContent = "Rp " + total.toLocaleString("id-ID");
    }

    document.getElementById('produk-container').addEventListener('change', function (event) {
        if (event.target.classList.contains('produk-select') || event.target.classList.contains('jumlah-input')) {
            updateTotal();
        }
    });

    document.getElementById('tambah-produk').addEventListener('click', function () {
        let container = document.getElementById('produk-container');
        let newRow = container.firstElementChild.cloneNode(true);

        // Reset dropdown produk ke default
        newRow.querySelector('.produk-select').selectedIndex = 0;
        newRow.querySelector('.jumlah-input').value = 1;
        newRow.querySelector('.subtotal-input').value = "Rp 0";

        container.appendChild(newRow);
        updateTotal();
    });

    document.getElementById('produk-container').addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-produk')) {
            event.target.closest('.produk-row').remove();
            updateTotal();
        }
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
