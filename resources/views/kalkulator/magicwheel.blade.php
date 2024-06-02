@extends('master2')

@section('judul', 'Kalkulator')

@section('konten')
<div class="row justify-center">
	<div class="col-lg-4 col-md-6 col-12">
		<form onsubmit="event.preventDefault(); calculateDiamonds();">
			<div class="login-card">
				<span class="head">Hitung Magic Whell</span>
				<div class="floating-label-content">
					<input type="number" class="form-control floating-input" id="pointSlider" min="0" value="100" placeholder=" ">
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
		if (points < 196) {
			var remainingPoints = 200 - points;
			var spinsNeeded = Math.ceil(remainingPoints / 5);
			requiredDiamonds = spinsNeeded * 270;
			toastr.success('Berhasil menghitung jumlah Diamond!');
		} else {
			if (points > 199) {
				toastr.error('Point tidak boleh melebihi 199!');
			}
			var remainingPoints = 200 - points;
			requiredDiamonds = remainingPoints * 60;
		}

		document.getElementById('JmlDiamond').innerText = requiredDiamonds;
	}
</script>
@endsection
		