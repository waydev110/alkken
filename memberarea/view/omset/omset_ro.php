<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    $omset = $cm->omset_ro_member($session_member_id);
    $history_omset = $cm->history_omset_ro_member($session_member_id);
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

            <div class="col-12">
                <div class="card mb-3 bg-white">
                    <div class="card-body p-2">
                        <div class="row mb-2">
                            <div class="col-auto">
                                <div class="avatar avatar-40 bg-danger text-white shadow-sm rounded-10">
                                    <i class="fa-solid fa-box-open-full"></i>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <p class="mb-0 text-danger">Omset Staking</p>
                            </div>
                        </div>
                        <div class="row mb-2 position-relative">
                            <div class="col pe-0">
                                <div class="form-group form-floating-2">
                                    <input type="text" class="form-control pt-3 pb-2 text-left"
                                        value="<?=currency($omset->omset_kiri)?>" disabled="disabled">
                                    <label class="form-control-label">Kiri</label>
                                </div>
                            </div>
                            <div class="col align-self-center ps-0">
                                <div class="form-group form-floating-2">
                                    <input type="text" class="form-control pt-3 pb-2 text-end"
                                        value="<?=currency($omset->omset_kanan)?>" disabled="disabled">
                                    <label class="form-control-label text-end pe-1 end-0 start-auto">Kanan</label>
                                </div>
                            </div>
                            <button
                                class="btn btn-34 bg-danger text-white shadow-sm position-absolute start-50 top-50 translate-middle">
                                <i class="fa-duotone fa-check-double"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <?php
            if($history_omset->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua Omset Staking 
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".kiri"
                            style="width:auto">
                            Omset Staking Kiri
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".kanan"
                            style="width:auto">
                            Omset Staking Kanan
                        </button>
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($row = $history_omset->fetch_object()){
                    $tanggal = $row->created_at;
                    $dari_member = $cm->detail($row->dari_member);
                ?>
                    <div class="card mb-3 bonus-item <?=$row->posisi?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <span class="mb-0 text-default size-12">Omset Staking <?=$row->nama_peringkat?> <strong><?=ucfirst($row->posisi)?></strong> dari <?=$dari_member->nama_member?></span>
                                    <p>
                                        <span
                                            class="text-default fw-bold mb-0 size-18"><?=currency($row->omset)?></span>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada omset.</span></p>

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

        var bonusSwiper = new Swiper(".bonus-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        var $grid = $('.bonus-list').isotope({
            // options...
            itemSelector: '.bonus-item',
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