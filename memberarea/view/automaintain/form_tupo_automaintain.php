<?php 
    if (function_exists('mcrypt_create_iv')) {
        $_SESSION['token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    } else {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
	$token = $_SESSION['token'];
    include ("model/classAutoMaintain.php");
    include ("model/classTutupPoinAutoMaintain.php");
    require_once("model/classRekening.php");
    
    $cam = new classAutoMaintain();
    $ctpam = new classTutupPoinAutoMaintain();
    $obj = new classRekening();
    $bank = $obj->index();

    $cek_tupo_bulan_ini      = $ctpam->cek_id($session_member_id);
	$saldo_capaian_bulan_ini = $cam->index_tupo($session_member_id, date('Y-m', time()));
	$saldo_capaian_tupo      = $cam->get_max_auto('nominal_automaintain');
	$kekurangan_saldo 		 = $saldo_capaian_tupo - $saldo_capaian_bulan_ini;
?>

<?php include("view/layout/header.php"); ?>

<!-- loader section -->
<?php include("view/layout/loader.php"); ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include("view/layout/sidebar.php"); ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .bonus-list {
        width: 100%;
    }

    .bonus-item {
        width: 100%;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed">
        <div class="row">
            <?php include("view/layout/back.php"); ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-0" id="blockFirstForm">
        <div class="row">
            <div class="col-12">
              <?php
                if($cek_tupo_bulan_ini){
                    if(($saldo_capaian_tupo - $saldo_capaian_bulan_ini) > 0){
                ?>
                <div class="card mb-4 rounded-10 border-0 border-bottom bg-warning">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="mb-0 size-11">Saldo Capaian</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($saldo_capaian_tupo,0,',','.');?>
                                </p>
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-11">Saldo Automaintain</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($saldo_capaian_bulan_ini,0,',','.');?>
                                </p>
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-11">KekuranganTupo</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($kekurangan_saldo,0,',','.');?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <form class="form-horizontal" method="post"
                            action="controller/automaintain/tupo_automaintain.php" id="formTopup">
                            <input type="hidden" name="token" value="<?=$token;?>">
                            <div class="form-group form-floating-2 mb-0">
                                <input type="hidden" id="nominal" name="nominal" value="<?=$kekurangan_saldo?>">
                                <input type="text" class="form-control" id="total_transfer" name="total_transfer" readonly="readonly" required="required" value="Rp<?=number_format($kekurangan_saldo,0,',','.');?>">
                                <label class="form-control-label">Total Transfer</label>
                            </div>
                            
                            <div class="form-group form-floating-2 mb-0">
                                <select class="form-control" id="rekening" name="rekening">
                                    <option value="">Pilih Bank</option>
                                    <?php 
                                    while ($row   = $bank->fetch_object()) {
                                        echo "<option value='".$row->id."'>".$row->nama_bank."</option>";
                                    }
                                    ?>
                                </select>
                                <label for="" class="form-control-label">Pilih Bank</label>
                            </div>
                            <p class="text-muted size-12">Note: Bank yang sudah Anda pilih tidak dapat diubah, karena digunakan untuk pengecekan pembayaran Tutup Poin.</span>
                                
                            <div class="col-12 mt-4 text-end">
                                <button type="button" class="btn btn-lg btn-outline-default rounded-pill px-4">Batalkan</button>
                                <button type="submit" class="btn btn-lg btn-default rounded-pill px-5" id="btnTransfer">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
                    <?php
                    }else{
                    ?>
                    <p class="mb-0 size-14">Anda sudah tutup poin bulan ini.</p>
                <?php
                    }
                } else {
                    ?>
                    <p class="mb-0 text-theme size-14">Tidak ada data.</p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="main-container container pt-0 mb-2" id="blockFirstForm2" style="display:none">
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
                            class="btn btn-default btn-block btn-lg rounded-pill px-5 order-xs-first mb-3"
                            id="btnKonfirmasi">KONFIRMASI</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("view/auth/form_cek_pin.php"); ?>
</main>
<!-- Page ends-->
<?php include("view/layout/nav-bottom.php"); ?>
<?php include("view/layout/assets_js.php"); ?>
<script src="assets/js/jquery.isotope.min.js"></script>
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
        
        btnTransfer.on("click", function (e) {
            e.preventDefault();
            var nominal = parseInt($('#nominal').val());
            var rekening = $('#rekening').val();
            if(nominal >= 0){
                if(rekening != ""){
                    var e = $(this);
                    var dataString = $('#formTopup').serialize();
                    $.ajax({
                        type: 'POST',
                        url: 'controller/automaintain/cek_topup.php',
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
                    text: 'Nominal Topup minimal Rp30.000,-',
                    customClass: {
                        confirmButton: 'btn-default rounded-pill px-5'
                    }
                });
            }
        });

        btnKonfirmasi.on("click", function (e) {
            e.preventDefault();
            blockFirstForm2.hide();
            blockNextForm.show();
        });

        btnKembali.on("click", function (e) {
            e.preventDefault();
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
                        var redirect_url = 'invoice_tupo';
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'tutup_poin_automaintain';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function () {
                    loader_close();
                }
            });
            e.preventDefault();
        });
        
    });
</script>
<?php include("view/layout/footer.php"); ?>