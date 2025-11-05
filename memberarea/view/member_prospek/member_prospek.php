<?php 
    require_once '../model/classMemberProspek.php';
    $cm = new classMemberProspek();
    $member_prospek = $cm->index($session_member_id);
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
            if($member_prospek->num_rows > 0) {
            ?>
                <div class="bonus-list">
                    <?php
                while($row = $member_prospek->fetch_object()){
                    $tanggal = $row->created_at;
                ?>
                    <div class="card mb-3 rounded-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p>
                                        <span
                                            class="text-default fw-bold mb-0 size-18"><?=$row->nama_member?></span>
                                    </p>
                                    <p class="size-12">
                                        Nomor HP : <a href="https://wa.me/<?=$row->hp_member?>" target="_blank"><?=$row->hp_member?></a>
                                    </p>
                                    <p class="size-12">
                                        Produk : <?=$row->nama_produk?>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <span class="mb-0 text-muted size-12">Tanggal Daftar Online</span>
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada member prospek.</span></p>

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
<script>
    $(document).ready(function () {
    });
</script>
<?php include 'view/layout/footer.php'; ?>