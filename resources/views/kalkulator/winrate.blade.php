@extends('master2')

@section('judul', 'Kalkulator')

@section('konten')
<div class="row justify-center">
	<div class="col-lg-4 col-md-6 col-12">
		<form method="POST">
			@csrf
			<div class="login-card">
				<span class="head">Hitung Win Rate</span>
                <div class="floating-label-content">
                    <input type="number" class="form-control floating-input" id="TotalMatch" placeholder=" ">
                    <label class="floating-label" for="TotalMatch">Total Match Kamu</label>
                </div>
                <div class="floating-label-content">
                    <input type="number" class="form-control floating-input" id="TotalWr" placeholder=" ">
                    <label class="floating-label" for="TotalWr">Total Win Rate Kamu (%)</label>
                </div>
                <div class="floating-label-content">
                    <input type="number" class="form-control floating-input" id="MauWr" placeholder=" ">
                    <label class="floating-label" for="MauWr">Total Win Rate Target (%)</label>
                </div>
                <button id="hasil" type="button" class="btnYellowPrimary md w-100">Hitung</button>
                <div class="d-flex flex-column gap-1">
                    <span class="text-white" id="HasilKalkulasi" onclick="displayErrorMessage()"></span>
                </div>
			</div>
		</form>
	</div>
</div>

<script>
    // Variables
    const TotalMatch = document.querySelector('#TotalMatch');
    const TotalWr = document.querySelector('#TotalWr');
    const MauWr = document.querySelector('#MauWr');
    const hasil = document.querySelector('#hasil');
    const HasilKalkulasi = document.querySelector('#HasilKalkulasi');

    // Functions
    function res() {
        if (MauWr.value == '100') {
            toastr.error('Kamu tidak dapat mencapai 100% win rate!');
            const text = `Jangan Ngaco ya! wkwk`;
            HasilKalkulasi.innerHTML = text;
            return;
        }

        const resultNum = rumus(TotalMatch.value, TotalWr.value, MauWr.value);
        const text =
            `Kamu memerlukan sekitar <b>${resultNum}</b> win tanpa lose untuk mendapatkan win rate <b>${MauWr.value}%</b>`;
        HasilKalkulasi.innerHTML = text;
        toastr.success('Berhasil menghitung win rate!');
    }

    function rumus(TotalMatch, TotalWr, MauWr) {
        let tWin = TotalMatch * (TotalWr / 100);
        let tLose = TotalMatch - tWin;
        let sisaWr = 100 - MauWr;
        let wrResult = 100 / sisaWr;
        let seratusPersen = tLose * wrResult;
        let final = seratusPersen - TotalMatch;
        return Math.round(final);
    }

    // Main
    window.addEventListener('load', init);

    function init() {
        load();
        eventListener();
    }

    function load() {}

    function eventListener() {
        hasil.addEventListener('click', res);
    }
</script>
@endsection
		