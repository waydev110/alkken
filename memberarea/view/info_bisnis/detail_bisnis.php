<?php
require_once '../model/classMember.php';
require_once '../model/classPaket.php';
require_once '../model/classPlan.php';

$cm = new classMember();
$p = new classPaket();
$cpl = new classPlan();

$member = $cm->detail($session_member_id);
$plan_register = $cpl->plan_register();
?>
<?php include 'view/layout/header.php'; ?>
<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->

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

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">

        <!-- user information -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Paket</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->nama_plan ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Nama Lengkap</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->nama_member ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">ID Member</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->id_member ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Nama Samaran</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->nama_samaran ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Username</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->user_member ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Nomor WA</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->hp_member ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Tanggal Bergabung</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= tgl_indo($member->created_at) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted"><?= $lang['sponsor'] ?></p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme">
                            <?= $member->sponsor == 'master' ? 'Master' : $member->nama_sponsor . ' (' . $member->id_sponsor . ')' ?>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Nomor WA <?= $lang['sponsor'] ?></p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->sponsor == 'master' ? 'Master' : $member->hp_sponsor ?>
                        </p>
                    </div>
                </div>
                <?php
                if ($_binary == true) {
                ?>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Upline</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme">
                                <?= $member->upline == 'master' ? 'Master' : $member->nama_upline . ' (' . $member->id_upline . ')' ?>
                            </p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <p class="text-muted">Nomor WA Upline</p>
                        </div>
                        <div class="col-auto text-end">
                            <p class="text-color-theme"><?= $member->upline == 'master' ? 'Master' : $member->hp_upline ?></p>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Paket Bergabung</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $member->nama_plan ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">Maksimal Pasangan Harian</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= $cm->maks_flush_in($member->id_plan) ?>/hari</p>
                    </div>
                </div>
                <!--<div class="row mb-3">-->
                <!--    <div class="col">-->
                <!--        <p class="text-muted">Maksimal Penarikan</p>-->
                <!--    </div>-->
                <!--    <div class="col-auto text-end">-->
                <!--        <p class="text-color-theme"><?= rp($member->maximal_wd) ?>/hari</p>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <h6 class="title">Statistik Member</h6>
            </div>
        </div>
        <div class="card shadow-sm pt-2 mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <p class="text-muted">TOTAL</p>
                    </div>
                    <div class="col-auto text-end">
                        <p class="text-color-theme"><?= currency($member->jumlah_kiri) ?> | <?= currency($member->jumlah_kanan) ?></p>
                    </div>
                </div>
                <?php
                if ($_binary == true) {
                    while ($row = $plan_register->fetch_object()) {
                        $jumlah_kiri = 0;
                        $jumlah_kanan = 0;
                        $jumlah_member_plan = $cm->jumlah_member($session_member_id, $row->id);
                        if ($jumlah_member_plan) {
                            $jumlah_kiri = $jumlah_member_plan->jumlah_kiri;
                            $jumlah_kanan = $jumlah_member_plan->jumlah_kanan;
                        }
                ?>
                        <div class="row mb-3">
                            <div class="col">
                                <p class="text-muted"><?= $row->nama_plan ?></p>
                            </div>
                            <div class="col-auto text-end">
                                <p class="text-color-theme"><?= currency($jumlah_kiri) ?> | <?= currency($jumlah_kanan) ?></p>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<?php include 'view/layout/footer.php'; ?>