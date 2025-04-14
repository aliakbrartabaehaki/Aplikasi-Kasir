<?php

use Illuminate\Support\Facades\Route;
use App\Models\Detail;
use App\Http\Controllers\PelangganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('pelanggans', 'PelangganController@index')->name('pelanggans.index');
Route::get('pelanggans/create', 'PelangganController@create')->name('pelanggans.create');
Route::post('pelanggans', 'PelangganController@store')->name('pelanggans.store');
Route::get('pelanggans/{pelanggan}', 'PelangganController@show')->name('pelanggans.show');
Route::get('pelanggans/{pelanggan}/edit', 'PelangganController@edit')->name('pelanggans.edit');
Route::put('pelanggans/{pelanggan}', 'PelangganController@update')->name('pelanggans.update');;
Route::delete('pelanggans/{pelanggan}', 'PelangganController@destroy')->name('pelanggans.destroy');;




// Route::get('penjualans', 'PenjualanController@index')->name('penjualans.index');
// Route::get('penjualans/create', 'PenjualanController@create')->name('penjualans.create');
// Route::post('penjualans', 'PenjualanController@store')->name('penjualans.store');
// Route::get('penjualans/{penjualan}', 'PenjualanController@show')->name('penjualans.show');
// Route::get('penjualans/{penjualan}/edit', 'PenjualanController@edit')->name('penjualans.edit');
// Route::put('penjualans/{penjualan}', 'PenjualanController@update')->name('penjualans.update');;
// Route::delete('penjualans/{penjualan}', 'PenjualanController@destroy')->name('penjualans.destroy');;

Route::resource('penjualans', PenjualanController::class);



Route::get('produks', 'ProdukController@index')->name('produks.index');
Route::get('produks/create', 'ProdukController@create')->name('produks.create');
Route::post('produks', 'ProdukController@store')->name('produks.store');
// Route::get('produks/{penjualan}', 'ProdukController@show')->name('produks.show');
Route::get('produks/{produk}/edit', 'ProdukController@edit')->name('produks.edit');
Route::put('produks/{produk}', 'ProdukController@update')->name('produks.update');;
Route::delete('produks/{produk}', 'ProdukController@destroy')->name('produks.destroy');;


Route::get('detail_penjualans', 'DetailPenjualanController@index')->name('detail_penjualans.index');
Route::get('detail_penjualans/create', 'DetailPenjualanController@create')->name('detail_penjualans.create');
Route::post('detail_penjualans', 'DetailPenjualanController@store')->name('detail_penjualans.store');
Route::get('detail_penjualans/{penjualan}', 'DetailPenjualanController@show')->name('detail_penjualans.show');
Route::get('detail_penjualans/{detail_penjualans}/edit', 'DetailPenjualanController@edit')->name('detail_penjualans.edit');
Route::put('detail_penjualans/{detail_penjualans}', 'DetailPenjualanController@update')->name('detail_penjualans.update');;
Route::delete('detail_penjualans/{detail_penjualans}', 'DetailPenjualanController@destroy')->name('detail_penjualans.destroy');;

Route::get('transaksis', 'TransaksiController@index')->name('transaksis.index');
Route::get('transaksis/create', 'TransaksiController@create')->name('transaksis.create');
Route::post('transaksis', 'TransaksiController@store')->name('transaksis.store');
Route::get('transaksis/{transaksis}', 'TransaksiController@show')->name('transaksis.show');
Route::get('transaksis/{penjualan}', 'TransaksiController@show')->name('transaksis.show');
Route::get('transaksis/{transaksis}/edit', 'TransaksiController@edit')->name('transaksis.edit');
Route::put('transaksis/{transaksis}', 'TransaksiController@update')->name('transaksis.update');;
Route::delete('transaksis/{transaksis}', 'TransaksiController@destroy')->name('transaksis.destroy');;


Route::get('produks2', 'ProdukController@index2')->name('produks2.index');

Route::get('/laporans', 'LaporanController@index')->name('laporans.index');



// Route::get('detail_penjualans2', 'DetailPenjualanController@index2')->name('detail_penjualans.index2');
// Route::get('detail_penjualans2/create', 'DetailPenjualanController@create2')->name('detail_penjualans.create2');
// Route::post('detail_penjualans2', 'DetailPenjualanController@store2')->name('detail_penjualans.store2');
// Route::get('detail_penjualans2/{penjualan}', 'DetailPenjualanController@show2')->name('detail_penjualans.show2');
// Route::get('detail_penjualans2/{detail_penjualans}/edit', 'DetailPenjualanController@edit2')->name('detail_penjualans.edit2');
// Route::put('detail_penjualans2/{detail_penjualans}', 'DetailPenjualanController@update2')->name('detail_penjualans.update2');
// Route::delete('detail_penjualans2/{detail_penjualans}', 'DetailPenjualanController@destroy2')->name('detail_penjualans.destroy2');






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

