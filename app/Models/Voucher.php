<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'kode',
        'ketentuan',
        'potongan',
        'status',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
