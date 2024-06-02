<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Pesanan;

use App\Services\Vipayment\PesananService;

class CekStatusPesanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cek-status-pesanan';

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
        \Log::info('Perintah (app:cek-status-pesanan) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        // $pesanans = Pesanan::where('deleted', 0)->where('pid', '!=', NULL)->whereBetween('status', [4, 5])
        //     ->oldest()
        //     ->get();

        $pesanans = Pesanan::where('deleted', 0)->where('pid', '!=', NULL)->where(function($query) {
                $query->where('status', 4)
                    ->orWhere('status', 5);
            })
            ->oldest()
            ->get();
        foreach ($pesanans as $pesanan) {
            if ($pesanan->tipe == 1) {
                (new PesananService())->cekPesanan($pesanan->kode, $pesanan->pid);
            } else if ($pesanan->tipe == 2) {
                (new PesananService())->cekPesananPPOB($pesanan->kode, $pesanan->pid);
            }
        }
    }
}
