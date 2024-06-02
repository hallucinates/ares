@extends('master')

@section('judul', 'Syarat & Ketentuan')

@section('konten')
<div class="container">
    <div class="desc mb-3">
        <span class="txt-primary">
            <a href="{{ url('/') }}">Halaman Utama</a>
        </span>
        <span class="mx-2">/</span>Syarat & Ketentuan           
    </div>
    <div class="row reverse justify-content-center">
        <div class="col-lg-8">
        <div class="title-head text-center mb-3">Syarat & Ketentuan</div>
            <div class="cards shadow py-3">
                <div class="container overflow-hidden">
                    <div class="notes">
                        <div class="text mt-4">
                            <p>Selamat datang di <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a>! Harap baca dengan seksama syarat dan ketentuan penggunaan berikut sebelum menggunakan layanan kami.</p>

<p><strong>Persetujuan Penggunaan&nbsp;&nbsp;</strong></p>

<p>Dengan mengakses dan menggunakan layanan <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a>, Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang tercantum di sini.</p>

<p><strong>Kewajiban Pengguna</strong></p>

<ul>
<li>Anda bertanggung jawab atas keamanan akun dan informasi pribadi Anda.</li>
<li>Dilarang menggunakan layanan <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> untuk tujuan ilegal atau melanggar hukum yang berlaku.</li>
</ul>

<p><strong>Pembelian dan Pembayaran</strong></p>

<ul>
<li>Seluruh transaksi pembelian melalui <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> tunduk pada ketentuan dan kebijakan pembayaran yang berlaku.</li>
<li>Kami tidak bertanggung jawab atas kesalahan atau penundaan dalam proses pembayaran dari pihak pembayaran pihak ketiga.</li>
</ul>

<p><strong>Kebijakan Privasi</strong></p>

<ul>
<li>Kami menghormati privasi pengguna kami. Informasi lebih lanjut tentang kebijakan privasi dapat ditemukan di [tautkan ke kebijakan privasi].</li>
</ul>

<p><strong>Penggunaan Konten</strong></p>

<ul>
<li>Seluruh konten yang tersedia di <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> adalah milik atau berlisensi oleh <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> dan dilindungi oleh undang-undang hak cipta.</li>
</ul>

<p><strong>Penghentian atau Penangguhan Akses</strong></p>

<ul>
<li><a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> berhak untuk membatasi, menangguhkan, atau mengakhiri akses pengguna tanpa pemberitahuan terlebih dahulu jika terdapat pelanggaran terhadap syarat dan ketentuan ini.</li>
</ul>

<p><strong>Pengubahan Syarat dan Ketentuan</strong></p>

<ul>
<li><a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a> berhak untuk memperbarui, mengubah, atau mengubah syarat dan ketentuan ini setiap saat tanpa pemberitahuan terlebih dahulu.</li>
</ul>

<p>&nbsp;</p>

<p>Terima kasih atas kepercayaan Anda pada <a href="{{ url('/') }}">{{ ucwords(Request::getHost()) }}</a>. Kami berkomitmen untuk memberikan layanan terbaik kepada Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-40"></div>
        </div>
    </div>
</div>
@endsection
