@extends('temp')
@section('content')

<div class="container-fluid">
    @can('admin')
    <h2 class="main-title mb-4">Selamat Datang {{ auth()->user()->name }} di Beranda Admin</h2>
    @endcan

    <div class="row g-4">
        <!-- Card Produk -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 p-3 card-hover h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 140px;">
                    <div>
                        <div class="text-md fw-bold text-primary text-uppercase mb-2">Produk</div>
                        <div class="h4 fw-bold text-dark">{{ \App\Produk::count() }}</div>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-box fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pelanggan -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 p-3 card-hover h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 140px;">
                    <div>
                        <div class="text-md fw-bold text-success text-uppercase mb-2">Pelanggan</div>
                        <div class="h4 fw-bold text-dark">{{ \App\Pelanggan::count() }}</div>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Penjualan -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 p-3 card-hover h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 140px;">
                    <div>
                        <div class="text-md fw-bold text-warning text-uppercase mb-2">Penjualan</div>
                        <div class="h4 fw-bold text-dark">{{ \App\Penjualan::count() }}</div>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Hasil Penjualan -->
        <div class="col-xl-3 col-lg-3 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-4 p-3 card-hover h-100">
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 140px;">
                    <div>
                        <div class="text-md fw-bold text-danger text-uppercase mb-2">Total Hasil Penjualan</div>
                        <div class="h5 fw-bold text-dark">Rp {{ number_format(\App\Penjualan::sum('total_bayar'), 0, ',', '.') }}</div>
                    </div>
                    <div class="text-end">
                        <i class="fas fa-money-bill-wave fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card {
        border-radius: 1rem;
    }

    .text-dark {
        color: #343a40 !important;
    }

    h2.main-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #4a4a4a;
    }
</style>
@endsection
