<?php 
    require_once '../helper/session.php';
    $token = create_token();
    require_once '../model/classMember.php';
    $cm = new classMember();
    $member = $cm->detail($session_member_id);
            
    require_once '../model/classRekening.php';
    $obj = new classRekening();
    $bank = $obj->index();
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
                        <form action="controller/topup_saldo/topup_saldo.php" id="formTopup" method="post">
                            <input type="hidden" name="token" value="<?=$token?>">
                            <input type="hidden" name="kode_unik" id="kode_unik" value="">
                            <input type="hidden" name="total_bayar" id="total_bayar" value="">
                            <div class="form-group form-floating-2 mb-3">
                                <input type="text" class="form-control autonumeric" id="nominal" name="nominal" value="">
                                <label class="form-control-label" for="nominal">Nominal</label>
                            </div>
                            <div class="form-group form-floating-2 mb-3">
                                <select class="form-control" id="rekening" name="rekening">
                                    <option value="">Pilih Bank</option>
                                    <?php 
                                    while ($row   = $bank->fetch_object()) {
                                        echo "<option value='".$row->id."'>".$row->nama_bank."</option>";
                                    }
                                    ?>
                                </select>
                                <label class="form-control-label" for="rekening">Bank</label>
                            </div>
                            <div class="row py-2">
                                <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                                    <a href="<?=base_url()?>"
                                        class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2">BATALKAN</a>
                                    <button type="button"
                                        class="btn btn-default btn-lg rounded-pill px-5 order-xs-first mb-3"
                                        id="btnTransfer">PROSES</button>
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
                <div class="row mb-4">
                    <div class="col">
                        <div class="pt-2 bg-white">
                            <div id="detail"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                        <button class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2" id="btnKembali">KEMBALI</button>
                        <button type="button"
                            class="btn btn-default btn-lg rounded-pill px-5 order-xs-first mb-3"
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
        var formTopup = $('#formTopup');
        var btnTransfer = $('#btnTransfer');
        var btnKonfirmasi = $('#btnKonfirmasi');
        var btnKembali = $('#btnKembali');
        var detail = $('#detail');

        $('.autonumeric').autoNumeric('init', {
            "aSep": ".",
            "aDec": ",",
            "mDec": "0",
        });


        btnTransfer.on("click", function (e) {
            var nominal = $('#nominal').val();
            var rekening = $('#rekening').val();
            if(nominal != ""){
                if(rekening != ""){
                    var e = $(this);
                    var dataString = $('#formTopup').serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'controller/topup_saldo/cek_topup.php',
                        data: dataString,
                        beforeSend: function () {
                            btn_proses_start(e);
                        },
                        success: function (result) {
                            const obj = JSON.parse(result);
                            if (obj.status == true) {
                                $('#kode_unik').val(obj.kode_unik);
                                $('#total_bayar').val(obj.total_bayar);
                                detail.html(obj.html);
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
                        text: 'Tujuan transfer belum dipilih. Silahkan pilih Bank terlebih dahulu.',
                        customClass: {
                            confirmButton: 'btn-default rounded-pill px-5'
                        }
                    });
                }
            } else {                
                Swal.fire({
                    text: 'Nominal Topup minimal 50.000',
                    customClass: {
                        confirmButton: 'btn-default rounded-pill px-5'
                    }
                });
            }
        });

        btnKonfirmasi.on("click", function (e) {
            blockFirstForm2.hide();
            blockNextForm.show();
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
                        formTopup.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );

                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                );

                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        formTopup.on("submit", function (e) {
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
                        var redirect_url = 'riwayat_topup_saldo';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'topup_saldo';
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