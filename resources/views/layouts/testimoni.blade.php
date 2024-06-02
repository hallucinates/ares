<div class="containerTestimoni">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="trusted-text">Dipercaya oleh ribuan pengguna</div>
                <div class="desc-text">{{ App\Helper::pengaturan('nama') }} dipercaya oleh Para gamers profesional </div>
                <div class="subdesc-text">{{ App\Helper::pengaturan('deskripsi') }}</div>
                @php
                    $testimoni = DB::table('testimoni')->count();
                    $produk    = DB::table('produk')->where('deleted', 0)->count();
                    $layanan   = DB::table('layanan')->where('deleted', 0)->count();
                    $pesanan   = DB::table('pesanan')->count();

                    if ($testimoni > 999) {
                        $testimoni = 999;
                    }

                    if ($testimoni == 0) {
                        $testimoni = 1;
                    }

                    if ($produk > 999) {
                        $produk = 999;
                    }

                    if ($produk == 0) {
                        $produk = 1;
                    }

                    if ($layanan > 999) {
                        $layanan = 999;
                    }

                    if ($layanan == 0) {
                        $layanan = 1;
                    }

                    if ($pesanan > 999) {
                        $pesanan = 999;
                    }

                    if ($pesanan == 0) {
                        $pesanan = 1;
                    }
                @endphp
                <div class="containerUsers mb-lg-3 mb-md-2">
                    <div class="containers">
                        <div class="count">{{ App\Helper::number($produk) }}+</div>
                        <div class="title">Produk</div>
                    </div>
                    <div class="containers">
                        <div class="count">{{ App\Helper::number($layanan) }}+</div>
                        <div class="title">Layanan</div>
                    </div>
                    <div class="containers">
                        <div class="count">{{ App\Helper::number($pesanan) }}+</div>
                        <div class="title">Pesanan</div>
                    </div>
                    <div class="containers">
                        <div class="count">{{ App\Helper::number($testimoni) }}+</div>
                        <div class="title">Testimoni</div>
                    </div>
                </div>
                <a href="#" class="btnYellowPrimary d-inline-flex px-3 mt-4">Topup Sekarang<i class="bi bi-arrow-right-short ms-2 mt-1"></i></a>
            </div>
            <div class="col-lg-7">
                <div class="swiper swiperTesti">
                    <div class="swiper-wrapper">
                        @php
                            $testimonis = DB::table('testimoni')->latest()->get();
                        @endphp
                        @foreach ($testimonis as $testimoni)
                        @php
                            $email = substr($testimoni->email, 0, 2);

                            $hitung_produk = strlen($testimoni->produk);
                            if ($hitung_produk < 15) {
                                $tes_produk = $testimoni->produk;
                            } else {
                                $tes_produk = substr($testimoni->produk, 0, 15).' ...';
                            }
                        @endphp
                        <div class="swiper-slide testimoni">
                            <div class="cards">
                                <div class="containers">
                                    <div class="rate">
                                        @for ($i = 1; $i <= $testimoni->bintang; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                    </div>
                                    <div class="gameNm">{{ $tes_produk }}</div>
                                    <div class="desc">{{ $testimoni->ulasan }}</div>
                                    <div class="name">{{ $email }}******.com</div>
                                    <div class="contentBot">
                                        <div class="invoice text-sm">
                                            {{ App\Helper::stringToSecret($testimoni->pesanan_kode) }}													
                                        </div>
                                        <div class="invoice text-sm">{{ App\Helper::tanggalIndo($testimoni->created_at) }}	</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>