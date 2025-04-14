@extends('temp')
@section('content')
<div class="container">
    <center><h2>Detail Penjualan</h2></center>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('detail_penjualans.create') }}" class="btn btn-primary mb-3">Tambah Detail Penjualan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail['penjualan']->pelanggan->nama_pelanggan ?? 'Tidak Ada Data' }}</td>
                    <td>{{ $detail['produk'] ?? 'Tidak Ada Data' }}</td>
                    <td>Rp{{ number_format($detail['total_harga'], 0, ',', '.') }}</td>
                    <td>
                        <div class="d-grid gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('detailpenjualans.edit', $detail['penjualan']->penjualan_id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Tombol Lihat -->
                            <a href="{{ route('detailpenjualans.show', $detail['penjualan']->penjualan_id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('detailpenjualans.destroy', $detail['penjualan']->penjualan_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                let form = this.closest("form");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection