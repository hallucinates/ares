<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pesanan;

use App\Services\Midtrans\CallbackService;
 
class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
 
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            $pesanan = Pesanan::where('kode', $order->kode)->first();
 
            if ($callback->isSuccess()) {
                Pesanan::where('kode', $order->kode)->update([
                    'status' => 4,

                    'updated_by' => 'receive',
                ]);

                \Artisan::call('app:ambil-master-layanan');
                \Artisan::call('app:cek-status-layanan');
                
                \Artisan::call('app:order-pesanan');
                \Artisan::call('app:cek-status-pesanan');
            }
 
            if ($callback->isExpire()) {
                Pesanan::where('kode', $order->kode)->update([
                    'payment_status' => 2,

                    'updated_by' => 'receive',
                ]);

                if ($pesanan->voucher != NULL) {
                    Voucher::where('kode', $pesanan->voucher)->update([
                        'status'   => 1,

                        'updated_by' => 'receive',
                    ]);
                }
            }
 
            if ($callback->isCancelled()) {
                Pesanan::where('kode', $order->kode)->update([
                    'payment_status' => 2,

                    'updated_by' => 'receive',
                ]);

                if ($pesanan->voucher != NULL) {
                    Voucher::where('kode', $pesanan->voucher)->update([
                        'status'   => 1,

                        'updated_by' => 'receive',
                    ]);
                }
            }
 
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}