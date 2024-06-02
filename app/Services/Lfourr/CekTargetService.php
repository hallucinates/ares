<?php

namespace App\Services\Lfourr;

use Illuminate\Support\Facades\Log;

use Request;

use App\Helper;

class CekTargetService
{
    public function cekDana($data)
    {
        $hasil = '';

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('GET', 'https://api-rekening.lfourr.com/getEwalletAccount?bankCode=DANA&accountNumber='.$data['target']);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));
            
            if ($res->status == true && !is_numeric($res->data->accountname)) {
                $hasil = $res->data->accountname;

                activity('cek-akun-e-money')
                    ->event('Berhasil')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'hasil' => $hasil])
                    ->log('Cek Akun E-Money (DANA) Berhasil, Tujuan ditemukan');

                return response()->json([
                    'status'  => true,
                    'hasil'   => $hasil,
                    'message' => 'Tujuan ditemukan',
                ]);
            } else {
                activity('cek-akun-e-money')
                    ->event('Gagal')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $res->msg])
                    ->log('Cek Akun E-Money (DANA) Berhasil, Tujuan Tidak Valid');

                return response()->json([
                    'status'  => false,
                    'hasil'   => $hasil,
                    'message' => 'Tujuan Tidak Valid',
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
             activity('cek-akun-e-money')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun E-Money (DANA) Gagal');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan Tujuan sedang dalam perbaikan',
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
             activity('cek-akun-e-money')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun E-Money (DANA) Gagal (2)');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan Tujuan sedang dalam perbaikan',
            ]);
        }
    }

    public function cekShopeepay($data)
    {
        $hasil = '';

        try {
            $client = new \GuzzleHttp\Client();
            $req    = $client->request('GET', 'https://api-rekening.lfourr.com/getEwalletAccount?bankCode=SHOPEEPAY&accountNumber='.$data['target']);

            $res = json_decode($req->getBody());
            Log::info(json_encode($res, true));
            
            if ($res->status == true && !is_numeric($res->data->accountname)) {
                $hasil = $res->data->accountname;

                activity('cek-akun-e-money')
                    ->event('Berhasil')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'hasil' => $hasil])
                    ->log('Cek Akun E-Money (ShopeePay) Berhasil, Tujuan ditemukan');

                return response()->json([
                    'status'  => true,
                    'hasil'   => $hasil,
                    'message' => 'Tujuan ditemukan',
                ]);
            } else {
                activity('cek-akun-e-money')
                    ->event('Gagal')
                    ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $res->msg])
                    ->log('Cek Akun E-Money (ShopeePay) Berhasil, Tujuan Tidak Valid');

                return response()->json([
                    'status'  => false,
                    'hasil'   => $hasil,
                    'message' => 'Tujuan Tidak Valid',
                ]);
            }
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
             activity('cek-akun-e-money')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun E-Money (ShopeePay) Gagal');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan Tujuan sedang dalam perbaikan',
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
             activity('cek-akun-e-money')
                ->event('Gagal')
                ->withProperties(['ip' => Request::ip(), 'ua' => Request::userAgent(), 'ud' => Helper::isDevice(), 'target' => $data['target'], 'message' => $e->getMessage()])
                ->log('Cek Akun E-Money (ShopeePay) Gagal (2)');

            Log::warning($e->getMessage());

            return response()->json([
                'status'  => true,
                'hasil'   => $hasil,
                'message' => 'Pengecekan Tujuan sedang dalam perbaikan',
            ]);
        }
    }
}
