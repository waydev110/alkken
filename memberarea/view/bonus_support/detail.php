<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classBonusSupport.php';
    $obj = new classBonusSupport();
    if(!isset($_GET['id'])){
        redirect('bonus_support');
    }
    $id_autosave = $_GET['id'];
    $data = $obj->index($session_member_id, $id_autosave);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .data-list {
        width: 100%;
    }

    .data-item {
        width: 100%;
    }

    th,
    td {
        font-size: 11px;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">
            <?php
            if($data) {
            ?>
                <div class="data-list">
                <?php
                $periode = $data->periode;
                $tanggal = $data->created_at;
                $no = 0;
                while($no < $periode) {
                    $no++;
                    $tanggal = date("Y-m-d", strtotime("+1 month",  strtotime($tanggal)));
                    $bulan = date('Y-m', strtotime($tanggal));
                    $bonus = $obj->show($session_member_id, $id_autosave, $bulan);
                    if($bonus){
                        $nominal = $bonus->nominal;
                        if($bonus->status_transfer == '0'){
                            $status_rekap = 0;
                        } else if($bonus->status_transfer == '1') {
                            $status_rekap = 1;
                        } else if($bonus->status_transfer == '2') {
                            $status_rekap = 2;
                        } else {
                            $status_rekap = 3;
                            $maks++;
                        }
                    } else {
                        $nominal = $data->nominal;
                        $status_rekap = 0;
                    }

                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="row">
                                        <div class="col-auto align-self-center pe-0">
                                            <div class="avatar avatar-30 bg-theme text-white rounded-pill"><?=$no?></div>
                                        </div>
                                        <div class="col align-self-center">
                                            <p class="mb-0 text-dark size-13"><?=tgl_indo($tanggal)?></p>
                                            <p class="mb-0 text-dark size-13">Bonus Support</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center text-end">
                                    <p class="text-default fw-bold mb-3 size-18"><?=rps($nominal)?></p>
                                    <?=vstatus_rekap($status_rekap)?>
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
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada bonus.</span></p>
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
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<?php include 'view/layout/footer.php'; ?>