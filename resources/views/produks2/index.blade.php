@extends('temp')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Produk</h2>

    <div class="row">
        @foreach ($produks2 as $produk)
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                         class="card-img-top p-3" 
                         alt="{{ $produk->nama_produk }}" 
                         style="height: 180px; object-fit: contain;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">{{ $produk->nama_produk }}</h5>
                        <p class="mb-1">Harga: <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        <p class="mb-2">Stok: {{ $produk->stok }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
