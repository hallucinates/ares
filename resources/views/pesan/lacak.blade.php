@extends('master')

@section('judul', 'Lacak Pesanan')

@section('konten')
<div class="container container-track overflow-hidden mb-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="containerTracking">
                <div class="head">
                    <div class="title">Cek Status Pesanan Kamu</div>
                </div>
                <div class="cardTrack">
                    <form method="POST" action="{{ url('lacak-pesanan') }}">
                        @csrf
                        <div class="floating-label-content">
                            <input type="text" class="form-control floating-input" value="{{ Request::segment(2) }}" name="pesanan_kode" placeholder="">
                            <label class="floating-label mb-1">Kode Pesanan</label>
                            <button type="submit" class="btnYellowPrimary py-3">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (Request::segment(2) != '')
        @php
            $pesanan = DB::table('pesanan')->where('kode', Request::segment(2))->first();
            $tujuan  = $pesanan->target;
            if ($pesanan->target2 != NULL) {
                $tujuan = $tujuan.' - '.$pesanan->target2;
            }
        @endphp
        <div class="row justify-content-center  position-relative">
            <div class="circle position-absolute top-50 start-0 translate-middle d-block d-lg-none"></div>
            <div class="circle position-absolute top-0 start-50 translate-middle d-none d-lg-block"></div>

            <div class="circle position-absolute top-50 start-100 translate-middle d-block d-lg-none"></div>
            <div class="circle position-absolute top-100 start-50 translate-middle d-none d-lg-block"></div>

            <div class="col-lg-6 col-12 receipt-left">
                <div class="ticketDetail">
                    <div class="head">Detail Pesanan</div>
                    <div class="containers">
                        <div class="title">Kode Pesanan</div>
                        <div class="desc">{{ $pesanan->kode }}                                        
                            <i class="bi bi-clipboard2" onclick="salin('{{ $pesanan->kode }}', 'Order ID berhasil disalin');"></i>
                        </div>
                    </div>
                    
                    <div class="containers">
                        <div class="title">Tujuan</div>
                        <div class="desc">{{ $tujuan }}</div>
                    </div>

                    <div class="containers">
                        <div class="title">Produk</div>
                        <div class="desc">{{ $pesanan->produk }}</div>
                    </div>
                    <div class="containers">
                        <div class="title">Layanan</div>
                        <div class="desc text-end">{{ $pesanan->layanan }}</div>
                    </div>
                                                    
                    @if ($pesanan->target_hasil != NULL)
                    <div class="containers">
                        <div class="title">Nickname</div>
                        <div class="desc">{{ $pesanan->target_hasil }}</div>
                    </div>
                    @endif
                    
                    <div class="containers">
                        <div class="title">Harga</div>
                        <div class="desc">{{ App\Helper::currency($pesanan->layanan_hj) }}</div>
                    </div>
                    <div class="containers">
                        <div class="title">Fee</div>
                        <div class="desc">{{ App\Helper::currency($pesanan->fee_hasil) }}</div>
                    </div>

                    @if ($pesanan->voucher_potongan != 0)
                    <div class="containers">
                        <div class="title">Potongan</div>
                        <div class="desc">- {{ \Helper::currency($pesanan->voucher_potongan) }}</div>
                    </div>
                    @endif

                    <div class="containers">
                        <div class="title">Status</div>
                        <div class="desc {{ App\Helper::statusPesanan($pesanan->status)['color'] }}">
                            {{ App\Helper::statusPesanan($pesanan->status)['status'] }}                              
                        </div>
                    </div>
                    <div class="containers">
                        <div class="title">Keterangan</div>
                        <div class="desc">{{ App\Helper::statusPesanan($pesanan->status)['ket'] }}</div>
                    </div>

                    @if ($pesanan->informasi != NULL)
                    @php
                        $hitung_informasi = strlen($pesanan->informasi);
                        if ($hitung_informasi < 25) {
                            $informasi = $pesanan->informasi;
                        } else {
                            $informasi = substr($pesanan->informasi, 0, 25).' ...';
                        }
                    @endphp
                    <div class="containers">
                        <div class="title">Informasi</div>
                        <div class="desc">{{ $informasi }}</div>
                    </div>
                    @endif

                    <div class="containers">
                        <div class="title">Tanggal</div>
                        <div class="desc">{{ App\Helper::tanggalIndo($pesanan->created_at) }}</div>
                    </div>

                    <div class="containers">
                        <div class="title">Total</div>
                        <div class="desc txt-primary">{{ App\Helper::currency($pesanan->total) }}
                            <i class="bi bi-clipboard2" onclick="salin('{{ $pesanan->total }}', 'Total berhasil disalin');"></i>
                        </div>
                    </div>

                    <div class="containers">
                        <div class="title">Email</div>
                        <div class="desc">{{ $pesanan->email }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-12 receipt-right">
                <div class="ticketBarcode page">
                    <div class="gameNm">{{ $pesanan->produk }}</div>
                    <div class="diamond">{{ $pesanan->layanan }}</div>
                    <div class="price"> 
                        <span class="{{ App\Helper::statusPesanan($pesanan->status)['color'] }}">{{ App\Helper::currency($pesanan->total) }}</span>                                
                    </div>
                    
                    <img src="{{ url('storage') }}/{{ App\Helper::statusPesanan($pesanan->status)['icon'] }}" alt="" class="status">
                    @if ($pesanan->status == 1)
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btnYellowPrimary w-100 mt-4"  onclick="bayarSekarang();">Bayar Sekarang</button>
                        </div>
                        <div class="offset-lg-5 col-lg-7">
                            <form method="POST" action="{{ url('ganti-pembayaran/'.$pesanan->kode) }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mt-4">Ganti Pembayaran</button>
                            </form>
                        </div>
                    </div>
                    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
                    <script>
                        function bayarSekarang() {
                            snap.pay('{{ $pesanan->token }}', {
                                // Optional
                                onSuccess: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result);
                                    location.reload();
                                },
                                // Optional
                                onPending: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result)
                                },
                                // Optional
                                onError: function(result) {
                                    /* You may add your own js here, this is just example */
                                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                                    // console.log(result)
                                }
                            });
                        }
                    </script>
                    @else
                    <div class="desc mb-5">
                        <div class="gameNm text-center">{{ App\Helper::statusPesanan($pesanan->status)['tr'] }}</div>
                    </div>
                    @if ($pesanan->status == 4 || $pesanan->status == 5)
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{ url('cek-pesanan') }}" class="btn btn-success w-100 mt-4">Cek Pesanan</a>
                        </div>
                    </div>
                    @endif
                    @endif      
                </div>
            </div>
        </div>

        @php
            $testimoni = DB::table('testimoni')->where('pesanan_kode', $pesanan->kode)->count();
        @endphp

        @if ($pesanan->status == 6 && $testimoni == 0)
        <div class="modal fade" id="modal-testimoni">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content pt-5 pb-4" style="border-radius:20px">
                    <form method="POST" action="{{ url('testimoni/'.$pesanan->kode) }}">
                        @csrf
                        <div class="containerRate">
                            <img src="{{ App\Helper::pengaturan('logo') }}" alt="" class="logo">
                            <div class="title">Kirim Ulasan Anda</div>  
                            <div class="emoji">
                                <input type="hidden" name="bintang" class="emoji-radio">
                                <div class="containers" style="font-size: 3rem !important;">
                                    <i onclick="hover_bintang('1');" id="bintang-1" class="bi bi-star text-gray cursor-pointer"></i>
                                </div>
                                <div class="containers" style="font-size: 3rem !important;">
                                    <i onclick="hover_bintang('2');" id="bintang-2" class="bi bi-star text-gray cursor-pointer"></i>
                                </div>
                                <div class="containers" style="font-size: 3rem !important;">
                                    <i onclick="hover_bintang('3');" id="bintang-3" class="bi bi-star text-gray cursor-pointer"></i>
                                </div>
                                <div class="containers" style="font-size: 3rem !important;">
                                    <i onclick="hover_bintang('4');" id="bintang-4" class="bi bi-star text-gray cursor-pointer"></i>
                                </div>
                                <div class="containers" style="font-size: 3rem !important;">
                                    <i onclick="hover_bintang('5');" id="bintang-5" class="bi bi-star text-gray cursor-pointer"></i>
                                </div>
                            </div>
                            <div class="floating-label-content mb-lg-3 mb-md-2">
                                <textarea class="form-control floating-input" name="ulasan" id="ulasan" placeholder=" " style="min-height:140px"></textarea>
                                <label class="floating-label" for="ulasan">Tulis Ulasan Kamu</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <button type="submit" class="btnYellowPrimary w-100 py-4">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <button type="button" class="btnYellowPrimary w-100" onclick="showTestimoni()">Kirim Rating</button>
            </div>
        </div>
        <script>
            function hover_bintang(bintang) {
                $('input[name=bintang]').val(bintang);
                $('.bi.bi-star').removeClass('txt-primary');
        
                for (var i = 1; i <= bintang; i++) {
                    $('#bintang-' + i).addClass('txt-primary');
                }
            }
        
            var modal_testimoni = new bootstrap.Modal(document.getElementById('modal-testimoni'));
        
            function showTestimoni() {
                modal_testimoni.show();
            }
        </script>
        @endif
        
        @if ($pesanan->status == 1 || $pesanan->status == 6)
        <div class="row justify-content-center mt-3">
            <div class="col-lg-10">
                <div class="notes">
                    <div class="text">Note:</div>
                    <div class="text2">{{ App\Helper::statusPesanan($pesanan->status)['note'] }}</div>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
    <div class="h-40"></div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="title-head mb-3">10 Pesanan Terakhir</div>
            <div class="cards shadow mb-4">
                <div class="table-responsive">
                    <table class="table">
                        <tr class="text-dark">
                            <th>TANGGAL</th>
                            <th nowrap="">KODE PESANAN</th>
                            <th nowrap="">PRODUK</th>
                            <th nowrap="">LAYANAN</th>
                            <th nowrap="">NOMINAL</th>
                            <th width="10">STATUS</th>
                        </tr>
                        @php
                            $pesanan_terakhirs = DB::table('pesanan')->limit(10)->latest()->get();
                        @endphp
                        @forelse ($pesanan_terakhirs as $pesanan_terakhir)
                        @php
                            $hitung_lay = strlen($pesanan_terakhir->layanan);
                            if ($hitung_lay < 25) {
                                $layanan = $pesanan_terakhir->layanan;
                            } else {
                                $layanan = substr($pesanan_terakhir->layanan, 0, 25).' ...';
                            }
                            
                            if ($pesanan_terakhir->status == 1) {
                                $status_pt = 5;
                            } else {
                                $status_pt = $pesanan_terakhir->status; 
                            }
                        @endphp
                        <tr class="text-dark">
                            <td style="white-space: nowrap;">{{ App\Helper::tanggalIndoWithJam($pesanan_terakhir->created_at) }}</td>
                            <td style="white-space: nowrap;">{{ App\Helper::stringToSecret($pesanan_terakhir->kode) }}</td>
                            <td style="white-space: nowrap;">{{ $pesanan_terakhir->produk }}</td>
                            <td style="white-space: nowrap;">{{ $layanan }}</td>
                            <td style="white-space: nowrap;">{!! App\Helper::currency($pesanan_terakhir->total) !!}</td>
                            <td style="white-space: nowrap;">
                                <span class="{{ App\Helper::statusPesanan($pesanan_terakhir->status)['color'] }}">{{ App\Helper::statusPesanan($pesanan_terakhir->status)['status'] }}</span>                    
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="subContent">
    @include('layouts.testimoni')
</div>
@endsection