<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classKodeAktivasi.php';
    $obj = new classKodeAktivasi();
    $list_pin = $obj->stok_pin($session_member_id, 1);
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
            if($list_pin->num_rows > 0) {
            ?>
                <div class="swiper-container pin-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".1" style="width:auto">
                            Sudah Aktif
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".0" style="width:auto">
                            Belum Aktif
                        </button>
                    </div>
                </div>
                <div class="pin-list">
                    <?php
                while($row = $list_pin->fetch_object()){
                    $tanggal = $row->created_at;
                    $updated_at = $row->updated_at;
                ?>
                    <div class="card mb-3 rounded-0 pin-item <?=$row->status_aktivasi?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="mb-0"><span class="text-default size-12"><?=tgl_indo($tanggal)?> <?=jam($tanggal)?>
                                        </span></p>
                                    <p>
                                        <span
                                            class="text-default fw-bold mb-1 size-20"><?=rp($row->harga)?></span>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right text-end">
                                    <p class="mb-0"><span class="text-default size-12"><?=tgl_indo($updated_at)?> <?=jam($updated_at)?>
                                        </span></p>
                                    
                                    <p class="tag text-white px-2 py-1 bg-<?=$row->status_aktivasi == '1' ? 'success' : 'dark'?> mb-0">
                                        <span class="text-default size-10"><?=$row->status_aktivasi == '1' ? 'Sudah Aktif' : 'Belum Aktif'?>
                                        </span></p>
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
                                <p class="mb-0"><span class="text-muted size-12">Tidak memiliki <?=$lang['kode_aktivasi']?> RO.</span></p>

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
        $('.filter-button-group').on('click', '.btn-category', function () {
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