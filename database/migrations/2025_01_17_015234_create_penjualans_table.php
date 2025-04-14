<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('penjualans', function (Blueprint $table) {
                $table->bigIncrements('penjualan_id'); // Ubah primary key dari 'id' ke 'penjualan_id'
                $table->unsignedInteger('pelanggan_id')->nullable();
                $table->json('produk_id')->nullable();
                $table->string('kode_pembayaran')->unique();
                $table->date('tanggal_penjualan');
                $table->decimal('total_bayar', 10, 2);
                $table->decimal('jumlah_bayar', 10, 2)->default(0);
                $table->decimal('kembalian', 10, 2)->default(0);
                $table->enum('metode_pembayaran', ['cash', 'transfer', 'credit_card', 'e_wallet'])->default('cash');
                $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
                $table->timestamps();
            });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
