@extends('temp')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Daftar Produk</h2>

    {{-- Form Pencarian --}}
    <form action="{{ route('produks.index') }}" method="GET" class="mb-4" style="max-width: 500px; margin: auto;">
        <div class="input-group shadow-sm">
            <input 
                type="text" 
                class="form-control rounded-start" 
                placeholder="Cari produk..." 
                name="query" 
                value="{{ $query ?? '' }}"
            >
            <div class="input-group-append">
                <button class="btn btn-primary rounded-end" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </div>
    </form>

    {{-- Tombol Tambah Produk --}}
    @can('admin')
        <div class="text-end mb-3">
            <a href="{{ route('produks.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    @endcan

    {{-- Daftar Produk --}}
    <div class="row">
        @forelse ($produks as $produk)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm h-100">
                    <img 
                        src="{{ asset('storage/' . $produk->gambar) }}" 
                        class="card-img-top p-3" 
                        alt="{{ $produk->nama_produk }}" 
                        style="height: 180px; object-fit: contain;"
                    >
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">{{ $produk->nama_produk }}</h5>
                        <p class="mb-1">Harga: <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        <p class="mb-2">Stok: {{ $produk->stok }}</p>

                        @can('admin')
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('produks.edit', $produk->produk_id) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form 
                                action="{{ route('produks.destroy', $produk->produk_id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada produk ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
