<?php

namespace App\Services\Vipayment;

use Illuminate\Support\Facades\Log;

use App\Models\MasterLayanan;

class LayananService
{
    private $api_id   = 'kBLtf2FP';
    private $api_key  = '6JAlPS3THehNcpSmvAU7HEb5OYdVFjvXbUzkX2ZEq71tMSklM27AN74cauwNK5QZ';  

    public function ambilLayanan()
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'   => $this->api_key,
                    'sign'  => $signature,
                    'type'  => 'services',

                    'filter_status' => 'available',
                ] 
            ]);

            $res = json_decode($req->getBody());
            // Log::info(json_encode($res, true));

            if ($res->result == true) {
                foreach ($res->data as $layanan) {

                    $pieces = explode('-', $layanan->code);
                    $m_code   = $pieces[0];
                    $m_server = $pieces[1]??NULL;

                    $cek = MasterLayanan::where('code', $layanan->code);
                    if ($cek->count() > 0) {
                        $cek = $cek->first();

                        $cek->update([
                            'm_code'        => $m_code,
                            'm_server'      => $m_server,
                            'code'          => $layanan->code,
                            'brand'         => $layanan->game,
                            'name'          => $layanan->name,
                            'price_basic'   => $layanan->price->basic,
                            'price_premium' => $layanan->price->premium,
                            'price_special' => $layanan->price->special,
                            'server'        => $layanan->server,
                            'status'        => $layanan->status,
                            'tipe'          => 1,
        
                            'updated_by' => 'ambil-layanan',
                        ]);
                    } else  {
                       MasterLayanan::create([
                            'm_code'        => $m_code,
                            'm_server'      => $m_server,
                            'code'          => $layanan->code,
                            'brand'         => $layanan->game,
                            'name'          => $layanan->name,
                            'price_basic'   => $layanan->price->basic,
                            'price_premium' => $layanan->price->premium,
                            'price_special' => $layanan->price->special,
                            'server'        => $layanan->server,
                            'status'        => $layanan->status,
                            'tipe'          => 1,
        
                            'created_by' => 'ambil-layanan',
                        ]);
                    }
                } 
                
                activity('ambil-layanan')
                    ->event('Berhasil')
                    ->withProperties(['message' => 'Berhasil'])
                    ->log('Ambil Layanan Berhasil');
            } else {
                Log::info(json_encode($res, true));

                activity('ambil-layanan')
                    ->event('Gagal')
                    ->withProperties(['message' => $res->message])
                    ->log('Ambil Layanan Gagal');
            } 
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('ambil-layanan')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ambil Layanan Gagal');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('ambil-layanan')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ambil Layanan Gagal (2)');
        }
    }

    public function ambilLayananPPOB()
    {
        $signature = md5($this->api_id . $this->api_key);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/prepaid', [
                'form_params' => [
                    'key'   => $this->api_key,
                    'sign'  => $signature,
                    'type'  => 'services',

                    'filter_status' => 'available',
                ] 
            ]);

            $res = json_decode($req->getBody());
            // Log::info(json_encode($res, true));

            if ($res->result == true) {
                foreach ($res->data as $layanan) {

                    $cek = MasterLayanan::where('code', $layanan->code);
                    if ($cek->count() > 0) {
                        $cek = $cek->first();

                        $cek->update([
                            'm_code'        => $layanan->code,
                            'code'          => $layanan->code,
                            'brand'         => $layanan->brand,
                            'name'          => $layanan->name,
                            'price_basic'   => $layanan->price->basic,
                            'price_premium' => $layanan->price->premium,
                            'price_special' => $layanan->price->special,
                            'status'        => $layanan->status,
                            'tipe'          => 2,
        
                            'updated_by' => 'ambil-layanan-ppob',
                        ]);
                    } else  {
                       MasterLayanan::create([
                            'm_code'        => $layanan->code,
                            'code'          => $layanan->code,
                            'brand'         => $layanan->brand,
                            'name'          => $layanan->name,
                            'price_basic'   => $layanan->price->basic,
                            'price_premium' => $layanan->price->premium,
                            'price_special' => $layanan->price->special,
                            'status'        => $layanan->status,
                            'tipe'          => 2,
        
                            'created_by' => 'ambil-layanan-ppob',
                        ]);
                    }
                }

                activity('ambil-layanan-ppob')
                    ->event('Berhasil')
                    ->withProperties(['message' => 'Berhasil'])
                    ->log('Ambil Layanan PPOB Berhasil');
            } else {
                Log::info(json_encode($res, true));

                activity('ambil-layanan-ppob')
                    ->event('Gagal')
                    ->withProperties(['message' => $res->message])
                    ->log('Ambil Layanan PPOB Gagal');
            }  
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning($e->getMessage());

            activity('ambil-layanan-ppob')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ambil Layanan PPOB Gagal');
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::warning($e->getMessage());

            activity('ambil-layanan-ppob')
                ->event('Gagal')
                ->withProperties(['message' => $e->getMessage()])
                ->log('Ambil Layanan PPOB Gagal (2)');
        }
    }
}