<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'kode',
        'kategori',
        'produk',

        'layanan',
        'layanan_hj',
        'layanan_hb',
        'layanan_untung',
        'layanan_pid',

        'target',
        'target2',
        'target_hasil',

        'metode',
        'metode_fee',
        'metode_untung',

        'status',
        'fee',
        'fee_hasil',
        'total',
        'total_pure',

        'voucher_id',
        'voucher',
        'voucher_ketentuan',
        'voucher_potongan',

        'potongan_id',
        'potongan',

        'tipe',
        'pid',
        'informasi',

        'email',
        'no_wa',
        'uuid',
        'token',

        'created_by',
        'updated_by',
        'deleted',
    ];
}
