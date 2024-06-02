<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterLayanan extends Model
{
    protected $table = 'master_layanan';

    protected $fillable = [
        'm_code',
        'm_server',
        'code',
        'brand',
        'name',
        'price_basic',
        'price_premium',
        'price_special',
        'server',
        'status',
        'tipe',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
