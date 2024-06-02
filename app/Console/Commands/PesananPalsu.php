<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\Testimoni;
use App\Models\Produk;
use App\Models\Kategori;

use App\Helper;

use Faker\Factory as Faker;

class PesananPalsu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:pesanan-palsu {jumlah}';

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
        \Log::info('Perintah (app:pesanan-palsu) berhasil di jalankan ' . date('Y-m-d H:i:s'));

        $jumlah = $this->argument('jumlah');

        $faker = Faker::create('id_ID');

        for ($x = 1; $x <= $jumlah; $x++) {
            $pesanan_kode = Helper::generatePesananKode();

            $layanan  = Layanan::inRandomOrder()->first();
            $produk   = Produk::where('id', $layanan->produk_id)->first();
            $kategori = Kategori::where('id', $layanan->kategori_id)->first();

            $email = $faker->email;

            Pesanan::create([
                'kode' => $pesanan_kode,

                'kategori'       => $kategori->name,
                'produk'         => $produk->name,
                'layanan'        => $layanan->name,
                'layanan_hj'     => 0,
                'layanan_hb'     => 0,
                'layanan_untung' => 0,
                'layanan_pid'    => 0,

                'target' => mt_rand(1000000000, 9999999999),
                'status' => 6,

                'fee'       => 0,
                'fee_hasil' => 0,

                'total'      => $layanan->hj,
                'total_pure' => $layanan->hj,

                'tipe'  => $produk->tipe,
                'email' => $email,

                'deleted' => 2,

                'updated_by' => $this->signature,
            ]);

            $adjectives = ['Hebat', 'Mantap', 'Cepat', 'Luar biasa', 'Menakjubkan'];
            $nouns = ['Pelayanan', 'Produk', 'Kualitas'];

            $adjective = $adjectives[array_rand($adjectives)];
            $noun = $nouns[array_rand($nouns)];

            $ulasan = "$noun $adjective sekali!";

            Testimoni::create([
                'pesanan_kode' => $pesanan_kode,
    
                'kategori' => $kategori->name,
                'produk'   => $produk->name,
                'layanan'  => $layanan->name,
                'bintang'  => mt_rand(4, 5),
                'ulasan'   => $ulasan,
                'email'    => $email,

                'deleted' => 2,
    
                'updated_by' => $this->signature,
            ]);
        }
    }
}
