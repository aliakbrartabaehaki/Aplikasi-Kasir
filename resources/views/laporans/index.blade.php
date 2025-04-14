@extends('temp')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="my-2">Laporan Penjualan</h2>
        </div>
        <div class="card-body">

            <!-- Form Filter Tanggal -->
            <form action="{{ route('laporans.index') }}" method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tombol Print -->
            <div class="d-flex justify-content-end mb-4 no-print">
                <button class="btn btn-success" onclick="printLaporan()">
                    <i class="bi bi-printer-fill me-2"></i>Cetak Laporan
                </button>
            </div>

            <!-- Area yang dicetak -->
            <div id="print-area">
                <div class="text-center mb-4 print-header">
                    <h3 class="mb-1">Laporan Penjualan</h3>
                    @if(request('tanggal_awal') && request('tanggal_akhir'))
                        <p class="text-muted">Periode: {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d M Y') }} s.d. {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d M Y') }}</p>
                    @else
                        <p class="text-muted">Periode: Semua Tanggal</p>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="15%">Kode Pembayaran</th>
                                <th width="12%">Tanggal</th>
                                <th width="15%">Pelanggan</th>
                                <th width="13%">Total Bayar</th>
                                <th width="13%">Jumlah Bayar</th>
                                <th width="12%">Kembalian</th>
                                <th width="15%">Metode Pembayaran</th>
                                <th width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualans as $key => $penjualan)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $penjualan->kode_pembayaran }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($penjualan->pelanggan)
                                            {{ $penjualan->pelanggan->nama_pelanggan }}
                                        @else
                                            <span class="text-muted fst-italic">Tidak tersedia</span>
                                        @endif
                                    </td>
                                    <td class="text-end">Rp{{ number_format($penjualan->total_bayar, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp{{ number_format($penjualan->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp{{ number_format($penjualan->kembalian, 0, ',', '.') }}</td>
                                    <td>{{ $penjualan->metode_pembayaran }}</td>
                                    <td>{{ $penjualan->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="alert alert-info mb-0">
                                            <i class="bi bi-info-circle me-2"></i>Tidak ada data penjualan ditemukan.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Total Penjualan -->
                <div class="card mt-4 mb-3 border-primary">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Total Penjualan</h5>
                        <h4 class="mb-0 text-primary">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</h4>
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="row mt-5 print-only">
                    <div class="col-6 text-center">
                        <p class="mb-5">Dibuat Print,</p>
                        <p>(_____________________)</p>
                        <p class="fw-bold">{{ optional(auth()->user())->name }}</p>
                        </div>
                    <div class="col-6 text-center">
                        <p class="mb-5">Mengetahui,</p>
                        <p>(_____________________)</p>
                        <p class="fw-bold">Manajer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Print -->
<script>
    function printLaporan() {
        var printContents = document.getElementById('print-area').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = `
            <div class="container">
                <div class="print-wrapper">
                    ${printContents}
                </div>
            </div>
        `;

        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

<!-- Style Print -->
<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .print-only {
        display: none;
    }

    @media print {
        body {
            font-size: 12pt;
            color: #000;
            background-color: #fff;
        }

        .container {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .print-wrapper {
            padding: 20px;
        }

        .print-header {
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .print-header h3 {
            font-size: 20pt;
            font-weight: bold;
            color: #007bff;
        }

        .print-only {
            display: block;
        }

        .card, .card-header, .card-body {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #d6eaff !important;
            color: #000 !important;
        }

        .table td, .table th {
            border: 1px solid #999 !important;
            padding: 8px;
        }

        .table-primary {
            background-color: #d6eaff !important;
        }

        .badge {
            border: 1px solid #000;
            color: #000 !important;
            background-color: #e0e0e0 !important;
            font-weight: normal;
        }

        .text-primary {
            color: #007bff !important;
        }

        .btn,
        form,
        .no-print {
            display: none !important;
        }

        .print-only p {
            font-size: 12pt;
        }

        .print-only .fw-bold {
            font-weight: bold;
        }
    }
</style>
@endsection
