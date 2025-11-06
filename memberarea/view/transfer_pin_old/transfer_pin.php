<?php 
    require_once 'helper/session.php';
    
    $token = create_token();

    require_once '../model/classMember.php';
    $cm = new classMember();
    $member = $cm->detail($session_member_id);
            
    require_once '../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    $total_kode_aktivasi = $cka->total_kode_aktivasi($session_member_id, 0);
    $kode_aktivasi = $cka->index($session_member_id, '0');
?>

<?php include 'view/layout/header.php'; ?>
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4 mb-2" id="blockFirstForm">
        <div class="row">
            <div class="col">
                <div class="card mb-4">
                    <div class="card-body" id="cart_container">
                        <form action="controller/transfer_pin/transfer.php" id="formTransferPIN" method="post">
                            <input type="hidden" name="token" value="<?=$token?>">
                            <div class="col mt-4 mb-2">
                                <h6>Kirim Ke</h6>
                            </div>
                            <div class="form-group form-floating-2 mb-3">
                                <input type="hidden" name="id">
                                <input type="text" class="form-control" id="id_member" name="id_member" value="">
                                <label class="form-control-label" for="id_member">ID <?=$lang['member']?></label>
                            </div>
                            <div class="form-group form-floating-2 mb-3">
                                <input type="text" class="form-control" id="nama_member" name="nama_member" value="" disabled="disabled">
                                <label class="form-control-label" for="nama_member">Nama <?=$lang['member']?></label>
                            </div>
                            <div id="daftarPIN" style="display:none">
                                <div class="col">
                                    <h6>Daftar Kode Aktivasi</h6>
                                    <div class="card data-list shadow-none mt-2 mb-4" id="itemPaket" style="display:none">
                                        <div class="card-body pb-0 pt-1" id="kodeList">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                                    <a href="<?=base_url()?>"
                                        class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2">BATALKAN</a>
                                    <button type="button"
                                        class="btn btn-default btn-block btn-lg rounded-pill px-5 order-xs-first mb-3"
                                        id="btnTransfer">TRANSFER</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container container pt-4 pb-4 mb-2" id="blockFirstForm2" style="display:none">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-center pt-4 mb-4">
                        <h5 class="text-center mb-2">Kirim ke <?=$lang['member']?></h5>
                        <h3 id="tujuan_transfer">

                        </h3>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col">
                        <div class="pt-4 bg-white">
                            <h6>Detail Transfer</h6>
                            <div id="detail"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mb-2">
                        <div class="alert alert-warning" role="alert">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div class="col ps-0 align-self-center">
                                    <h5 class="text-start fw-normal size-12">Harap periksa kembali detail pengiriman <?=$lang['kode_aktivasi']?> anda. Anda tidak akan dapat
                                        mengubanya nanti.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                        <button class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2" id="btnKembali">KEMBALI</button>
                        <button type="button"
                            class="btn btn-default btn-block btn-lg rounded-pill px-5 order-xs-first mb-3"
                            id="btnKonfirmasi">KONFIRMASI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>

<script src="assets/vendor/autoNumeric/autoNumeric.js"></script>

<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockFirstForm2 = $('#blockFirstForm2');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formTransferPIN = $('#formTransferPIN');
        var daftarPIN = $('#daftarPIN');
        var itemPaket = $('#itemPaket');
        var idMember = $('#id_member');
        var btnTransfer = $('#btnTransfer');
        var btnKonfirmasi = $('#btnKonfirmasi');
        var btnKembali = $('#btnKembali');
        var tujuan_transfer = $('#tujuan_transfer');
        var detail = $('#detail');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });

        idMember.on('change keyup', function () {
            var id_member = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'controller/member/get_nama_member.php',
                data: {
                    id_member: id_member
                },
                beforeSend: function () {},
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $('input[name=id]').val(obj.id);
                        $('input[name=id_member]').val(obj.id_member);
                        $('input[name=nama_member]').val(obj.nama_member);
                        daftarPIN.show();
                        getKodeAktivasi();
                    } else {
                        $('input[name=nama_member]').val(obj.message);
                        daftarPIN.hide();
                    }
                },
                complete: function () {}
            });
        });

        function getKodeAktivasi() {
            $.ajax({
                type: 'POST',
                url: 'controller/transfer_pin/get_pin.php',
                beforeSend: function () {},
                success: function (result) {
                    const obj = JSON.parse(result);
                    console.log(obj.status);
                    if (obj.status == true) {
                        itemPaket.show();
                        $('#kodeList').html(obj.html);
                    } else {
                        $('#kodeList').find('data-item').remove();
                        itemPaket.hide();
                    }
                },
                complete: function () {}
            });
        }


        btnTransfer.on("click", function (e) {
            var id = $('input[name=id]').val();
            if(id != ""){
                var e = $(this);
                var dataString = $('#formTransferPIN').serialize();
                $.ajax({
                    type: 'POST',
                    url: 'controller/transfer_pin/cek_transfer.php',
                    data: dataString,
                    beforeSend: function () {
                        btn_proses_start(e);
                    },
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            detail.html(obj.html);
                            var id_member = $('#id_member').val();
                            var nama_member = $('#nama_member').val();
                            tujuan_transfer.html(`<p class="size-11">${id_member}</p><p class="size-18">${nama_member}</p>`);
                            blockFirstForm.hide();
                            blockFirstForm2.show();
                        } else {            
                            Swal.fire({
                                text: 'Terjadi Kesalahan.',
                                customClass: {
                                    confirmButton: 'btn-default rounded-pill px-5'
                                }
                            });
                        }
                    },
                    complete: function () {
                        btn_proses_end(e);
                    }
                });
            } else {                
                Swal.fire({
                    text: 'Tujuan transfer belum di pilih. Silahkan masukan ID <?=$lang['member']?>.',
                    customClass: {
                        confirmButton: 'btn-default rounded-pill px-5'
                    }
                });
            }
        });

        btnKonfirmasi.on("click", function (e) {
            blockFirstForm2.hide();
            blockNextForm.show();
            $('input[name=old_pin1]').focus();
        });

        btnKembali.on("click", function (e) {
            blockFirstForm2.hide();
            blockFirstForm.show();
        });

        formCekPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    if (result == true) {
                        formTransferPIN.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan <?=$lang['kode_aktivasi']?> sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3"><?=$lang['kode_aktivasi']?> yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formTransferPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function () {
                    loader_open();
                },
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'riwayat_transfer_pin';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'transfer_pin';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });

        $('.input_pin').keyup(function (e) {
            var key = e.keyCode || e.charCode;

            if (key == 8 || key == 46) {
                if (this.value == '') {
                    $(this).attr('type', 'text');
                    if (!$(this).is(':first-child')) {
                        $(this).prev('.input_pin').focus();
                    } else {
                        formCekPIN.find('.form-error').remove();
                    }
                }
            } else {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    this.value = '';
                } else {
                    if (this.value.length >= this.maxLength) {
                        $(this).delay(300).queue(function () {
                            $(this).attr('type', 'password').dequeue();
                        });
                        if (!$(this).is(':last-child')) {
                            $(this).next('.input_pin').focus();
                        } else {
                            if ($(this).parents('#formCekPIN').length > 0) {
                                formCekPIN.submit();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>