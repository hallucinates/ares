@extends('master2')

@section('judul', 'Kontak')

@section('konten')
<div class="row justify-center">
	<div class="col-lg-4 col-md-6 col-12">
		<form method="POST" action="{{ url('kontak') }}">
			@csrf
			<div class="login-card">
				<span class="head">Hubungi CS</span>
				<div class="floating-label-content">
					<input type="text" class="form-control floating-input" name="name" id="name" placeholder=" " required>
					<label class="floating-label" for="name">Nama Lengkap</label>
				</div>
				<div class="floating-label-content">
					<input type="number" class="form-control floating-input" name="no_wa" id="no_wa" placeholder=" " min="1" required>
					<label class="floating-label" for="no_wa">No.  WhatsApp</label>
				</div>
				<div class="floating-label-content position-relative">
					<textarea type="text" class="form-control floating-input" name="pesan" id="pesan" placeholder=" " style="height: 200px;" required></textarea>
					<label class="floating-label" for="pesan">Pesan</label>
				</div>
				<button type="submit" name="tombol" value="submit" class="btnYellowPrimary md w-100">Kirim</button>
			</div>
		</form>
	</div>
</div>
@endsection
		