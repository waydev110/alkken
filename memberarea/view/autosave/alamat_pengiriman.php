<?php 
    require_once '../model/classMemberAlamat.php';
    $obj = new classMemberAlamat();
    $address = $obj->index($session_member_id);
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
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <?php include 'view/layout/cart.php'; ?>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">  
                <?php 
                if($address->num_rows > 0) {
                ?>
                <div class="card mb-2 rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <div class="row">
                                    <div class="col-auto align-self-center pe-0">
                                        <div class="avatar avatar-30 bg-theme text-white rounded-pill"><?=$no?></div>
                                    </div>
                                    <div class="col align-self-center">
                                        <p class="mb-0 text-dark size-12">Paket <?=$nama_paket?></p>
                                        <p class="mb-0 text-dark size-13"><?=tgl_indo_hari($tanggal)?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto align-self-center text-end">
                                <p class="text-default fw-bold mb-3 size-18"><?=currency($nominal)?></p>
                                <?=vstatus_rekap($status_rekap)?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="card mb-3 rounded-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center ps-0">
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada alamat pengiriman.</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col"> 
            <div class="row">
                <a href="<?=site_url('tambah_alamat_pengiriman')?>" class="btn btn-default rounded-pill">Tambah Alamat</a>
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