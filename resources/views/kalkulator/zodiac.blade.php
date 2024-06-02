@extends('master2')

@section('judul', 'Kalkulator')

@section('konten')
<div class="row justify-center">
	<div class="col-lg-4 col-md-6 col-12">
		<form onsubmit="event.preventDefault(); calculateDiamonds();">
			<div class="login-card">
				<span class="head">Hitung Zodiac</span>
				<div class="floating-label-content">
					<input type="number" class="form-control floating-input" id="pointSlider" placeholder=" ">
					<label class="floating-label" for="pointSlider">Point Magic Wheel Kamu</label>
				</div>
				<button type="submit" class="btnYellowPrimary md w-100">Hitung</button>
				<div class="d-flex flex-column gap-1">
					<span class="option">jumlah diamonds yang dibutuhkan : <span id="JmlDiamond"></span></span>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
	function calculateDiamonds() {
		var points = parseInt(document.getElementById('pointSlider').value);
		var requiredDiamonds;
		if (points < 90) {
			requiredDiamonds = Math.ceil((2000 - points * 20) * 850 / 1000);
			toastr.success('Berhasil menghitung jumlah Diamond!');
		} else {
			if (points > 99) {
				toastr.error('Point Zodiac tidak boleh melebihi 99!');
			}
			requiredDiamonds = Math.ceil(2000 - points * 20);
		}
		document.getElementById('JmlDiamond').innerText = requiredDiamonds;
	}
</script>
@endsection
		