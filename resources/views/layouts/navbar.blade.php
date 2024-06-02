<button class="btn btn-primary d-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas"></button>

<div class="offcanvas offcanvas-start" style="z-index : 100 !important" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <div class="d-flex align-items-center gap-2">
            <span class="navigation">Navigation</span>
        </div>
        <label class="theme-switch">
            <input class="toggle-checkbox" id="checkbox" type="checkbox">
            <div class="switch-icon">
                <i class="bi bi-brightness-high yellowprim"></i>
            </div>
        </label>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
        <div class="link-list">
            <a href="{{ url('/') }}" class="nav-item-link active">
                <div class="icon-link">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <div class="title">Halaman Utama</div>
            </a>
            <a href="{{ url('daftar-harga') }}" class="nav-item-link ">
                <div class="icon-link">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <div class="title">Daftar Harga</div>
            </a>
            <a href="{{ url('lacak-pesanan') }}" class="nav-item-link ">
                <div class="icon-link">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="title">Lacak Pesanan</div>
            </a>
            <a href="{{ url('kalkulator') }}" class="nav-item-link ">
                <div class="icon-link">
                    <i class="bi bi-calculator-fill"></i>
                </div>
                <div class="title">Kalkulator</div>
            </a>
            <a href="{{ url('blog') }}" class="nav-item-link ">
                <div class="icon-link">
                    <i class="bi bi-newspaper"></i>
                </div>
                <div class="title">Artikel</div>
            </a>
        </div>
        {{-- <div class=" flex align-content-end">
            <div class="d-flex gap-2 w-100">
                <a type="button" href="{{ url('login') }}" class="btnYellowPrimary d-inline-flex flex-fill px-3 w-100">Login</a>
                <a type="button" href="{{ url('register') }}" class="btnYellowSecond d-inline-flex flex-fill px-3 w-100">Register</a>
            </div>
        </div> --}}
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container position-relative justify-content-md-center ">
        <button class="search d-md-none d-block" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-search"></i>
        </button>
        @php
            $agent = new Jenssegers\Agent\Agent();
            if ($agent->isMobile()) {
                $device = 'Mobile';
            } else if ($agent->isDesktop()) {
                $device = 'Desktop';
            } else {
                $device = 'unknown';
            }
        @endphp
        @if ($device == 'Mobile') 
        <div class="d-flex align-items-center gap-2" id="navLogo">
            <img src="{{ \App\Helper::pengaturan('logo') }}" onclick="window.location.href = '{{ url('/') }}'" class="logo " alt="">
            {{-- <span class="logoName">{{ \App\Helper::pengaturan('nama') }}</span> --}}
        </div>
        @else
        <div class="d-flex align-items-center gap-2" style="width: 70%;" id="navLogo">
            <img src="{{ \App\Helper::pengaturan('logo') }}" onclick="window.location.href = '{{ url('/') }}'" class="logo " alt="">
            <span class="logoName">{{ \App\Helper::pengaturan('nama') }}</span>
        </div>
        @endif

        <div class="collapse navbar-collapse order-2 " id="navbarNavDropdown">
            <div class="py-3  d-flex d-md-none " id="navSearch">
                <form action="{{ url('cari') }}" method="GET" class=" w-100">
                    <div class="navSearch ">
                        <input type="text" name="keyword" id="searchInput" value="{{ request()->input('keyword') }}" placeholder="Cari Game">
                        <i class="bi bi-search"></i>
                    </div>
                </form>
            </div>
        </div>
        <div class="navRight w-100 justify-content-end d-none d-md-flex">
            <form action="{{ url('cari') }}" method="GET">
                <div class="navSearch">
                    <input type="text" name="keyword" id="searchInput" value="{{ request()->input('keyword') }}" placeholder="Cari Game">
                    <i class="bi bi-search"></i>
                </div>
            </form>
            {{-- <a href="{{ url('login') }}" class="btnYellowPrimary login">Login</a>
            <a href="{{ url('register') }}" class="btnYellowSecond login">Register</a> --}}
                                    
            <div class="containerMenu">
                <div class="dropdown">
                    <button class="dropdownMenu shadow">
                        <i class="bi bi-grid-fill"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ url('/') }}">
                            <div class="containers">
                                <i class="bi bi-house-door-fill"></i>
                                <div class="name">Halaman Utama</div>
                            </div>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                        <a href="{{ url('daftar-harga') }}">
                            <div class="containers">
                                <i class="bi bi-tags-fill"></i>
                                <div class="name">Daftar Harga</div>
                            </div>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                        <a href="{{ url('lacak-pesanan') }}">
                            <div class="containers">
                                <i class="bi bi-receipt-cutoff"></i>
                                <div class="name">Lacak Pesanan</div>
                            </div>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                        <a href="{{ url('kalkulator') }}">
                            <div class="containers">
                                <i class="bi bi-calculator-fill"></i>
                                <div class="name">Kalkulator</div>
                            </div>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                        <a href="{{ url('blog') }}">
                            <div class="containers">
                                <i class="bi bi-newspaper"></i>
                                <div class="name">Artikel</div>
                            </div>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    </div>
                </div>
            </div>

            <label class="theme-switch shadow">
                <input class="toggle-checkbox" id="checkbox" type="checkbox">
                <div class="switch-icon">
                    <i class="bi bi-brightness-high yellowprim"></i>
                </div>
            </label>
    
        </div>
        <input type="checkbox" role="button" aria-label="Display the menu order-1" class="menu d-md-none d-block" id="menuCheckbox">
        <!-- <button type="button" aria-label="Display the menu order-1" class="search d-md-none d-block" id="menuCheckbox">
            <i class="bi bi-list"></i>
        </button> -->
    </div>
</nav>

<div class="mobileNav" hidden>
    <a href="{{ url('/') }}" class="containers active">
        <i class="bi bi-house-door-fill"></i>
        <div class="text">Halaman Utama</div>
    </a>
    <a href="{{ url('daftar-harga') }}" class="containers ">
        <i class="bi bi-tags-fill"></i>
        <div class="text">Daftar Harga</div>
    </a>
    <a href="{{ url('lacak-pesanan') }}" class="containers ">
        <i class="bi bi-receipt-cutoff"></i>
        <div class="text">Lacak Pesanan</div>
    </a>
    <a href="{{ url('kalkulator') }}" class="containers ">
        <i class="bi bi-calculator-fill"></i>
        <div class="text">Kalkulator</div>
    </a>
        
    {{-- <a href="{{ url('login') }}" class="containers ">
        <i class="bi bi-person-fill-lock"></i>
        <div class="text">Login</div>
    </a> --}}
</div>