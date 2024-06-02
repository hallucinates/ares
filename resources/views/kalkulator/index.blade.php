@extends('master2')

@section('judul', 'Kalkulator')

@section('konten')
<div class="row justify-center">
	<div class="col-lg-4 col-md-6 col-12">
		<form method="POST">
			@csrf
			<div class="login-card">
				<span class="head">Kalkulator</span>
                <button type="button" onclick="window.location.href='{{ url('/') }}/winrate'" class="btnYellowPrimary md w-100">Win Rate</button>
                <button type="button" onclick="window.location.href='{{ url('/') }}/magicwheel'" class="btnYellowPrimary md w-100">Magic Wheel</button>
                <button type="button" onclick="window.location.href='{{ url('/') }}/zodiac'" class="btnYellowPrimary md w-100">Zodiac</button>
			</div>
		</form>
	</div>
</div>
@endsection
		