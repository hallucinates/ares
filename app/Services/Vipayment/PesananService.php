<?php

namespace App\Services\Vipayment;

use Illuminate\Support\Facades\Log;

use App\Models\Pesanan;

use App\Helper;

class PesananService
{
    private $api_id   = 'kBLtf2FP';
    private $api_key  = '6JAlPS3THehNcpSmvAU7HEb5OYdVFjvXbUzkX2ZEq71tMSklM27AN74cauwNK5QZ';  

    public function order($pesanan_kode, $pid, $target, $target2)
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'     => $this->api_key,
                    'sign'    => $signature,
                    'type'    => 'order',
                    'service' => $pid,
                    
                    'data_no'   => $target,
                    'data_zone' => $target2,
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));

            $pesanan = Pesanan::where('kode', $pesanan_kode)->first();
            if ($res->result == true) {
                Pesanan::where('kode', $pesanan_kode)->update([
                    'status'   => 5,
                    'pid'      => $res->data->trxid,

                    'updated_by' => 'order',
                ]);

                activity('order')
                    ->event('Berhasil')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'pid' => $res->data->trxid])
                    ->log('Order Berhasil, Kode Pesanan: '.$pesanan_kode);
            } else if ($res->message == 'User id tidak sesuai.' || $res->message == 'Layanan tidak ditemukan atau saat ini tidak tersedia.') {
                Pesanan::where('kode', $pesanan_kode)->update([
                    'status'    => 3,
                    'informasi' => $res->message,
    
                    'updated_by' => 'order',
                ]);

                if ($pesanan->voucher != NULL) {
                    Voucher::where('kode', $pesanan->voucher)->update([
                        'status'   => 1,

                        'updated_by' => 'order',
                    ]);
                }

                $details = [
                    'produk'       => $pesanan->produk,
                    'layanan'      => $pesanan->layanan,
                    'pesanan_kode' => $pesanan_kode,
                    'status'       => Helper::statusPesanan(3)['status'],
                    'informasi'    => $res->message,
                ];
                
                \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                activity('order')
                    ->event('Berhasil')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Order Berhasil (Status Gagal), Kode Pesanan: '.$pesanan_kode);
            } else {
                // Log::info(json_encode($res, true));

                activity('order')
                    ->event('Gagal')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Order Gagal, Kode Pesanan: '.$pesanan_kode);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('order')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Order Gagal (2), Kode Pesanan: '.$pesanan_kode);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('order')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Order Gagal (3), Kode Pesanan: '.$pesanan_kode);
        }
    }

    public function orderPPOB($pesanan_kode, $pid, $target)
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/prepaid', [
                'form_params' => [
                    'key'     => $this->api_key,
                    'sign'    => $signature,
                    'type'    => 'order',
                    'service' => $pid,
                    
                    'data_no'   => $target,
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));

            $pesanan = Pesanan::where('kode', $pesanan_kode)->first();
            if ($res->result == true) {
                Pesanan::where('kode', $pesanan_kode)->update([
                    'status'   => 5,
                    'pid'      => $res->data->trxid,

                    'updated_by' => 'order-ppob',
                ]);

                activity('order-ppob')
                    ->event('Berhasil')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'pid' => $res->data->trxid])
                    ->log('Order PPOB Berhasil, Kode Pesanan: '.$pesanan_kode);
            } else if ($res->message == 'User id tidak sesuai.' || $res->message == 'Layanan tidak ditemukan atau saat ini tidak tersedia.') {
                Pesanan::where('kode', $pesanan_kode)->update([
                    'status'    => 3,
                    'informasi' => $res->message,
    
                    'updated_by' => 'order-ppob',
                ]);

                if ($pesanan->voucher != NULL) {
                    Voucher::where('kode', $pesanan->voucher)->update([
                        'status'   => 1,

                        'updated_by' => 'order-ppob',
                    ]);
                }

                $details = [
                    'produk'       => $pesanan->produk,
                    'layanan'      => $pesanan->layanan,
                    'pesanan_kode' => $pesanan_kode,
                    'status'       => Helper::statusPesanan(3)['status'],
                    'informasi'    => $res->message,
                ];
                
                \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                activity('order-ppob')
                    ->event('Berhasil')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Order PPOB Berhasil (Status Gagal), Kode Pesanan: '.$pesanan_kode);
            } else {
                // Log::info(json_encode($res, true));

                activity('order-ppob')
                    ->event('Gagal')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Order PPOB Gagal, Kode Pesanan: '.$pesanan_kode);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('order')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Order PPOB Gagal (2), Kode Pesanan: '.$pesanan_kode);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('order')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Order PPOB Gagal (3), Kode Pesanan: '.$pesanan_kode);
        }
    }

    public function cekPesanan($pesanan_kode, $pid)
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'   => $this->api_key,
                    'sign'  => $signature,
                    'type'  => 'status',
                    'trxid' => $pid,
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));

            $pesanan = Pesanan::where('kode', $pesanan_kode)->first();            
            if ($res->result == true) {

                $informasi = $res->data[0]->note;

                if ($res->data[0]->status == 'success') {
                    Pesanan::where('kode', $pesanan_kode)->update([
                        'status'    => 6,
                        'informasi' => $informasi,
        
                        'updated_by' => 'cek-pesanan',
                    ]);

                    $details = [
                        'produk'       => $pesanan->produk,
                        'layanan'      => $pesanan->layanan,
                        'pesanan_kode' => $pesanan_kode,
                        'status'       => Helper::statusPesanan(6)['status'],
                        'informasi'    => $informasi,
                    ];
                    
                    \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                    activity('cek-pesanan')
                        ->event('Berhasil')
                        ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'informasi' => $informasi])
                        ->log('Cek Pesanan Berhasil, Kode Pesanan: '.$pesanan_kode);
                } else if ($res->data[0]->status == 'error') {
                    Pesanan::where('kode', $pesanan_kode)->update([
                        'status'    => 3,
                        'informasi' => $informasi,
        
                        'updated_by' => 'cek-pesanan',
                    ]);

                    if ($pesanan->voucher != NULL) {
                        Voucher::where('kode', $pesanan->voucher)->update([
                            'status'   => 1,

                            'updated_by' => 'cek-pesanan',
                        ]);
                    }

                    $details = [
                        'produk'       => $pesanan->produk,
                        'layanan'      => $pesanan->layanan,
                        'pesanan_kode' => $pesanan_kode,
                        'status'       => \Helper::statusPesanan(3)['status'],
                        'informasi'    => $informasi,
                    ];
                    
                    \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                    activity('cek-pesanan')
                        ->event('Berhasil')
                        ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'informasi' => $informasi])
                        ->log('Cek Pesanan Berhasil (Status Gagal), Kode Pesanan: '.$pesanan_kode);
                }
            } else {
                // Log::info(json_encode($res, true));

                activity('cek-pesanan')
                    ->event('Gagal')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Cek Pesanan Gagal, Kode Pesanan: '.$pesanan_kode);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('cek-pesanan')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Cek Pesanan Gagal (2), Kode Pesanan: '.$pesanan_kode);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('cek-pesanan')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Cek Pesanan Gagal (3), Kode Pesanan: '.$pesanan_kode);
        }
    }

    public function cekPesananPPOB($pesanan_kode, $pid)
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/prepaid', [
                'form_params' => [
                    'key'   => $this->api_key,
                    'sign'  => $signature,
                    'type'  => 'status',
                    'trxid' => $pid,
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));

            $pesanan = Pesanan::where('kode', $pesanan_kode)->first();
            if ($res->result == true) {

                $informasi = $res->data[0]->note;

                if ($res->data[0]->status == 'success') {
                    Pesanan::where('kode', $pesanan_kode)->update([
                        'status'    => 6,
                        'informasi' => $informasi,
        
                        'updated_by' => 'cek-pesanan-ppob',
                    ]);

                    $details = [
                        'produk'       => $pesanan->produk,
                        'layanan'      => $pesanan->layanan,
                        'pesanan_kode' => $pesanan_kode,
                        'status'       => Helper::statusPesanan(6)['status'],
                        'informasi'    => $informasi,
                    ];
                    
                    \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                    activity('cek-pesanan-ppob')
                        ->event('Berhasil')
                        ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'informasi' => $informasi])
                        ->log('Cek Pesanan PPOB Berhasil, Kode Pesanan: '.$pesanan_kode);
                } else if ($res->data[0]->status == 'error') {
                    Pesanan::where('kode', $pesanan_kode)->update([
                        'status'    => 3,
                        'informasi' => $informasi,
        
                        'updated_by' => 'cek-pesanan-ppob',
                    ]);

                    if ($pesanan->voucher != NULL) {
                        Voucher::where('kode', $pesanan->voucher)->update([
                            'status'   => 1,

                            'updated_by' => 'cek-pesanan-ppob',
                        ]);
                    }

                    $details = [
                        'produk'       => $pesanan->produk,
                        'layanan'      => $pesanan->layanan,
                        'pesanan_kode' => $pesanan_kode,
                        'status'       => \Helper::statusPesanan(3)['status'],
                        'informasi'    => $informasi,
                    ];
                    
                    \Mail::to($pesanan->email)->send(new \App\Mail\StatusPesananMail($details));

                    activity('cek-pesanan-ppob')
                        ->event('Berhasil')
                        ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message, 'informasi' => $informasi])
                        ->log('Cek Pesanan PPOB Berhasil (Status Gagal), Kode Pesanan: '.$pesanan_kode);
                }
            } else {
                // Log::info(json_encode($res, true));

                activity('cek-pesanan-ppob')
                    ->event('Gagal')
                    ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $res->message])
                    ->log('Cek Pesanan PPOB Gagal, Kode Pesanan: '.$pesanan_kode);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('cek-pesanan-ppob')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Cek Pesanan PPOB Gagal (2), Kode Pesanan: '.$pesanan_kode);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('cek-pesanan-ppob')
                ->event('Gagal')
                ->withProperties(['pesanan_kode' => $pesanan_kode, 'message' => $e->getMessage()])
                ->log('Cek Pesanan PPOB Gagal (3), Kode Pesanan: '.$pesanan_kode);
        }
    }
}