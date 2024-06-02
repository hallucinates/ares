<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\MasterLayanan;

use App\Services\Vipayment\LayananService;

class AmbilMasterLayanan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ambil-master-layanan';

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
        \Log::info('Perintah (app:ambil-master-layanan) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        MasterLayanan::where('status', 'available')->update([
            'status' => 'empty',

            'updated_by' => $this->signature,
        ]);

        (new LayananService())->ambilLayanan();
        (new LayananService())->ambilLayananPPOB();
    }
}
