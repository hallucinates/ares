<?php

namespace App\Services\Vipayment;

use Illuminate\Support\Facades\Log;

use Request;

use App\Helper;

class CekTargetService
{
    private $api_id   = 'kBLtf2FP';
    private $api_key  = '6JAlPS3THehNcpSmvAU7HEb5OYdVFjvXbUzkX2ZEq71tMSklM27AN74cauwNK5QZ';  

    public function cekFreeFire($data)
    {
        $signature = md5($this->api_id . $this->api_key);
        $hasil     = '';

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'    => $this->api_key,
                    'sign'   => $signature,
                    'type'   => 'get-nickname',
                    'code'   => 'free-fire',
                    'target' => $data['target'],
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));
            
            if ($res->result == true && $res->data != '') {
                $hasil = $res->data;

                activity('cek-akun-game')
                    ->event('Berhasil')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'hasil' => $hasil])
                    ->log('Cek Akun Game (Free Fire) Berhasil, ID ditemukan');

                return response()->json([
                    'status'  => true,
                    'hasil'   => $hasil,
                    'message' => 'ID ditemukan',
                ]);
            } else {
                activity('cek-akun-game')
                    ->event('Gagal')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $res->message])
                    ->log('Cek Akun Game (Free Fire) Berhasil, ID Tidak Valid');

                return response()->json([
                    'status'  => false,
                    'hasil'   => $hasil,
                    'message' => 'ID Tidak Valid',
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun Game (Free Fire) Gagal');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun Game (Free Fire) Gagal (2)');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        }
    }

    public function cekMobileLegends($data)
    {
        $signature = md5($this->api_id . $this->api_key);
        $hasil     = '';

        $target  = explode(',', $data['target']);
        $target  = trim($target[0]);
        $target2 = trim($target[1]);

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'    => $this->api_key,
                    'sign'   => $signature,
                    'type'   => 'get-nickname',
                    'code'   => 'mobile-legends',
                    'target' => $target,

                    'additional_target' => $target2,
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));
            
            if ($res->result == true && $res->data != '') {
                $hasil = $res->data;

                activity('cek-akun-game')
                    ->event('Berhasil')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $target, 'target2' => $target2, 'hasil' => $hasil])
                    ->log('Cek Akun Game (Mobile Legends) Berhasil, ID ditemukan');

                return response()->json([
                    'status'  => true,
                    'hasil'   => $hasil,
                    'message' => 'ID ditemukan',
                ]);
            } else {
                activity('cek-akun-game')
                    ->event('Gagal')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $target, 'target2' => $target2, 'message' => $res->message])
                    ->log('Cek Akun Game (Mobile Legends) Berhasil, ID Tidak Valid');

                return response()->json([
                    'status'  => false,
                    'hasil'   => $hasil,
                    'message' => 'ID Tidak Valid',
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $target, 'target2' => $target2, 'message' => $e->getMessage()])
                ->log('Cek Akun Game (Mobile Legends) Gagal');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $target, 'target2' => $target2, 'message' => $e->getMessage()])
                ->log('Cek Akun Game (Mobile Legends) Gagal (2)');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        }
    }

    public function cekLOL($data)
    {
        $signature = md5($this->api_id . $this->api_key);
        $hasil     = '';

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('POST', 'https://vip-reseller.co.id/api/game-feature', [
                'form_params' => [
                    'key'    => $this->api_key,
                    'sign'   => $signature,
                    'type'   => 'get-nickname',
                    'code'   => 'league-of-legends-wild-rift',
                    'target' => $data['target'],
                ]
            ]);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));
            
            if ($res->result == true && $res->target != '') {
                $hasil = $res->target;

                activity('cek-akun-game')
                    ->event('Berhasil')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'hasil' => $hasil])
                    ->log('Cek Akun Game (LOL) Berhasil, ID ditemukan');

                return response()->json([
                    'status'  => true,
                    'hasil'   => $hasil,
                    'message' => 'ID ditemukan',
                ]);
            } else {
                activity('cek-akun-game')
                    ->event('Gagal')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $res->message])
                    ->log('Cek Akun Game (LOL) Berhasil, ID Tidak Valid');

                return response()->json([
                    'status'  => false,
                    'hasil'   => $hasil,
                    'message' => 'ID Tidak Valid',
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun Game (LOL) Gagal');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            activity('cek-akun-game')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun Game (LOL) Gagal (2)');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan ID sedang dalam perbaikan',
            ]);
        }
    }
}
