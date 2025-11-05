<?php 
    require_once '../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    $omset_penjualan_lahan = $cka->omset_penjualan_lahan('365');
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .data-list{
        width: 100%;
    }
    .data-item{
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
    <div class="main-container bg-white container pt-0">
        <div class="row">
            <div class="col">
                <?php
            if($omset_penjualan_lahan->num_rows > 0) {
            ?>
                <ul class="list-group list-group-flush bg-none">
                    <?php
                    while ($row = $omset_penjualan_lahan->fetch_object()){
                    ?>
                    <li class="list-group-item py-2">
                        <div class="row">
                            <div class="col-auto">
                                <div
                                    class="avatar avatar-30 shadow rounded-circle my-1 bg-dark text-white">
                                    <i class="fal fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <p class="size-12 mb-0">
                                    <?=tgl_indo($row->tgl_omset)?>
                                </p>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="size-12 mb-0">
                                    <?=rp($row->total_omset)?></p>
                            </div>
                        </div>
                    </li>
                    <?php
                        }
                        ?>
                </ul>
                <?php
            } else {
            ?>
                <div class="row py-4">
                    <div class="col text-center ps-0">
                        <p class="mb-0"><span class="text-muted size-12">Belum ada omset.</span></p>

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
<?php include 'view/layout/footer.php'; ?>