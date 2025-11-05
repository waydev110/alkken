<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classWithdraw.php';
    $cwd = new classWithdraw();
    $data = $cwd->index_member_poin($session_member_id);
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
            if($data->num_rows > 0) {
            ?>
                <div class="swiper-container category-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:150px">
                            Semua Status
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".0"
                            style="width:150px">
                            Pending
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".1"
                            style="width:150px">
                            Berhasil
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".2"
                            style="width:150px">
                            Ditolak
                        </button>
                    </div>
                </div>
                <div class="data-list">
                    <?php
                while($row = $data->fetch_object()){
                    $member = $cm->detail($session_member_id);
                    $tanggal = $row->status_transfer == '0' ? $row->created_at : $row->updated_at;
                    if($row->jenis_penarikan == 'market'){
                        $label = 'Username Marketplace';
                        $address = $member->username_marketplace;
                    } else {
                        $label = 'Address Coin';
                        $address = $member->address_coin;
                    }
                ?>
                    <div class="card mb-3 data-item <?=$row->status_transfer?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <?php if($row->jenis_penarikan == 'coin') {?>
                                    <p>
                                        <span class="text-default fw-bold mb-1 size-18"><?=rps($row->total).$row->rate_coin?> = <?=$row->total_coin?></span>
                                    </p>
                                    <?php } else {
                                    ?>
                                    <p>
                                        <div class="avatar avatar-30 bg-primary text-white shadow-sm rounded-1">
                                            <i class="fa-solid fa-money-simple-from-bracket"></i>
                                        </div>
                                        <span class="text-default fw-bold mb-1 size-18"><?=rps($row->total)?></span>
                                    </p>
                                    <?php    
                                    }
                                    ?>
                                    <p class="m-0 p-0 lh-xs"><span
                                            class="text-muted size-10"><?=strtoupper($label)?></span>
                                    </p>
                                    <p class="m-0 p-0 lh-xs">
                                        <span class="text-danger fw-bold size-11"><?=$address?></span>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
                                    <p class="mb-0"><span
                                            class="text-muted size-12 end"><?=vstatus_bonus($row->status_transfer)?></span>
                                    </p>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada riwayat penarikan.</span></p>

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

        var categorySwiper = new Swiper(".category-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        var $grid = $('.data-list').isotope({
            // options...
            itemSelector: '.data-item',
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