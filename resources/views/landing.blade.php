@extends('master')

@section('judul', '')

@section('konten')
{{-- <div id="pwa" class="pwa mx-auto p-3 mb-3">
    <div class="flex justify-center items-center">
        <div class="desc flex items-center">
            <i class="bi bi-phone mr-3" style="font-size: 1.5rem;"></i>
            <span class="text-xs ml-2 mr-3 w-full">Akses lebih cepat dengan aplikasi {{ \App\Helper::pengaturan('nama') }}. </span>
        </div>
        <a href="{{ strtolower(str_replace(' ', '', \App\Helper::pengaturan('nama'))) }}.apk" class="btn btn-primary rounded-md text-sm px-6 py-2 mr-3">
            Install
        </a>
        <i onclick="closeInstall()" class="bi bi-x-lg desc"></i>
    </div>
</div> --}}

<div class="container">
    
    <div class="containerBanner">
        <div class="swiper swiperBanner">
            <div class="swiper-wrapper">
                @php
                    $banners = DB::table('pengaturan')->where('config_type', 'banner')->get();
                @endphp
                @foreach ($banners as $banner)
                <div class="swiper-slide banner" style="width: 366px;">
                    <div class="banner-img" onclick="window.location.reload()">
                        <img src="{{ $banner->value }}" alt="">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @php
        $potongans = DB::table('potongan')->where('deleted', 0)->where('status', 1)->latest();
    @endphp

    @if ($potongans->count() > 0)
    <div class="containerFlashSale">
        <div class="headerFS">
            <div class="containers">
                <div class="title-head">Flash Sale</div>
                <img src="{{ url('storage') }}/images/icon/flash.svg" alt="" />
                {{-- <div class="time">
                    <div class="day">00</div>
                    <div class="dots">:</div>
                    <div class="hours">00</div>
                    <div class="dots">:</div>
                    <div class="minute">00</div>
                    <div class="dots">:</div>
                    <div class="second">00</div>
                </div> --}}
            </div>
            {{-- <div class="FSnav">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div> --}}
        </div>

        <div class="swiper swiperFlashSale">
            <div class="swiper-wrapper">
                @foreach ($potongans->get() as $potongan)
                @php
                    $layanan = DB::table('layanan')->where('id', $potongan->layanan_id)->first();
                    $produk  = DB::table('produk')->where('id', $layanan->produk_id)->first();
                @endphp
                <a href="{{ url('id') }}/{{ $produk->slug }}?id={{ $potongan->layanan_id }}" class="swiper-slide flashSale">
                    <img src="{{ $produk->gambar }}" alt="" />
                    <div class="mask"></div>
                    <div class="desc">
                        <div class="price">
                            <div class="titleFs">{{ $layanan->name }}</div>
                            <div class="realPrice">
                                <span class="rp">{{ \App\Helper::currency($potongan->harga) }}</span>
                            </div>
                            <div class="disc">{{ \App\Helper::currency($layanan->harga) }}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    @php
        $populers = DB::table('populer')->where('deleted', 0)->orderBy('urutan', 'ASC');
    @endphp

    @if ($populers->count() > 0)
    <div class="containerPopuler" id="produk">
        <div class="title-head">Game Populer</div>
        <div class="row g-2 g-lg-3">
            @foreach ($populers->get() as $populer)
            @php
                $produk = DB::table('produk')->where('id', $populer->produk_id)->first();
            @endphp
            <div class="col-lg-2 col-md-3 col-4 mb-lg-3 mb-md-2 col-sm-4">
                <div class="containers shadow">
                    <a href="{{ url('id') }}/{{ $produk->slug }}">
                        <div class="image">
                            <img src="{{ $produk->image }}" class="product-img" alt="" />
                        </div>
                        <div class="desc px-3">
                            <div class="game">{{ $produk->name }}</div>
                            <div class="vendor">{{ $produk->sub_name }}</div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @php
        $kategoris = DB::table('kategori')->where('deleted', 0)->orderBy('urutan', 'ASC');
    @endphp

    @if ($kategoris->count() > 0)
    <div class="containerProduct" id="produk">
        <ul class="nav navTabs" id="myTab" role="tablist">
            @foreach ($kategoris->get() as $kategori)
            <li class="nav-item" role="presentation">
                <button
                    class="btnNavTabs @if ($kategori->urutan == 1) active @endif"
                    id="{{ $kategori->slug }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#{{ $kategori->slug }}"
                    type="button"
                    role="tab"
                >
                    <div class="icon"><i class="{{ $kategori->icon }}"></i></div>
                    <div class="text">{{ $kategori->name }}</div>
                </button>
            </li>	
            @endforeach						
        </ul>

        <div class="tab-content" id="myTabContent">
            @foreach ($kategoris->get() as $kategori)
            <div class="tab-pane fade @if ($kategori->urutan == 1) show active @endif" id="{{ $kategori->slug }}" role="tabpanel" >
                <div class="row g-2 g-lg-3">
                    @php
                        $produks = DB::table('produk')->where('deleted', 0)->where('kategori_id', $kategori->id)->get();
                    @endphp
                    @foreach ($produks as $produk)
                    <div class="col-lg-2 col-md-3 col-4 mb-lg-3 mb-md-2 col-sm-4">
                        <div class="containers shadow">
                            <a href="{{ url('id') }}/{{ $produk->slug }}">
                                <img src="{{ $produk->image }}" class="product-img" alt="" />
                                <div class="mask"></div>
                                <div class="desc px-3">
                                    <div class="image justify-center mb-3">
                                        <img src="{{ \App\Helper::pengaturan('logo') }}" width="70" alt="" />
                                    </div>
                                    <div class="game">{{ $produk->name }}</div>
                                    <div class="vendor">{{ $produk->sub_name }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach		
                </div>
            </div>
            @endforeach	
        </div>
    </div>
    @endif
    
</div>

<div class="subContent">
    @include('layouts.testimoni')
    <div class="containerNews" id="faqs">
        <div class="container">
            <div class="head mb-3">
                <div class="title1">FAQ</div>
                <div class="title2">Frequently Asked Questions <img src="{{ url('storage') }}/images/icon/clink.png" alt=""></div>
                <div class="title3">"Beberapa Pertanyaan Yang Sering Ditanyakan Pengguna"</div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion mb-2">
                        <div class="accordionHeadPay" style="background: var(--dark-grey);">
                            <div class="title">Kenapa Harus Topup Di {{ \App\Helper::pengaturan('nama') }}</div>
                        </div>
                        <div class="accordionBodyPay shadow">
                            <div class="accordionContent">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title3"><p>Kamu dapat menemukan beragam pilihan jenis produk game populer. Mulai dari mobile game, PC game hingga konsol. Kamu juga dapat menemunkan berbagai produk digital seperti redeem code voucher dan aplikasi, paket pulsa hingga top up layanan langganan aplikasi.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="accordion mb-2">
                        <div class="accordionHeadPay" style="background: var(--dark-grey);">
                            <div class="title">Kenapa Harus Topup Di Alinea</div>
                        </div>
                        <div class="accordionBodyPay shadow">
                            <div class="accordionContent">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title3"><p>Kamu dapat menemukan beragam pilihan jenis produk game populer. Mulai dari mobile game, PC game hingga konsol. Kamu juga dapat menemunkan berbagai produk digital seperti redeem code voucher dan aplikasi, paket pulsa hingga top up layanan langganan aplikasi.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-2">
                        <div class="accordionHeadPay" style="background: var(--dark-grey);">
                            <div class="title">Kenapa Harus Topup Di Alinea</div>
                        </div>
                        <div class="accordionBodyPay shadow">
                            <div class="accordionContent">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title3"><p>Kamu dapat menemukan beragam pilihan jenis produk game populer. Mulai dari mobile game, PC game hingga konsol. Kamu juga dapat menemunkan berbagai produk digital seperti redeem code voucher dan aplikasi, paket pulsa hingga top up layanan langganan aplikasi.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-2">
                        <div class="accordionHeadPay" style="background: var(--dark-grey);">
                            <div class="title">Kenapa Harus Topup Di Alinea</div>
                        </div>
                        <div class="accordionBodyPay shadow">
                            <div class="accordionContent">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title3"><p>Kamu dapat menemukan beragam pilihan jenis produk game populer. Mulai dari mobile game, PC game hingga konsol. Kamu juga dapat menemunkan berbagai produk digital seperti redeem code voucher dan aplikasi, paket pulsa hingga top up layanan langganan aplikasi.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion mb-2">
                        <div class="accordionHeadPay" style="background: var(--dark-grey);">
                            <div class="title">Kenapa Harus Topup Di Alinea</div>
                        </div>
                        <div class="accordionBodyPay shadow">
                            <div class="accordionContent">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="title3"><p>Kamu dapat menemukan beragam pilihan jenis produk game populer. Mulai dari mobile game, PC game hingga konsol. Kamu juga dapat menemunkan berbagai produk digital seperti redeem code voucher dan aplikasi, paket pulsa hingga top up layanan langganan aplikasi.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $potongan_akhir = DB::table('potongan')->where('deleted', 0)->where('status', 1)->where('dari', '>=', date('Y-m-d H:i:s'))->orderBy('sampai', 'DESC')->first();
    $tgl_akhir = \Carbon\Carbon::parse($potongan_akhir->sampai??NULL)->format('Y-m-d');
@endphp

<script>
    // Set the date flash sale
    @if ($potongans->count() > 0)
        var countDownDate = new Date('{{ $tgl_akhir }}').getTime();
        const flasSale = document.querySelector('.containerFlashSale');
        if (flasSale) {
            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                var hours = Math.floor(
                    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
                ).toString().padStart(2, '0');
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');

                document.querySelector('.day').innerHTML = days;
                document.querySelector('.hours').innerHTML = hours;
                document.querySelector('.minute').innerHTML = minutes;
                document.querySelector('.second').innerHTML = seconds;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById('demo').innerHTML = 'EXPIRED';
                }
            }, 1000);
        }
    @endif
</script>
@endsection
