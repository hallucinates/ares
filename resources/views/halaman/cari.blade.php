@extends('master')

@section('judul', 'Daftar Harga')

@section('konten')
<div class="container">
    <div class="containerProduct">
        <div class="title-head mt-5">Pencarian <span class="txt-primary">"{{ request()->input('keyword') }}"</span></div>
            <div class="row g-2 g-lg-3">
                @foreach ($produks as $produk)
                <div class="col-lg-2 col-md-3 col-4 mb-lg-3 mb-md-2 col-sm-4">
                    <div class="containers shadow">
                        <a href="{{ url('id') }}/{{ $produk->slug }}">
                            <img src="{{ $produk->image }}" class="product-img" alt="" />
                            <div class="mask"></div>
                            <div class="desc">
                                <div class="game">{{ $produk->name }}</div>
                                <div class="vendor">{{ $produk->sub_name }}</div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="h-40"></div>
        <div class="h-40"></div>
    </div>
</div>
@endsection
