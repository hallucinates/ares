<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Pesanan;

use App\Services\Vipayment\PesananService;

class OrderPesanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-pesanan';

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
        \Log::info('Perintah (app:order-pesanan) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        $pesanans = Pesanan::where('deleted', 0)->where('pid', NULL)->where('status', 4)
            ->oldest()
            ->get();
        foreach ($pesanans as $pesanan) {
            if ($pesanan->tipe == 1) {
                (new PesananService())->order($pesanan->kode, $pesanan->layanan_pid, $pesanan->target, $pesanan->target2);
            } else if ($pesanan->tipe == 2) {
                (new PesananService())->orderPPOB($pesanan->kode, $pesanan->layanan_pid, $pesanan->target);
            }
            sleep(5);
        }
    }
}
