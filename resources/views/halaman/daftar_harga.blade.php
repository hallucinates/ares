@extends('master')

@section('judul', 'Daftar Harga')

@section('konten')
<div class="container">
    <div class="desc mb-3">
        <span class="txt-primary">
            <a href="{{ url('/') }}">Halaman Utama</a>
        </span>
        <span class="mx-2">/</span>Daftar Harga           
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="title-head text-left mb-3 mt-3">Daftar Harga</div>
            <div class="cards shadow mb-4">
                <div class="nowrap-left floating-label-content">
                    <select class="form-select form-control floating-select" id="produk-select" onchange="go_section(this.value);">
                        @php
                            $produks   = DB::table('produk')->where('deleted', 0)->orderBy('name', 'ASC')->get();
                            $populer_1 = DB::table('populer')->where('deleted', 0)->where('urutan', 1)->first();
                        @endphp
                        @foreach ($produks as $produk)
                        <option value="{{ $produk->id }}" @selected($produk->id == $populer_1?->produk_id)>{{ $produk->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="tab-content mt-3">
                    @foreach ($produks as $produk)
                    <div class="tab-pane fade @if ($produk->id == $populer_1?->produk_id) show active @endif" id="produk-{{ $produk->id }}" role="tabpanel" >
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td colspan="4">
                                        <h6 class="cards-title pt-4">{{ $produk->name }}</h6>
                                    </td>
                                </tr>
                                <tr class="text-dark">
                                    <th>Layanan</th>
                                    <th nowrap="">Harga</th>
                                    <th width="10">Status</th>
                                </tr>
                                @php
                                    $layanans = DB::table('layanan')->where('deleted', 0)->where('produk_id', $produk->id)->orderBy('hj', 'ASC')->get();
                                @endphp
                                @foreach ($layanans as $layanan)
                                <tr class="text-dark">
                                    <td style="white-space: nowrap;">{{ $layanan->name }}</td>
                                    <td style="white-space: nowrap;">{{ App\Helper::currency($layanan->hj) }}</td>
                                    <td style="white-space: nowrap;">{!! App\Helper::statusLayanan($layanan->status) !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="h-40"></div>
        </div>
    </div>
</div>

<script>
    function go_section(id) {
        
        var buttons = document.querySelectorAll('.btnNavTabs');
        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        var activeButton = document.querySelector('.btnNavTabs[data-bs-target="#produk-' + id + '"]');
        if (activeButton) {
            activeButton.classList.add('active');
        }

        var tabs = document.querySelectorAll('.tab-pane');
        tabs.forEach(function(tab) {
            tab.classList.remove('show', 'active');
        });

        var activeTab = document.querySelector('#produk-' + id);
        if (activeTab) {
            activeTab.classList.add('show', 'active');
        }
    }
</script>
@endsection
