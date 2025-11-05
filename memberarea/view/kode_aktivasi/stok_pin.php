<?php
require_once '../model/classKodeAktivasi.php';
$obj = new classKodeAktivasi();

$stok_pin = $obj->stok_pin_new($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .pin-list {
        width: 100%;
    }

    .pin-item {
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
                <h5><?= $title ?></h5>
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
                if ($stok_pin->num_rows > 0) {
                ?>
                    <!-- <div class="card">
                        <div class="card-body rounded-10 bg-theme text-white">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="text-theme-color fw-semibold mb-0 size-18">Jenis PIN</p>
                                </div>
                                <div class="col-auto align-self-right text-end">
                                    <p class="text-theme-color fw-semibold mb-0 size-18">Stok PIN</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="pin-list">
                        <?php
                        while ($row = $stok_pin->fetch_object()) {
                        ?>
                            <div class="card pin-item mt-2">
                                <div class="card-body rounded-10 px-3 py-2">
                                    <div class="row">
                                        <div class="col-auto align-self-center pe-0">
                                            <img src="../images/plan/<?=$row->gambar?>" alt="" width="60">
                                        </div>
                                        <div class="col align-self-center">
                                            <p class="text-primary fw-semibold mb-0 size-16">
                                               Paket <?= $row->nama_plan ?> </p>
                                            <p class="text-dark fw-semibold mb-0 size-12">
                                               <?= $row->jenis_produk ?> <?= $row->founder ?> </p>
                                            <p class="text-dark fw-semibold mb-0 size-12"><?= $row->reposisi == '0' ? 'Berbayar' : 'Reposisi' ?>
                                                </p>
                                        </div>
                                        <div class="col-auto align-self-center text-end">
                                            <p class="text-dark size-14 mb-0">Jumlah</p>
                                            <p class="mb-2 text-primary size-18 fw-semibold"><?= currency($row->total) ?></p>
                                            <!-- <a href="<?=site_url('stok_pin_detail')?>&paket=<?=$row->id?>" class="btn btn-sm btn-default rounded-pill px-3">Detail PIN</a> -->
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
                                    <p class="mb-0"><span class="text-muted size-12">Tidak memiliki <?= $lang['kode_aktivasi'] ?></span></p>

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
    $(document).ready(function() {

        var pinSwiper = new Swiper(".pin-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        var $grid = $('.pin-list').isotope({
            // options...
            itemSelector: '.pin-item',
            layoutMode: 'vertical',
        });

        // filter items on button click
        $('.filter-button-group').on('click', '.btn-category', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $('.btn-category').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
<?php include 'view/layout/footer.php'; ?>