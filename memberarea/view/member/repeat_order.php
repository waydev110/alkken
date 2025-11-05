<?php 
    require_once 'helper/session.php';
    
    $token = create_token();

    require_once '../model/classMember.php';
    require_once '../model/classKodeAktivasi.php';
    require_once '../model/classHistoryRO.php';

    $cm = new classMember();
    $cka= new classKodeAktivasi();
    $chro= new classHistoryRO();

    $kode_aktivasi = $cka->index_member($session_member_id, '1');  
    $ro = $chro->riwayat($session_member_id);
?>

<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/intlTelInput/css/intlTelInput.css">
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
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <form action="controller/member/repeat_order.php" id="formRepeatOrder" method="post">
            <input type="hidden" name="token" value="<?=$token?>">
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Histori Repeat Order</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-44 shadow-sm rounded-10 bg-theme text-white">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-0 size-12"><span class="text-default fw-medium">Jumlah RO</p>
                                    <p><?=$ro->total?> <small class="size-12 text-muted">kali</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="avatar avatar-44 shadow-sm rounded-10 bg-theme text-white">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-0 size-12"><span class="text-default fw-medium">Terakhir RO</span></p>
                                    <p><?=tgl_indo($ro->created_at)=='' ? '-' : tgl_indo($ro->created_at)?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <h6>Data Repeat Order</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-floating mb-3">
                        <select class="form-control" id="kode_aktivasi" name="kode_aktivasi" required="required">
                            <?php 
                            while ($row   = $kode_aktivasi->fetch_object()) {
                                echo "<option value='".$row->kode_aktivasi."'>PAKET".$row->jumlah_hu." (".rp($row->harga_peringkat).")"."</option>";
                            }
                            ?>
                        </select>
                        <label class="form-control-label" for="kode_aktivasi">Paket Repeat Order</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-grid mb-4 mt-2">
                    <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnSubmit">Submit</button>
                </div>
            </div>
        </form>
    </div>


    <?php include 'view/auth/form_cek_pin.php'; ?>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script>
    $(document).ready(function () {
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var formCekPIN = $('#formCekPIN');
        var formRepeatOrder = $('#formRepeatOrder');
        var btnSubmit = $('#btnSubmit');

        btnSubmit.on("click", function (e) {
            blockFirstForm.hide();
            blockNextForm.show();
            $('input[name=old_pin1]').focus();
            e.preventDefault();
        });

        formCekPIN.on("submit", function (e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function (result) {
                    if (result == true) {
                        formRepeatOrder.submit();
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

        formRepeatOrder.on("submit", function (e) {
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
                        var redirect_url = 'repeat_order';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'repeat_order';
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