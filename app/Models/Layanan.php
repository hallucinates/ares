<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    protected $fillable = [
        'kategori_id',
        'produk_id',
        'label_id',

        'name',
        'hj',
        'hb',

        'kustom',
        'status',
        'pid',
        'm_code',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
