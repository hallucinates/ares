<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'name',
        'sub_name',
        'slug',

        'image',
        'banner',
        'icon',
        
        'deskripsi',
        'placeholder',
        'placeholder2',

        'catatan',
        'cek_target',

        'pid',
        'tipe',

        'untung',
        'fee',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
