<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'produk_id'; // Pastikan sesuai dengan database

    public $incrementing = false; // Jika primary key bukan auto-increment
    protected $keyType = 'string'; // Sesuaikan jika bukan integer
    
    protected $fillable =[
        "nama_produk",
        "harga",
        "stok",
        "gambar"
    ];

    public function penjualans()
{
    return $this->hasMany(Penjualan::class, 'produk_id');
}

public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

}
