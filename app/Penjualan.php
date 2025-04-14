<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Tambahkan ini!


class Penjualan extends Model
{
    protected $table = 'penjualans'; 
    protected $primaryKey = 'penjualan_id'; 
    protected $fillable = [
        'pelanggan_id', 
        'produk_id', 
        'kode_pembayaran',
         'tanggal_penjualan',
        'total_bayar', 
        'jumlah_bayar', 
        'kembalian',
         'metode_pembayaran', 
         'status'

    ];


    // Relasi ke pelanggan (jika ada tabel pelanggan)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
//     public function detailPenjualan()
// {
//     return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
// }
}