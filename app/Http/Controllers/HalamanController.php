<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Testimoni;

use App\Helper;

use Midtrans\Transaction;

use App\Services\Midtrans\CreateSnapTokenService;
use App\Services\Midtrans\CancelTransactionService;

use Ramsey\Uuid\Uuid;

class HalamanController extends Controller
{
    public function cekPesanan(Request $request)
    {
        \Artisan::call('app:ambil-master-layanan');
        \Artisan::call('app:cek-status-layanan');
        
        \Artisan::call('app:order-pesanan');
        \Artisan::call('app:cek-status-pesanan');

        toastr()->success('Cek Pesanan Berhasil', 'Gotcha!');
        return back();
    }

    public function gantiPembayaran(Request $request, $kode)
    {
        $pesanan = Pesanan::where('kode', $kode)->firstOrFail();
        $uuid    = Uuid::uuid4()->toString();

        $order = [
            'uuid'  => $uuid,
            'total' => $pesanan->total,
            'name'  => $pesanan->produk.' - '.$pesanan->layanan,
            'email' => $pesanan->email,
        ];
        $order = json_encode($order);

        try {        
            try {
                $midtrans_cancel = new CancelTransactionService(json_encode(['uuid' => $pesanan->uuid]));
                $cancel          = $midtrans_cancel->cancel();
            } catch (\Exception $e) {
                
            }

            $midtrans  = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            Pesanan::where('kode', $kode)->update([
                'token' => $snapToken,
                'uuid'  => $uuid,

                'updated_by' => 'ganti-pembayaran',
            ]);

            activity('ganti-pembayaran')
                ->event('Berhasil')
                ->withProperties(['message' => 'Berhasil'])
                ->log('Ganti Pembayaran Berhasil');

            toastr()->success('Ganti Pembayaran berhasil', 'Gotcha!');
            return redirect('lacak-pesanan/'.$kode);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('ganti-pembayaran')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ganti Pembayaran Gagal');

            toastr()->error('Sistem sedang dalam perbaikan', 'Gagal!');
            return back();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('ganti-pembayaran')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ganti Pembayaran Gagal (2)');

            toastr()->error('Sistem sedang dalam perbaikan', 'Gagal!');
            return back();
        }
    }

    public function testimoni(Request $request, $kode)
    {
        if ($request->bintang == '' || $request->bintang == 0) {
            toastr()->error('Silahkan pilih jumlah Bintang', 'Gagal!');
            return back();
        }

        if ($request->ulasan == '') {
            toastr()->error('Ulasan belum diisi', 'Gagal!');
            return back();
        }

        $pesanan = Pesanan::where('kode', $kode)->firstOrFail();

        Testimoni::create([
            'pesanan_kode' => $kode,

            'kategori' => $pesanan->kategori,
            'produk'   => $pesanan->produk,
            'layanan'  => $pesanan->layanan,
            'ulasan'   => $request->ulasan,
            'bintang'  => $request->bintang,
            'email'    => $pesanan->email,

            'created_by' => 'buat-testimoni',
        ]);

        toastr()->success('Terima kasih, Telah menilai Transaksi ini', 'Gotcha!');
        return back();
    }

    public function kontak(Request $request)
    {
        $details = [
            'name'   => $request->name,
            'no_wa'  => Helper::noWA($request->no_wa),
            'pesan'  => $request->pesan,
        ];

        \Mail::to('arestopup@gmail.com')->send(new \App\Mail\KontakMail($details));

        toastr()->success('Pesan kamu dikirim', 'Gotcha!');
        return back();
    }

    public function cari(Request $request)
    {
        $keyword = $request->get('keyword');

        $produks = Produk::where('deleted', 0)
            ->where(function($query) use($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('sub_name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('slug', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $keyword . '%');
            })
            ->orderBy('name', 'ASC')
            ->get();

        return view('halaman.cari', compact('produks'));
    }
}
