<?php 
    require_once '../model/classUndianPemenang.php';
    $obj = new classUndianPemenang();
    $periode = $obj->periode();
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
            if($periode->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua Pemenang
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".1"
                            style="width:auto">
                            Pemenang Bulanan
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".2"
                            style="width:auto">
                            Pemenang 3 Bulanan
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".3"
                            style="width:auto">
                            Pemenang Tahunan
                        </button>
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($data = $periode->fetch_object()){
                ?>
                    <div class="card mb-2 rounded-0 border-0 border-bottom bonus-item <?=$data->id?>">
                        <div class="card-header">
                            <h4 class="size-16">Undian <?=$data->undian?></h4>
                            <h5 class="size-12">Periode : <?=tgl_indo($data->start_date)?> s/d <?=tgl_indo($data->end_date)?></h5> 
                        </div>
                        <div class="card-body">
                            <?php
                                $pemenang_undian = $obj->index($data->id, $data->periode);
                                $no = 0;
                                while ($pemenang = $pemenang_undian->fetch_object()) {
                                    $no++;
                            ?>
                            <div class="row p-2">            
                                <div class="col align-self-center">
                                    <p class="size-14"><?=$no?>. <?=$pemenang->id_member?> - <?=$pemenang->nama_member?></p>                     
                                </div>            
                                <div class="col-auto text-end align-self-center">
                                    <p class="size-14"><?=$pemenang->kupon_id?></p>                     
                                </div>
                            </div>
                            <?php 
                                }
                            ?>     
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada pemenang.</span></p>

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