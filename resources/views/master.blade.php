<!DOCTYPE html>
<html lang="id-ID">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">

	@if (Request::segment(1) == '')
	<title>{{ \App\Helper::pengaturan('judul') }} — {{ \App\Helper::pengaturan('nama') }}</title>
	@else
	<title>@yield('judul') — {{ \App\Helper::pengaturan('nama') }}</title>
	@endif
	<link rel="shortcut icon" href="{{ \App\Helper::pengaturan('logo') }}">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ \App\Helper::pengaturan('deskripsi') }}">
    <meta name="keyword" content="{{ \App\Helper::pengaturan('kata-kunci') }}">
    <meta name="author" content="oxdnr">
    <meta name="theme-color" content="">
    <meta name="robots" content="index, follow">
    <meta name="device" content="desktop">
    <meta name="coverage" content="Worldwide">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Helper::pengaturan('judul') }} — {{ \App\Helper::pengaturan('nama') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url()->full() }}">
	<meta property="og:title" content="{{ \App\Helper::pengaturan('judul') }} — {{ \App\Helper::pengaturan('nama') }}">
	<meta property="og:site_name" content="{{ \App\Helper::pengaturan('judul') }} — {{ \App\Helper::pengaturan('nama') }}">
	<meta property="og:description" content="{{ \App\Helper::pengaturan('deskripsi') }}">
	<meta property="og:image" content="{{ \App\Helper::pengaturan('logo') }}">
	<meta property="og:image:alt" content="{{ \App\Helper::pengaturan('logo-alt') }}">

	<link rel="stylesheet" href="{{ url('assets') }}/plugins/toastr.js/latest/toastr.min.css">
	<link rel="stylesheet" href="{{ url('assets') }}/plugins/bootstrap/dist/css/bootstrap.min.css" >
  	<link rel="stylesheet" href="{{ url('assets') }}/plugins/bootstrap-icons/font/bootstrap-icons.css">
  	<link rel="stylesheet" href="{{ url('assets') }}/plugins/swiper/swiper.css">
  	<link rel="stylesheet" href="{{ url('assets') }}/css/style.css">
	<link rel="stylesheet" href="{{ url('assets') }}/css/HoldOn.min.css">
  
    <script src="{{ url('assets') }}/plugins/iconify/iconify.min.js"></script>
	<script src="{{ url('assets') }}/js/jquery.min.js"></script>
	<script src="{{ url('assets') }}/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		html {
			scroll-behavior: smooth;
		}
	</style>
</head>
<body id="body">

	@include('layouts/navbar')

	@if (Request::segment(1) == '' || Request::segment(1) == 'lacak-pesanan')
	<section>
	@else
	<section class="container-track">
	@endif
		
		@yield('konten')

		{{-- <div class="modal fade" id="modal-home" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="z-index: 99999;">
			<div class="modal-dialog modal-dialog-centered" style="max-width:600px">
				<div class="modal-home-content py-5">
					<div class="cursor-pointer bg-white rounded-xl h-100 shadow">
                        <div class="containers d-flex flex-column">
                            <img src="assets/images/pamflet.png" class="rounded-xl" alt="">
                        </div>
						<div class="p-4">
							<div class="mt-2 mb-3 text-center flex-grow-1">
								<h3 style="font-weight: 700;">Berita & Informasi</h3>
							</div>
							<div class="flex-grow-1 mb-3">
								Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae corporis atque ad mollitia sit temporibus quam doloremque. Consectetur asperiores facilis non est distinctio labore sunt iusto fugiat. Sapiente, totam voluptatem?
							</div>
						</div>
                    </div>
					<button class="btn btn-primary w-100 rounded-xl mt-3" id="modal_read">Saya sudah membaca</button>
				</div>
			</div>
		</div> --}}

		@include('layouts/footer')
	</section>
	    
  	<a href="https://wa.me/6281312699615" class="floating-contact d-flex justify-content-center gap-1 flex-column contact" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Contact CS Kami Via Whatsapp">
    	<span class="text-white">CHAT CS</span>
  	</a>

  	<a id="backToTopBtn" onclick="scrollToTop()" class="floating-btu d-flex justify-content-center gap-1 flex-column contact" tabindex="0">
    	<i class="bi bi-arrow-up"></i>
  	</a>

	<script src="{{ url('assets') }}/plugins/swiper/swiper-bundle.min.js"></script>
	<script src="{{ url('assets') }}/plugins/toastr.js/latest/toastr.min.js"></script>
	<script src="{{ url('assets') }}/js/script.js"></script>
	<script src="{{ url('assets') }}/js/HoldOn.min.js"></script>
  
  	<script>
	  	setInterval(function() {
		  	$('#toolbarContainer').remove();
	  	}, 500);

	  	function salin(text, label_text) {
		  	navigator.clipboard.writeText(text);
		  	toastr.success(label_text);
	  	}

		function closeInstall() {
            const el = document.getElementById('pwa')
            el.classList.add('hidden')
        }

    	toastr.options = {
      		'progressBar': true,
      		'showMethod': 'fadeIn',
      		'hideMethod': 'fadeOut'
    	}
  	</script>

  	<script>
		// document.addEventListener('DOMContentLoaded', function() {
		// 	var modal = new bootstrap.Modal(document.getElementById('modal-home'));
		// 	var modalReadBtn = document.getElementById('modal_read');
		// 	var sudahBacaStatus = localStorage.getItem('sudahBaca');

		// 	setTimeout(function() {
		// 		if (!sudahBacaStatus || (new Date() - new Date(sudahBacaStatus)) > 24 * 60 * 60 * 1000) {
		// 			modal.show();
		// 		}
		// 	}, 30000);

		// 	modalReadBtn.addEventListener('click', function() {
		// 		localStorage.setItem('sudahBaca', new Date());
		// 		modal.hide();
		// 	});

		// 	setTimeout(function() {
		// 		localStorage.removeItem('sudahBaca');
		// 	}, 24 * 60 * 60 * 1000);

		// 	modal.show();
		// });
	</script>
</body>
</html>