<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Layanan;
use App\Models\MasterLayanan;
use App\Models\Produk;

use App\Helper;

class CekStatusLayanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cek-status-layanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('Perintah (app:cek-status-layanan) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        $tipe_harga = Helper::pengaturan('tipe-harga');

        $layanans = Layanan::where('deleted', 0)->get();
        foreach ($layanans as $layanan) {
            $cek = MasterLayanan::where('m_code', $layanan->m_code)->where('status', 'available')->orderBy('price_'.$tipe_harga, 'ASC')->limit(1);
            if ($cek->count() > 0) {
                $master_layanan = $cek->first();

                $produk = Produk::findOrFail($layanan->produk_id);

                if ($layanan->kustom == 0) {
                    $hj = $master_layanan->{"price_$tipe_harga"} + $produk->untung;
                    $hb = $master_layanan->{"price_$tipe_harga"};
                } else {
                    $hj = $layanan->hj;
                    $hb = $master_layanan->{"price_$tipe_harga"};
                }

                Layanan::where('id', $layanan->id)->update([
                    'status' => 1,
                    'pid'    => $master_layanan->code,

                    'hj' => $hj,
                    'hb' => $hb,

                    'updated_by' => $this->signature,
                ]); 
            } else {
                Layanan::where('id', $layanan->id)->update([
                    'status'   => 0,
                    
                    'updated_by' => $this->signature,
                ]); 
            }
        }
    }
}
