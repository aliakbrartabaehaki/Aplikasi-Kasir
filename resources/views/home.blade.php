@extends('temp')
@section('content')

<div class="container-fluid py-5 px-4">
    @can('admin')
    <h2 class="main-title text-center mb-5 animate__animated animate__fadeInDown">
        👋 Selamat Datang, <span class="highlight">{{ auth()->user()->name }}</span> di Beranda Admin
    </h2>
    @endcan
    <div class="container-fluid py-5 px-4">
    @can('kasir')
    <h2 class="main-title text-center mb-5 animate__animated animate__fadeInDown">
        👋 Selamat Datang, <span class="highlight">{{ auth()->user()->name }}</span> di Beranda Kasir
    </h2>
    @endcan


    <div class="row g-4">
        @php
            $cards = [
                ['label' => 'Produk', 'count' => \App\Produk::count(), 'icon' => 'fa-box', 'color' => '#6C5CE7'],
                ['label' => 'Pelanggan', 'count' => \App\Pelanggan::count(), 'icon' => 'fa-users', 'color' => '#00CEC9'],
                ['label' => 'Penjualan', 'count' => \App\Penjualan::count(), 'icon' => 'fa-shopping-cart', 'color' => '#FAB1A0'],
                ['label' => 'Total Penjualan', 'count' => 'Rp ' . number_format(\App\Penjualan::sum('total_bayar'), 0, ',', '.'), 'icon' => 'fa-money-bill-wave', 'color' => '#FF7675'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="glass-card animate__animated animate__fadeInUp">
                <div class="d-flex flex-column justify-content-between h-100">
                    <div>
                        <p class="fw-semibold mb-1 text-uppercase" style="color: {{ $card['color'] }}">{{ $card['label'] }}</p>
                        <h3 class="fw-bold text-dark">{{ $card['count'] }}</h3>
                    </div>
                    <div class="icon-bubble" style="background: {{ $card['color'] }}">
                        <i class="fas {{ $card['icon'] }} fa-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- STYLE -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    body {
        background: linear-gradient(to right, #f8f9fa, #e0eafc);
    }

    .glass-card {
        backdrop-filter: blur(14px);
        background: rgba(255, 255, 255, 0.75);
        border-radius: 1.5rem;
        padding: 1.75rem;
        min-height: 170px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.4s ease;
    }

    .glass-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .icon-bubble {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        align-self: flex-end;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .main-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3436;
    }

    .highlight {
        color: #6C5CE7;
        font-weight: bold;
    }

    .text-dark {
        color: #2f3542 !important;
    }
</style>
@endsection
