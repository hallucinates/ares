<script>
    function rupiahToNumerik(rupiah) {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

    function numerikToRupiah(angka) {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function validateEmail(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }
</script>
<script>
    $(document).ajaxStart(function() {
        HoldOn.open({
            theme: 'sk-circle',
            message: 'Sedang memuat...',
            textColor: 'white'
        });
    })

    $(document).ajaxStop(function() {
        HoldOn.close();
    })

    var status_voucher = 0;

    function selectLayanan(id, name, harga) {
        $('html, body').animate({
            scrollTop: $('#section-method').offset().top
        }, 400);

        $('.layanan').removeClass('active');
        $('#layanan-' + id).addClass('active');

        $('input[name=layanan]').val(id);
        $('#layanan').text(name);
        $('#harga').text(harga);

        var fee = '{{ $produk->fee }}';
        var a = Math.round((fee / 100) * rupiahToNumerik(harga));
        var b = rupiahToNumerik(harga) + a;

        $('#fee').text(numerikToRupiah(a));
        $('#total_bayar').text(numerikToRupiah(b));
    } 

    // function cekVoucher() {
    //     var voucher = $('input[name=voucher]').val();
    //     var layanan = $('input[name=layanan]').val();
        
    //     if (layanan == '' || layanan == ' ') {
    //         toastr.warning('Layanan belum dipilih');
    //     } else if (voucher == '' || voucher == ' ') {
    //         status_voucher = 0;
    //         $('#potongan').text('');
    //         $('.potongan').hide();
    //         loadMetode();
    //         toastr.warning('Kode voucher harus diisi');
    //     } else {
            
    //         $.ajax({
    //             url: '{{ url('/') }}/voucher/' + layanan + '/' + voucher,
    //             success: function (result) {
    //                 if (result.status == true) {
    //                     status_voucher = 1;
    //                     $('#potongan').text(result.potongan);
    //                     $('.potongan').show();
    //                     $('#potongan-view').show();
    //                     $('#pot').text("- " + result.potongan);
    //                     loadMetode();
    //                     toastr.success(result.message);
    //                 } else {
    //                     status_voucher = 0;
    //                     $('#potongan').text('');
    //                     $('.potongan').hide('');
    //                     $('input[name=voucher]').val('');
    //                     $('#potongan-view').hide();
    //                     $('#pot').text('- Rp. 0');
    //                     loadMetode();
    //                     toastr.error(result.message);
    //                 }
    //             },
    //             error: function () {
    //                 status_voucher = 0;
    //                 $('#potongan').text('');
    //                 $('.potongan').hide();
    //                 $('input[name=voucher]').val('');
    //                 $('#potongan-view').hide();
    //                 $('#pot').text('- Rp. 0');
    //                 loadMetode();
    //                 toastr.error('Terjadi kesalahan pada server');
    //             }
    //         });
    //     }
    // }

    function cekVoucher() {
        return true;
    }

    var modal_confirm = new bootstrap.Modal(document.getElementById('modal-confirm'));

    function confirm() {
        var layanan = $('input[name=layanan]').val();
        var email   = $('input[name=email]').val();

        var target = $('.games-input').map(function() {
            return this.value;
        }).get().join(',');

        if (!layanan) {
            toastr.warning('Nominal layanan belum di pilih');
        } else if (!target || target == ' ' || target == '' || target == ',') {
            toastr.warning('Tujuan belum diisi');
        } else if (!email) {
            toastr.warning('Email belum diisi');
        } else if (validateEmail(email) == false) {
            toastr.warning('Email tidak sesuai');
        } else {
            $('#btn-confirm').text('Loading...').attr('disabled', 'disabled');
            $('#tujuan').text(target.replace(/,/g, ' - '));
            $('#btn-order').attr('disabled', 'disabled').text('Loading...');
            $('#email2').text($('#email').val());

            $.ajax({
                url: '{{ url('/') }}/cek',
                type: 'POST',
                data: {
                    id: '{{ $produk->id }}',
                    target: target,
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(result) {
                    if (result.status == true) {
                        if (result.hasil != '') {
                            $('#hasil-view').show();
                            $('#hasil').text(result.hasil);
                            $('input[name=target_hasil]').val(result.hasil);
                        } else {
                            $('#hasil-view').hide();
                            $('#hasil').text('-');
                            $('input[name=target_hasil]').val('');
                        }

                        modal_confirm.show();
                    } else {
                        toastr.error(result.message);
                    }

                    $('#btn-confirm').text('Konfirmasi').removeAttr('disabled');
                    $('#btn-order').removeAttr('disabled').text('Konfirmasi');
                }
            });
        }
	}

    function process() {
        var layanan = $('input[name=layanan]').val();
        var email   = $('input[name=email]').val();

        var target = $('.games-input').map(function() {
            return this.value;
        }).get().join(',');

        if (layanan && target || target != ' ' || target != '' || target != ',' && metode && email && validateEmail(email) == true) {
            $('#btn-order-process').attr('disabled', 'disabled').text('Loading...');

            setTimeout(function() {
                $('#form-order').submit();
            }, 1200);
        }
    }

    function cancel() {
		$('#modal-confirm').modal('hide');
	}

    selectLayananFromParams();
    function selectLayananFromParams() {
        const id = getParameterByName('id');
        if (id) {
            selectLayananByID(id);
        }
    }

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    function selectLayananByID(id) {
        $('html, body').animate({
            scrollTop: $('#section-method').offset().top
        }, 400);

        var layananInput = document.getElementById('layanan-' + id);
        if (layananInput) {
            layananInput.checked = true;
			layananInput.value = id;
        }

        var hiddenLayananInput = document.querySelector("input[name='layanan']");
        if (hiddenLayananInput) {
            hiddenLayananInput.value = id;
        }
    }
</script>