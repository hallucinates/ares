<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Pesanan;
use App\Models\Voucher;

use Carbon\Carbon;

use App\Services\Midtrans\CancelTransactionService;

class BatalPesanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batal-pesanan';

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
        \Log::info('Perintah (app:batal-pesanan) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        $pesanans = Pesanan::where('deleted', 0)->where('status', 1)->get();
        foreach ($pesanans as $pesanan) {

            $waktu = Carbon::parse($pesanan->created_at);

            if ($waktu->diffInHours(Carbon::now()) > 3) {
                if ($pesanan->uuid != NULL) {
                    try {
                        $midtrans_cancel = new CancelTransactionService(json_encode(['uuid' => $pesanan->uuid]));
                        $cancel          = $midtrans_cancel->cancel();

                        Pesanan::where('id', $pesanan->id)->update([
                            'status' => 2,
        
                            'updated_by' => $this->signature,
                        ]); 
                    } catch (\Exception $e) {
                        Pesanan::where('id', $pesanan->id)->update([
                            'status' => 2,
        
                            'updated_by' => $this->signature,
                        ]); 
                    }
                } else {
                    Pesanan::where('id', $pesanan->id)->update([
                        'status' => 2,
    
                        'updated_by' => $this->signature,
                    ]); 
                }

                if ($pesanan->voucher != NULL) {
                    Voucher::where('kode', $pesanan->voucher)->update([
                        'status'   => 1,

                        'updated_by' => $this->signature,
                    ]);
                }
            }
        }
    }
}
