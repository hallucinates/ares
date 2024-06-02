<div class="footer">
    <div class="container">
        <div class="logo">
            <img src="{{ \App\Helper::pengaturan('logo') }}" alt="logo" />
            <div class="names">{{ \App\Helper::pengaturan('nama') }}</div>
        </div>
        <div class="desc mx-auto">
            {{ \App\Helper::pengaturan('deskripsi') }}		
        </div>
        <div class="sosmed">
            <a href="https://instagram.com/" class="containers text-white">
                <i class="bi bi-instagram"></i>					
            </a>
            <a href="https://tiktok.com/" class="containers text-white">
                <i class="bi bi-tiktok"></i>					
            </a>
            <a href="https://facebook.com/" class="containers text-white">
                <i class="bi bi-facebook"></i>					
            </a>
        </div>
        <div class="bottomFoot">
            <div class="copyright">
                <div class="text">
                    Copyright © <script>document.write(new Date().getFullYear());</script>
                    <a href="{{ url('/') }}" class="text-white"> {{ \App\Helper::pengaturan('nama') }}</a> - All Right Reserved
                </div>
            </div>
            <div class="linkFoot">
                <div class="containers">
                    <a href="{{ url('/') }}">Halaman Utama</a>
                    <a href="{{ url('/') }}#produk">Top Up</a>
                    <a href="{{ url('syarat-dan-ketentuan') }}">Syarat & Ketentuan</a>
                    <a href="{{ url('kontak') }}">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>	