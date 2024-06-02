<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni';

    protected $fillable = [
        'pesanan_kode',

        'kategori',
        'produk',
        'layanan',
        'bintang',
        'ulasan',
        'email',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
