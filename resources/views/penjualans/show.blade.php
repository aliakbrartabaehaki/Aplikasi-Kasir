<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Courier New', monospace; }
        .struk-container { max-width: 320px; margin: auto; background: white; padding: 15px; border-radius: 5px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); }
        .header, .footer { text-align: center; font-weight: bold; }
        .produk-list { border-top: 2px dotted black; padding-top: 10px; }
        .produk-list li { display: flex; justify-content: space-between; font-size: 12px; }
        .total-section { border-top: 2px solid black; padding-top: 10px; font-size: 14px; }
        .btn-action { font-size: 12px; padding: 5px 10px; }
        @media print {
            body { background: none; }
            .struk-container { box-shadow: none; border: none; max-width: 100%; }
            .btn-action { display: none; }
        }
    </style>
</head>
<body>
    <div class="struk-container mt-3">
        <div id="struk-print">
            <div class="header">
                <h4>MADURAMART</h4>
                <p>Jl. Potlot No.123, Jakarta</p>
                <p>--------------------------------</p>
            </div>

            <p><strong>ID Transaksi:</strong> {{ $penjualan->kode_pembayaran }}</p>
            <p><strong>Tanggal:</strong> {{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</p>
            <p><strong>Pelanggan:</strong> {{ $penjualan->pelanggan ? $penjualan->pelanggan->nama_pelanggan : 'Umum' }}</p>

            <div class="produk-list">
                <h5>Produk:</h5>
                @php $produk_list = json_decode($penjualan->produk_id, true); @endphp
                @if(is_array($produk_list))
                    <ul class="list-unstyled">
                        @foreach($produk_list as $produk)
                            <li>
                                <span>{{ $produk['nama_produk'] }} ({{ $produk['jumlah'] }})</span>
                                <span>Rp{{ number_format($produk['harga'] * $produk['jumlah'], 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Data produk tidak tersedia.</p>
                @endif
            </div>

            <div class="total-section">
                <p><strong>Total:</strong> Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</p>
                <p><strong>Bayar:</strong> Rp{{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</p>
                <p><strong>Kembali:</strong> Rp{{ number_format($penjualan->kembalian, 0, ',', '.') }}</p>
                <p><strong>Metode:</strong> {{ strtoupper($penjualan->metode_pembayaran) }}</p>
                <p><strong>Status:</strong> 
                    @if($penjualan->status == 'paid')
                        ✅ Lunas
                    @elseif($penjualan->status == 'pending')
                        ⏳ Menunggu
                    @else
                        ❌ Gagal
                    @endif
                </p>
            </div>

            <div class="footer">
                <p>Terima Kasih!</p>
                <p>--------------------------------</p>
            </div>
        </div>

        <div class="text-center mt-3">
            <button class="btn btn-primary btn-action" onclick="printStruk()">🖨 Print</button>
            <a href="{{ route('penjualans.index') }}" class="btn btn-secondary btn-action">Kembali</a>
        </div>
    </div>

    <script>
        function printStruk() {
            var printContents = document.getElementById("struk-print").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</body>
</html>
