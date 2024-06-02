<!DOCTYPE html>
<html lang="id-ID">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">

	@if (Request::segment(1) == '')
	<title>{{ App\Helper::pengaturan('judul') }} — {{ App\Helper::pengaturan('nama') }}</title>
	@else
	<title>@yield('judul') — {{ App\Helper::pengaturan('nama') }}</title>
	@endif
	<link rel="shortcut icon" href="{{ App\Helper::pengaturan('logo') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ App\Helper::pengaturan('deskripsi') }}">
    <meta name="keyword" content="{{ App\Helper::pengaturan('kata-kunci') }}">
    <meta name="author" content="oxdnr">
    <meta name="theme-color" content="">
    <meta name="robots" content="index, follow">
    <meta name="device" content="desktop">
    <meta name="coverage" content="Worldwide">
    <meta name="apple-mobile-web-app-title" content="{{ App\Helper::pengaturan('judul') }} — {{ App\Helper::pengaturan('nama') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta property="og:type" content="website">
	<meta property="og:url" content="{{ url()->full() }}">
	<meta property="og:title" content="{{ App\Helper::pengaturan('judul') }} — {{ App\Helper::pengaturan('nama') }}">
	<meta property="og:site_name" content="{{ App\Helper::pengaturan('judul') }} — {{ App\Helper::pengaturan('nama') }}">
	<meta property="og:description" content="{{ App\Helper::pengaturan('deskripsi') }}">
	<meta property="og:image" content="{{ App\Helper::pengaturan('logo') }}">
	<meta property="og:image:alt" content="{{ App\Helper::pengaturan('logo-alt') }}">

	<link rel="stylesheet" href="{{ url('assets') }}/plugins/toastr.js/latest/toastr.min.css">
	<link rel="stylesheet" href="{{ url('assets') }}/plugins/bootstrap/dist/css/bootstrap.min.css" >
  	<link rel="stylesheet" href="{{ url('assets') }}/plugins/bootstrap-icons/font/bootstrap-icons.css">
  	<link rel="stylesheet" href="{{ url('assets') }}/plugins/swiper/swiper.css">
  	<link rel="stylesheet" href="{{ url('assets') }}/css/style.css">
  
    <script src="{{ url('assets') }}/plugins/iconify/iconify.min.js"></script>
	<script src="{{ url('assets') }}/js/jquery.min.js"></script>
	<script src="{{ url('assets') }}/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	
	<style>
		html {
			scroll-behavior: smooth;
		}
	</style>
</head>
<body class="overflow-hidden login">

	<div class="register-wrapper">
		<div class=" container ">
			<a class="btn-back inline-flex items-center justify-center" href="{{ url('/') }}" style="outline: none;">
				<i class="bi bi-x"></i>
			</a>
			@yield('konten')
		</div>
	</div>
	    
  	<a href="https://wa.me/6281312699615" class="floating-contact d-flex justify-content-center gap-1 flex-column contact" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Contact CS Kami Via Whatsapp">
    	<span class="text-white">CHAT CS</span>
  	</a>

	<script src="{{ url('assets') }}/plugins/swiper/swiper-bundle.min.js"></script>
	<script src="{{ url('assets') }}/plugins/toastr.js/latest/toastr.min.js"></script>
	<script src="{{ url('assets') }}/js/script.js"></script>
  
	<script>
		setInterval(function() {
			$('#toolbarContainer').remove();
		}, 500);

		function salin(text, label_text) {

			navigator.clipboard.writeText(text);

			toastr.success(label_text);
		}

		$('#toggle-pw').on('click', function() {

            var el_pw = $('input[name=password]');

            if (el_pw.attr('type') == 'password') {
                $(this).removeClass('bi-eye-slash').addClass('bi-eye');
                el_pw.attr('type', 'text');
            } else {
                $(this).removeClass('bi-eye').addClass('bi-eye-slash');
                el_pw.attr('type', 'password');
            }
        });

        $('#toggle-pwb').on('click', function() {

            var el_pw = $('input[name=password2]');

            if (el_pw.attr('type') == 'password') {
                $(this).removeClass('bi-eye-slash').addClass('bi-eye');
                el_pw.attr('type', 'text');
            } else {
                $(this).removeClass('bi-eye').addClass('bi-eye-slash');
                el_pw.attr('type', 'password');
            }
        });
	</script>
</body>
</html>