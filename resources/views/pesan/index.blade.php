@extends('master')

@section('judul', $produk->name)

@section('konten')
<div class="container">
    <div class="desc mb-3">
        <span class="txt-primary">
            <a href="{{ url('/') }}">Home</a>
        </span>
        <span class="mx-2">/</span>{{ $produk->name }}              
    </div>
    <div class="containerAlpha">
        <img src="{{ $produk->banner }}" alt="" class="banner">
        <div class="containerML">
            <img src="{{ $produk->icon }}" alt="" class="logo-ml">
        </div>
    </div>
    <form method="POST" action="{{ url('pesan') }}" id="form-order">
        @csrf
        <input type="hidden" name="layanan">
        <input type="hidden" name="metode">
        <input type="hidden" name="target_hasil">
        
        <div class="containerNominal">
            <div class="row reverse">
                
                <div class="col-lg-8">
                    <div class="cards py-3 mb-4">
                        <div class="title-card text-left">{{ $produk->name }}<span class="ms-2"><i class="bi bi-patch-check-fill" style="color: #179cf0"></i></span></div>

                        <div class="text" style="color: var(--black-text)">
                            <p>
                                {{-- {!! $produk->deskripsi !!} --}}
                                {!! nl2br(e($produk->deskripsi)) !!}
                            </p>
                            <p>Download dan mainkan {{ $produk->name }} sekarang!<br>
                                <a href="https://www.apple.com/us/search/{{ $produk->name }}?src=globalnav" rel="noopener" target="_blank">
                                <img class="mt-3" src="{{ url('storage') }}/images/icon/apple.png" width="120" alt="Download on the App Store"></a>
                                <a href="https://play.google.com/store/search?q={{ $produk->name }}" rel="noopener" target="_blank">
                                <img class="mt-3" src="{{ url('storage') }}/images/icon/google-play-badge.png" width="120" alt="Download on Google Play"></a>
                            </p>
                        </div>
                    </div>
                    <div class="cards py-3 mb-4">
                        <div class="title-card text-left" style="margin-bottom: 2rem;">Pilih Nominal</div>
                        @php
                            $labels = DB::table('label')->where('deleted', 0)->where('produk_id', $produk->id)->orderBy('urutan', 'ASC');
                        @endphp
                        @if ($labels->count() < 1)
                        <div class="row justify-content-center notfound">
                            <div class="col-12 col-md-6">
                                <div class="d-flex flex-column gap-3">
                                    <img src="{{ url('storage') }}/images/icon/maintenance.svg" class="mx-auto" alt="">
                                    <span class="head">Oops.!</span>
                                    <span class="title text-center">Layanan sedang kami siapkan</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            @foreach ($labels->get() as $label)
                            @php
                                $layanans = DB::table('layanan')->where('deleted', 0)->where('status', 1)->where('label_id', $label->id)->orderBy('hj', 'ASC');
                            @endphp
                            @if ($layanans->count() > 0)
                            <div class="desc mb-2">{{ $label->name }}</div>
                            @foreach ($layanans->get() as $layanan)
                            <div class="col-md-4 col-6">
                                <input type="radio" name="layanan" id="layanan-{{ $layanan->id }}" onchange="selectLayanan('{{ $layanan->id }}', '{{ $layanan->name }}', '{{ App\Helper::currency($layanan->hj) }}');" class="nom-radio" />
                                <label for="layanan-{{ $layanan->id }}" class="containerChoice">
                                    <div class="containerIcon" hidden>
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div class="mx-auto">
                                        @if ($label->image != NULL)
                                        <img src="{{ $label->image }}" width="30" alt="" class="justify-center mx-auto mb-2" />
                                        @endif
                                        <div class="text">
                                            <div class="desc">{{ $layanan->name }}</div>
                                            <div class="count">
                                                {{ App\Helper::currency($layanan->hj) }}		
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="accordion">
                        <div class="cards mb-4 d-flex flex-column gap-3" id="section-method">
                             
                            <div class="title-card text-left">Masukkan Data Akun</div>
                                
                            <div class="floating-label-content">
                                <input type="text" class="form-control games-input floating-input" name="target" id="target" placeholder="" />
                                <label class="floating-label mb-1">{{ $produk->placeholder }}</label>
                            </div>
                            
                            @if ($produk->placeholder2 != NULL)
                            <div class="floating-label-content">
                                <input type="text" class="form-control games-input floating-input" name="target2" id="target2" placeholder="" />
                                <label class="floating-label mb-1">{{ $produk->placeholder2 }}</label>
                            </div>
                            @endif
                            
                            {{-- <div class="note">{!! $produk->catatan !!}</div> --}}
                            <div class="note">{!! nl2br(e($produk->catatan)) !!}</div>
                        </div>
                        
                        <div class="cards mb-4 d-flex flex-column gap-3">
                            <div class="title-card text-left">Promo Kode</div>
                            <div class="floating-label-content">
                                <input type="text" class="form-control floating-input" name="voucher" id="voucher" placeholder="" />
                                <button class="btnYellowPrimary my-3 w-100" type="button" onclick="cekVoucher();">Cek Kode Promo</button>
                                <label class="floating-label mb-1">Optional</label>
                                <span class="ic--baseline-content-cut"></span>
                            </div>
                            <div class="potongan" style="display: none;">
                                <div class="text-center"><i class="bi bi-tag-fill" style="color: #179cf0"></i> <span id="potongan">Rp. 0</span></div>
                            </div>
                        </div>

                        <div class="cards mb-4 d-flex flex-column gap-3" id="section-method">
                            <div class="title-card text-left">Detail Kontak</div>
                            <div class="floating-label-content">
                                <input type="email" class="form-control floating-input" name="email" id="email" placeholder="" value="" />
                                <label class="floating-label mb-1">Email</label>
                                <div class="note">*Status transaksi akan dikirim via email</div>
                            </div>
                            {{-- <div class="floating-label-content">
                                <input type="no_hp" class="form-control floating-input" name="no_hp" id="no_hp" placeholder="" value="" />
                                <label class="floating-label mb-1">No. HP</label>
                            </div> --}}
                            <div>
                                <input type="hidden" name="tombol" value="submit"/>
                                <button type="button" onclick="confirm();" id="btn-confirm" class="btnYellowPrimary w-100 mt-2">
                                    Konfirmasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-40"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:600px">
        <div class="modal-content py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="ticketDetail page">
                        <div class="head text-center">Detail Pesanan</div>
                        <div class="containers">
                            <div class="title">Tujuan</div>
                            <div class="desc" id="tujuan">-</div>
                        </div>
                        <div class="containers" id="hasil-view" style="display: none;">
                            <div class="title">Hasil Tujuan</div>
                            <div class="desc" id="hasil">-</div>
                        </div>
                        <div class="containers">
                            <div class="title">Produk</div>
                            <div class="desc" id="produk">{{ $produk->name }}</div>
                        </div>
                        <div class="containers">
                            <div class="title">Layanan</div>
                            <div class="desc" id="layanan"></div>
                        </div>
                        <div class="containers">
                            <div class="title">Harga</div>
                            <div class="desc" id="harga"></div>
                        </div>
                        <div class="containers">
                            <div class="title">Fee</div>
                            <div class="desc" id="fee"></div>
                        </div>
                        <div class="containers" id="potongan-view" style="display: none;">
                            <div class="title">Potongan</div>
                            <div class="desc" id="pot">- Rp. 0</div>
                        </div>
                        <div class="containers">
                            <div class="title">Total</div>
                            <div class="desc" id="total_bayar"></div>
                        </div>
                        <div class="containers">
                            <div class="title">Email</div>
                            <div class="desc" id="email2"></div>
                        </div>
                        <button type="button" onclick="process()" id="btn-order-process" class="btnYellowPrimary w-100 mt-3" >
                            Bayar Sekarang
                        </button>
                        <button type="button" onclick="cancel()" class="btnGrey w-100 mt-2">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pesan.js.index')
@endsection
