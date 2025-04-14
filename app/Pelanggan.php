<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{

    protected $table = 'pelanggans'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'pelanggan_id';
    protected $fillable = [
        "nama_pelanggan",
        "alamat",
        "nomor_telepon"
    ];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'pelanggan_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }
}
