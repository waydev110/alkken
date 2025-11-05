<?php

require_once '../model/classMember.php';
require_once '../model/classPlan.php';
require_once '../model/classKodeAktivasi.php';

$cm = new classMember();
$cpl = new classPlan();
$cka = new classKodeAktivasi();
$member = $cm->detail($session_member_id);
$id_plan = $member->id_plan;
$tingkat = $member->tingkat;
$plan = $cpl->index_upgrade($id_plan, $tingkat);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
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
                <h5><?= $title ?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->
    <?php
    if ($plan->num_rows > 0) {
    ?>
        <!-- main page content -->
        <div class="main-container container pt-4 pb-4" id="blockFirstForm">
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Upgrade Paket</h5>
                    <p class="text-center mb-2 text-muted size-14">Untuk dapat melakukan upgrade pastikan anda memiliki PIN Registrasi sesuai paket upgrade.</p>
                </div>
            </div>

            <div class="row mb-3">
                <?php
                while ($member_plan = $plan->fetch_object()) {
                    $max_pasangan = $member_plan->max_pasangan;
                    if ($member_plan->pasangan == '1') {
                        $bonus_pasangan = $member_plan->bonus_pasangan;
                    } else {
                        $setting = $cpl->show($member_plan->parent_pasangan);
                        if ($setting) {
                            $bonus_pasangan = $setting->bonus_pasangan;
                        } else {
                            $bonus_pasangan = 0;
                        }
                    }
                ?>

                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <div class="avatar mb-2 px-5">
                                    <img src="../images/plan/<?=$member_plan->gambar?>" alt="" width="100%">
                                </div>
                                <!-- <h1 class="size-18 mt-2"><?= $member_plan->nama_plan ?></h1> -->
                                <li class="list-group-item border-0 p-0 mb-2">
                                    <p class="text-dark size-14 mb-0">Maksimal Terpasang</p>
                                    <p class="price text-primary fw-bold size-16"><?= currency($max_pasangan) ?>/hari</p>
                                </li>
                                <li class="list-group-item border-0 p-0">
                                    <p class="text-dark size-14 mb-0">Potensi Bonus Pasangan</p>
                                    <p class="price text-primary fw-bold size-16"><?= currency($max_pasangan * $bonus_pasangan) ?>/hari</p>
                                </li>
                            </div>
                            <div class="card-footer d-grid p-2">
                                <?php
                                if ($id_plan == $member_plan->id) {
                                ?>
                                    <button class="btn btn-secondary rounded-pill">Paket anda saat ini</button>
                                <?php
                                } else {
                                ?>
                                    <?php
                                        $kode_aktivasi = $cka->index_member_upgrade($session_member_id, 0, $member_plan->id);
                                    ?>    
                                    <div class="form-group mb-4">
                                    <select class="form-control size-13" id="kodeaktivasi<?=$member_plan->id?>" name="kodeaktivasi">
                                        <option value="">-- Pilih PIN --</option>
                                        <?php
                                        while ($row   = $kode_aktivasi->fetch_object()) {
                                            echo "<option value='" . $row->id . "'>" . $row->nama_plan .' - '.$row->name. ' ' . $row->reposisi . ' ' . $row->founder . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <button class="btn btn-default rounded-pill" onclick="konfirmasi('<?= $member_plan->id ?>', '<?= $member_plan->nama_plan ?>')">Upgrade</button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <div class="main-container container pt-4 pb-4" style="display:none" id="blockKonfirmasi">
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Konfirmasi</h5>
                    <p class="text-center mb-2">Anda yakin akan melakukan upgrade paket. <?= $lang['kode_aktivasi'] ?> anda akan otomatis digunakan.</p>
                </div>
            </div>
            <form action="controller/member/upgrade_member.php" id="formUpgradeMember" method="post">
                <input type="hidden" id="id_upgrade" name="id_upgrade" value="">
                <input type="hidden" id="id_kodeaktivasi" name="id_kodeaktivasi" value="">
                <div class="row">
                    <div class="col-12 text-center">
                        <h5 class="text-center mb-2">Paket Upgrade</h5>
                        <h1 class="text-center size-32 mb-4" id="upgradeLabel"></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-grid mb-4">
                        <button type="button" class="btn btn-default btn-lg shadow-sm" id="btnUpgrade">Ya Upgrade Sekarang</button>
                    </div>
                    <div class="col-12 d-grid mb-4">
                        <a href="<?= site_url('index') ?>" class="btn btn-secondary btn-lg shadow-sm" id="btnUpdate">Batalkan</a>
                    </div>
                </div>
            </form>
        </div>
    <?php } else {
        $member_plan = $cpl->show($id_plan);
        $max_pasangan = $member_plan->max_pasangan;
        if ($member_plan->pasangan == '1') {
            $bonus_pasangan = $member_plan->bonus_pasangan;
        } else {
            $setting = $cpl->show($member_plan->parent_pasangan);
            if ($setting) {
                $bonus_pasangan = $setting->bonus_pasangan;
            } else {
                $bonus_pasangan = 0;
            }
        }
    ?>

        <div class="main-container container pt-4 pb-4">
            <div class="row">
                <div class="col-12 mb-3">
                    <h5 class="text-center mb-2">Paket anda sudah tertinggi</h5>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-3 col-md-6 col-sm-12 m-auto">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div class="avatar mb-2 px-5">
                                <img src="../images/plan/<?=$member_plan->gambar?>" alt="" width="100%">
                            </div>
                            <h1 class="size-18 mt-2"><?= $member_plan->nama_plan ?></h1>
                            <li class="list-group-item border-0 p-0 mb-2">
                                <p class="text-dark size-14 mb-0">Maksimal Terpasang</p>
                                <p class="price text-primary fw-bold size-16"><?= currency($max_pasangan) ?>/hari</p>
                            </li>
                            <li class="list-group-item border-0 p-0">
                                <p class="text-dark size-14 mb-0">Potensi Bonus Pasangan</p>
                                <p class="price text-primary fw-bold size-16"><?= currency($max_pasangan * $bonus_pasangan) ?>/hari</p>
                            </li>
                        </div>
                        <div class="card-footer d-grid">
                            <button class="btn btn-secondary rounded-pill">Paket anda saat ini</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php        } ?>
    <?php include 'view/auth/form_cek_pin.php'; ?>
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/select2/js/select2.min.js"></script>
<script>
    var blockFirstForm = $('#blockFirstForm');
    var blockKonfirmasi = $('#blockKonfirmasi');
    var blockNextForm = $('#blockNextForm');
    var formCekPIN = $('#formCekPIN');
    var formUpgradeMember = $('#formUpgradeMember');
    var btnUpgrade = $('#btnUpgrade');

    function konfirmasi(id, upgradeLabel) {

        var id_kodeaktivasi = $('#kodeaktivasi'+id).val();
        var nama_upgrade = $('#kodeaktivasi'+id+' option:selected').text();

        if(id_kodeaktivasi > 0){
            $('#upgradeLabel').text(nama_upgrade);
            $('#id_upgrade').val(id);
            $('#id_kodeaktivasi').val(id_kodeaktivasi);

            blockFirstForm.hide();
            blockKonfirmasi.show();
        } else {
            alert('PIN belum dipilih.');
        }
    }

    $(document).ready(function() {

        btnUpgrade.on("click", function(e) {
            blockKonfirmasi.hide();
            blockNextForm.show();
        });
        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        formUpgradeMember.submit();
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

        formUpgradeMember.on("submit", function(e) {
            var dataString = $(this).serialize();
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
                        var redirect_url = 'profil';
                        show_success(obj.message, redirect_url);
                    } else {
                        var redirect_url = 'profil';
                        show_error(obj.message, redirect_url);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
            e.preventDefault();
        });
        $('.select2').select2();
    });

    function aktivasi_pin() {
        $.ajax({
            url: 'controller/posting_ro/posting_ro_auto.php',
            type: 'post',
            success: function(result) {}
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>