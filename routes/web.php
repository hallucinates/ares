<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'landing');

Route::get('id/{slug}', 'App\Http\Controllers\PesanController@index');
Route::post('cek', 'App\Http\Controllers\PesanController@cek');
Route::post('pesan', 'App\Http\Controllers\PesanController@pesan');

// Route::get('voucher/{layanan_id}/{kode}', 'App\Http\Controllers\PesanController@voucher');

Route::view('lacak-pesanan/{kode?}', 'pesan.lacak');
Route::post('lacak-pesanan', 'App\Http\Controllers\PesanController@lacak');

Route::post('ganti-pembayaran/{kode}', 'App\Http\Controllers\HalamanController@gantiPembayaran');
Route::post('testimoni/{kode}', 'App\Http\Controllers\HalamanController@testimoni');

Route::get('cek-pesanan', 'App\Http\Controllers\HalamanController@cekPesanan');

Route::post('payments/midtrans-notification', 'App\Http\Controllers\PaymentCallbackController@receive');

Route::view('syarat-dan-ketentuan', 'halaman.syarat_dan_ketentuan');
Route::view('kontak', 'halaman.kontak');
Route::post('kontak', 'App\Http\Controllers\HalamanController@kontak');

Route::get('cari', 'App\Http\Controllers\HalamanController@cari');
Route::view('daftar-harga', 'halaman.daftar_harga');

Route::view('kalkulator', 'kalkulator.index');
Route::view('winrate', 'kalkulator.winrate');
Route::view('magicwheel', 'kalkulator.magicwheel');
Route::view('zodiac', 'kalkulator.zodiac');
