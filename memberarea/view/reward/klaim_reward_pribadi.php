<?php

require_once '../model/classMember.php';
require_once '../model/classBonusRewardPaketSetting.php';
require_once '../model/classBonusRewardPaket.php';
require_once '../model/classProdukJenis.php';
require_once '../model/classKodeAktivasi.php';

$cm = new classMember();
$obj = new classBonusRewardPaketSetting();
$cbr = new classBonusRewardPaket();
$cpl = new classProdukJenis();
$cka = new classKodeAktivasi();

if (isset($_GET["plan_reward"])) {
    $id_produk_jenis = $_GET["plan_reward"];
} else {
    // redirect('404');
}
$produk_jenis = $cpl->show($id_produk_jenis);
if(!$produk_jenis){
    // redirect('404');
}

$member = $cm->detail($session_member_id);
$poin_reward = $cbr->jumlah_poin_reward_pribadi($session_member_id, $id_produk_jenis);
$data_reward = $obj->index($id_produk_jenis);
if ($produk_jenis->reward_sponsor_wajib_ro == '1') {
    $cek_last_ro = $cka->cek_last_ro($session_member_id);
} else {
    $cek_last_ro = true;
}
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

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
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?= $title ?> <?= $produk_jenis->nama_reward_sponsor ?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <?php if (!$cek_last_ro) { ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-danger text-white text-center">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <h1>Reward Terkunci</h1>
                                    <p class="size-12 text-muted">
                                        Silahkan posting ro terlebih dahulu untuk dapat mengklaim reward anda.
                                    </p>
                                    <a href="?go=posting_ro" class="tag border-dashed border-opac text-white">
                                        POSTING RO SEKARANG
                                    </a>
                                </div>
                                <div class="col-4 align-self-center ps-0">
                                    <img src="assets/img/intro4.png" alt="" class="mw-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col">

                <?php
                if ($data_reward->num_rows > 0) {
                ?>
                    <div class="table-list">
                        <?php
                        $no = 0;
                        while ($row = $data_reward->fetch_object()) {
                            $no++;
                            if ($cek_last_ro) {
                                $bonus_reward = $cbr->bonus_reward($session_member_id, $row->id);
                                if ($bonus_reward) {
                                    if ($bonus_reward->status_transfer == '1') {
                                        $status = 'Ditransfer';
                                        $color = 'success';
                                        $icon = 'fa-check';
                                    } else {
                                        $status = 'Diklaim';
                                        $color = 'warning';
                                        $icon = 'fa-history';
                                    }
                                } else {
                                    $status = 'Pending';
                                    $color = 'dark';
                                    $total_bonus = 0;
                                    $icon = 'fa-loader';
                                }
                            } else {
                                $poin_reward = 0;
                                $total_bonus = 0;
                                $status = 'Terkunci';
                                $color = 'danger';
                                $icon = 'fa-lock';
                            }
                            if ($row->jenis == '0') {
                                $nominal = rp($row->nominal);
                            } else if ($row->jenis == '1') {
                                $nominal = poin($row->nominal);
                            } else {
                                $nominal = $row->reward;
                            }
                        ?>

                            <div class="card mb-0 rounded-0 border-0 border-bottom">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-auto align-self-center">
                                            <div class="avatar avatar-36 bg-white text-dark shadow-sm rounded-10">
                                                <?= $no ?>
                                            </div>
                                        </div>
                                        <div class="col align-self-center ps-0">
                                            <h5 class="mb-0 text-primary fw-bold"><?= $nominal ?></h5>
                                        </div>
                                        <div class="col-auto align-self-center text-end">
                                            <?php if ($poin_reward >= $row->poin && $status == 'Pending') {
                                            ?>
                                                <button type="button" class="btn btn-sm btn-primary rounded-pill" onclick="KlaimReward('<?= $row->id ?>')">Klaim
                                                    Reward</button>
                                            <?php
                                            } else {
                                            ?>
                                                <p class="mb-0 text-dark"><span class="tag bg-<?= $color ?> size-10 px-2 py-1 text-white"><strong><i class="fas <?= $icon ?>"></i> <?= $status ?></strong></span> <span class="size-11"></span> </p>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="row mb-2 position-relative">
                                        <div class="col">
                                            <div class="form-group form-floating-2">
                                                <div class="form-control pt-3 pb-2 text-left">
                                                    <span class="text-danger"><?= currency($poin_reward >= $row->poin ? $row->poin : $poin_reward) ?></span>
                                                    dari <?= currency($row->poin) ?>
                                                </div>
                                                <label class="form-control-label">Poin</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                } else {
                ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col text-center ps-0">
                                    <p class="mb-0"><span class="text-muted size-12">Data kosong.</span></p>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="main-container container pt-4 pb-4 mb-2" id="blockFirstForm2" style="display:none">
        <div class="card mb-4">
            <div class="card-body">
                <form action="controller/reward/klaim_reward_pribadi.php" id="formKlaimReward" method="post">
                    <input type="hidden" name="idreward" id="idreward" value="">
                    <div class="row">
                        <div class="col-12 text-center mb-2">
                            <div class="alert alert-danger" role="alert">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="text-center size-14 fw-normal">Konfirmasi klaim reward.</h5>
                                        <h5 class="text-center size-14 fw-normal">Anda yakin akan mencairkan Reward?</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center mb-4">
                            <div id="detail"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 align-self-center text-end mt-0 d-xs-grid">
                            <button type="button" class="btn btn-outline-default btn-lg rounded-pill px-4 mb-2" id="btnKembali">KEMBALI</button>
                            <button type="button" class="btn btn-default btn-lg rounded-pill px-5 order-xs-first mb-3" id="btnKonfirmasi">KONFIRMASI</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    var id_plan = '<?=$id_produk_jenis?>';
    var blockFirstForm = $('#blockFirstForm');
    var blockFirstForm2 = $('#blockFirstForm2');
    var blockNextForm = $('#blockNextForm');
    var formKlaimReward = $('#formKlaimReward');
    var formCekPIN = $('#formCekPIN');
    var btnKonfirmasi = $('#btnKonfirmasi');
    var btnKlaimReward = $('#btnKlaimReward');
    var btnKembali = $('#btnKembali');
    var detail = $('#detail');

    function KlaimReward(idreward) {
        if (idreward != "") {
            $.ajax({
                type: 'POST',
                url: 'controller/reward/cek_klaim_reward_pribadi.php',
                data: {
                    idreward: idreward
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        detail.html(obj.html);
                        $('#idreward').val(idreward);
                        blockFirstForm.hide();
                        blockFirstForm2.show();
                    } else {
                        Swal.fire({
                            text: obj.message,
                            customClass: {
                                confirmButton: 'btn-default rounded-pill px-5'
                            }
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                text: 'Terjadi kesalahan. Silahkan refresh halaman.',
                customClass: {
                    confirmButton: 'btn-default rounded-pill px-5'
                }
            });
        }
    }

    $(document).ready(function() {
        btnKembali.on("click", function(e) {
            blockFirstForm2.hide();
            blockFirstForm.show();
        });

        btnKonfirmasi.on("click", function(e) {
            blockFirstForm2.hide();
            blockNextForm.show();
            $('input[name=old_pin1]').focus();
            e.preventDefault();
        });

        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        formKlaimReward.submit();
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

        formKlaimReward.on("submit", function(e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            var idreward = $('#idreward').val();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        var redirect_url = 'klaim_reward_pribadi&plan_reward='+id_plan;
                        show_success_html(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'klaim_reward_pribadi&plan_reward='+id_plan;
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });

        $('.input_pin').keyup(function(e) {
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
                        $(this).delay(300).queue(function() {
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