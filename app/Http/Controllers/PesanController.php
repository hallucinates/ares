<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Services\Midtrans\CreateSnapTokenService;

use App\Models\Produk;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\Voucher;
use App\Models\Kategori;

use App\Services\Vipayment\CekTargetService as CekTargetServiceVipayment;
use App\Services\Lfourr\CekTargetService as CekTargetServiceLfourr;

use App\Helper;

use Ramsey\Uuid\Uuid;

class PesanController extends Controller
{
    public function index($slug)
    {
        $produk = Produk::where('slug', $slug)->firstOrFail();
        return view('pesan.index', compact('produk'));
    }

    public function lacak(Request $request)
    {
        if ($request->pesanan_kode == '') {
            toastr()->error('Kode Pesanan belum diisi', 'Gagal!');
            return redirect('lacak-pesanan');
        } 

        $pesanan = Pesanan::where('kode', $request->pesanan_kode);
        if ($pesanan->count() < 1) {
            toastr()->error('Kode Pesanan tidak ditemukan', 'Gagal!');
            return redirect('lacak-pesanan');
        }

        return redirect('lacak-pesanan/'.$request->pesanan_kode);
    }

    public function cek(Request $request)
    {
        $produk = Produk::where('deleted', 0)->where('id', $request->id)->first();
        switch ($produk->cek_target) {
            case 1:
                return (new CekTargetServiceVipayment())->cekFreefire($request->all());
                break;

            case 2:
                return (new CekTargetServiceVipayment())->cekMobileLegends($request->all());
                break;

            case 3:
                return (new CekTargetServiceVipayment())->cekLOL($request->all());
                break;

            case 21:
                return (new CekTargetServiceLfourr())->cekDana($request->all());
                break;

            case 22:
                return (new CekTargetServiceLfourr())->cekShopeePay($request->all());
                break;

            default:
                return response()->json([
                    'status'  => true,
                    'hasil'   => '',
                    'message' => 'Silahkan lanjutkan pesanannya',
                ]);
                break;
        }
    }

    public function pesan(Request $request)
    {
        $layanan = Layanan::where('deleted', 0)->where('id', $request->layanan)->where('status', 1);  
        $pesanan = Pesanan::where('deleted', 0)->where('email', $request->email)->where('status', 1);  

        if ($layanan->count() < 1) {
            toastr()->error('Layanan tidak ditemukan', 'Gagal!');
            return back();
        }

        if ($pesanan->count() >= 3) {
            toastr()->error('Anda memiliki Pesanan yang belum diselesaikan', 'Gagal!');
            return back();
        }

        $layanan   = $layanan->first();
        $produk    = Produk::where('id', $layanan->produk_id)->first();
        $kategori  = Kategori::where('id', $layanan->kategori_id)->first();

        $voucher_id        = 0;
        $voucher_ketentuan = 0;
        $voucher_potongan  = 0;

        if ($request->voucher != '') {
            $voucher = Voucher::where('deleted', 0)->where('kode', $request->voucher)->where('status', 1)->oldest();

            if ($voucher->count() < 1) {
                toastr()->error('Voucher tidak ditemukan', 'Gagal!');
                return back();
            }

            $voucher = $voucher->first();

            $voucher_id        = $request->voucher_id;
            $voucher_ketentuan = $voucher->ketentuan;
            $voucher_potongan  = $voucher->potongan;

            if ($layanan->hj <= $voucher_ketentuan) {
                toastr()->error('Maaf, voucher ini tidak dapat digunakan sesuai dengan ketentuan yang berlaku', 'Gagal!');
                return back();
            }
        }

        $a = ($produk->fee / 100) * $layanan->hj;
        $total        = round($layanan->hj + $a - $voucher_potongan);
        $total_pure   = round($layanan->hj + $a);

        $pesanan_kode = Helper::generatePesananKode();
        $uuid         = Uuid::uuid4()->toString();

        $order = [
            'uuid'  => $uuid,
            'total' => $total,
            'name'  => $produk->name.' - '.$layanan->name,
            'email' => $request->email,
        ];
        $order = json_encode($order);
        
        DB::beginTransaction();
        try {

            try {
                $midtrans  = new CreateSnapTokenService($order);
                $snapToken = $midtrans->getSnapToken();

                Pesanan::create([
                    'kode' => $pesanan_kode,
    
                    'kategori' => $kategori->name,
                    'produk'   => $produk->name,

                    'layanan'        => $layanan->name,
                    'layanan_hj'     => $layanan->hj,
                    'layanan_hb'     => $layanan->hb,
                    'layanan_untung' => $layanan->hj - $layanan->hb,
                    'layanan_pid'    => $layanan->pid,

                    'target'       => $request->target,
                    'target2'      => $request->target2??NULL,
                    'target_hasil' => $request->target_hasil??NULL,
                    
                    'fee'        => $produk->fee,
                    'fee_hasil'  => $a,
                    'total'      => $total,
                    'total_pure' => $total_pure,

                    'voucher_id'        => $voucher_id,
                    'voucher'           => $request->voucher??NULL,
                    'voucher_ketentuan' => $voucher_ketentuan,
                    'voucher_potongan'  => $voucher_potongan,
                    
                    'tipe'  => $produk->tipe,
                    'email' => $request->email,
                    'uuid'  => $uuid,
                    'token' => $snapToken,
    
                    'created_by' => 'buat-pesanan',
                ]);

                Voucher::where('id', $voucher_id)->update([
                    'status' => 0,
        
                    'updated_by' => 'buat-pesanan',
                ]);

                activity('buat-pesanan')
                    ->event('Berhasil')
                    ->withProperties([
                        'ip' => $request->ip(), 
                        'ua' => $request->userAgent(), 
                        'ud' => Helper::isDevice(), 

                        'pesanan_kode' => $pesanan_kode,
                    ])
                    ->log('Buat Pesanan ('.$produk->name.') Berhasil');

                $details = [
                    'produk'        => $produk->name,
                    'layanan'       => $layanan->name,
                    'pesanan_kode'  => $pesanan_kode,
                ];
                
                \Mail::to($request->email)->send(new \App\Mail\BuatPesananMail($details));

                DB::commit();

                toastr()->success('Pesanan berhasil dibuat', 'Gotcha!');
                return redirect('lacak-pesanan/'.$pesanan_kode);
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
                activity('buat-pesanan')
                    ->event('Gagal')
                    ->withProperties([
                        'ip' => $request->ip(), 
                        'ua' => $request->userAgent(), 
                        'ud' => Helper::isDevice(),
                        'message' => $e->getMessage(),
                    ])
                    ->log('Buat Pesanan ('.$produk->name.') Gagal');

                DB::rollBack();
                Log::warning($e->getMessage());

                toastr()->error('Sistem sedang dalam perbaikan', 'Gagal!');
                return back();
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                activity('buat-pesanan')
                    ->event('Gagal')
                    ->withProperties([
                        'ip' => $request->ip(), 
                        'ua' => $request->userAgent(), 
                        'ud' => Helper::isDevice(),
                        'message' => $e->getMessage(),
                    ])
                    ->log('Buat Pesanan ('.$produk->name.') Gagal (2)');

                DB::rollBack();
                Log::warning($e->getMessage());

                toastr()->error('Sistem sedang dalam perbaikan', 'Gagal!');
                return back();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::warning($th->getMessage());

            activity('buat-pesanan')
                ->event('Gagal')
                ->withProperties([
                    'ip' => $request->ip(), 
                    'ua' => $request->userAgent(), 
                    'ud' => Helper::isDevice(),
                    'message' => $th->getMessage(),
                ])
                ->log('Buat Pesanan ('.$produk->name.') Gagal (3)');

            toastr()->error('Terjadi kesalahan, cobalah kembali', 'Gagal!');
            return back();
        }
    }
}
