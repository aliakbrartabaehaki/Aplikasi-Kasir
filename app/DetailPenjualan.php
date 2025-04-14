<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = 'detail_penjualans'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'JumlahProduk',
        'subtotal',
    ];

    
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

   
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}