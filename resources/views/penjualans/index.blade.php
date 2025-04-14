@extends('temp')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table thead th {
            background-color: #343a40;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        .btn-sm {
            font-size: 0.85rem;
            padding: 5px 10px;
        }
        .badge {
            padding: 6px 10px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container">
    <h2>Daftar Penjualan</h2>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tombol Tambah Penjualan -->
    <a href="{{ route('penjualans.create') }}" class="btn btn-primary mb-3">Tambah Penjualan</a>
    <!-- Tabel Penjualan -->
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Total Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Kembalian</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualans as $penjualan)
                <tr>
                    <td class="text-nowrap">{{ $loop->iteration }}</td>
                    <td class="text-nowrap">{{ $penjualan->kode_pembayaran }}</td>
                    <td class="text-nowrap">{{ date('d-m-Y', strtotime($penjualan->tanggal_penjualan)) }}</td>
                    <td class="text-nowrap">{{ $penjualan->pelanggan ? $penjualan->pelanggan->nama_pelanggan : 'Umum' }}</td>

                    <!-- Menampilkan Produk dalam satu baris -->
                    <td class="text-nowrap">
                        @php
                            $produkList = json_decode($penjualan->produk_id, true);
                            $produkString = $produkList ? implode(', ', array_map(function($produk) {
                                return $produk['nama_produk'] . " ({$produk['jumlah']}x)";
                            }, $produkList)) : '-';
                        @endphp
                        {{ $produkString }}
                    </td>

                    <td class="text-nowrap">{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                    <td class="text-nowrap">{{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="text-nowrap">{{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                    <td class="text-nowrap">{{ ucfirst($penjualan->metode_pembayaran) }}</td>

                    <!-- Status Pembayaran -->
                    <td class="text-nowrap">
                        @if($penjualan->status == 'paid')
                            <span class="badge badge-success">Lunas</span>
                        @elseif($penjualan->status == 'pending')
                            <span class="badge badge-warning">Menunggu</span>
                        @else
                            <span class="badge badge-danger">Gagal</span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="text-nowrap">
                        @can('admin')
                        <a href="{{ route('penjualans.edit', $penjualan->penjualan_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('penjualans.destroy', $penjualan->penjualan_id) }}" method="POST" style="display:inline-block;">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">Hapus</button>
                        </form>
                        @endcan
                        <a href="{{ route('penjualans.show', $penjualan->penjualan_id) }}" class="btn btn-info btn-sm">Cetak Struk</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
