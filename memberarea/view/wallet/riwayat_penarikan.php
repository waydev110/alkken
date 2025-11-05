<?php 
    require_once ("../model/classMember.php");
    $cm = new classMember();
    require_once ("../model/classWithdraw.php");
    $cwd = new classWithdraw();
    $data = $cwd->index_member($session_member_id, 'cash');
?>
<?php require_once("view/layout/header.php"); ?>

<!-- loader section -->
<?php require_once("view/layout/loader.php"); ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php require_once("view/layout/sidebar.php"); ?>

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
    <header class="header bg-theme position-fixed">
        <div class="row">
            <?php require_once("view/layout/back.php"); ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-5">
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
                    $tanggal = $row->status_transfer == '0' ? $row->created_at : $row->updated_at;
                    $member = $cm->detail($row->id_member);
                ?>
                    <div class="card mb-3 data-item <?=$row->status_transfer?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p>
                                        <div class="avatar avatar-30 bg-primary text-white shadow-sm rounded-1">
                                            <i class="fa-solid fa-money-simple-from-bracket"></i>
                                        </div>
                                        <span class="text-default fw-bold mb-1 size-18"><?=rps($row->total)?></span>
                                    </p>
                                    <p class="m-0 p-0 lh-xs"><span
                                            class="text-muted size-10"><?=strtoupper($member->atas_nama_rekening)?></span>
                                    </p>
                                    <p class="m-0 p-0 lh-xs">
                                        <div class="avatar avatar-20 rounded-circle bg-light text-dark size-12"><i
                                                class="fa-light fa-building-columns"></i></div>
                                        <span class="text-muted size-11"><?=$member->nama_bank?> -
                                            <?=$member->no_rekening?></span>
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
<?php require_once("view/layout/nav-bottom.php"); ?>
<?php require_once("view/layout/assets_js.php"); ?>
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
<?php require_once("view/layout/footer.php"); ?>