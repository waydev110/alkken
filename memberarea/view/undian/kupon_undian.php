<?php 
    require_once '../model/classUndianKupon.php';
    $cuk = new classUndianKupon();
    $undian = $cuk->index_undian();
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
            if($undian->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua Kupon
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".1"
                            style="width:auto">
                            Kupon Bulanan
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".2"
                            style="width:auto">
                            Kupon 3 Bulanan
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".3"
                            style="width:auto">
                            Kupon Tahunan
                        </button>
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($row = $undian->fetch_object()){
                    $get_kupon_undian = $cuk->get_kupon_undian($session_member_id, $row->id);
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item <?=$row->id?>">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="text-theme size-12 mb-2"><?=$row->undian?></h5>
                                <?php 
                                if($get_kupon_undian->num_rows > 0){   
                                ?>                                
                                <div class="d-flex flex-wrap gap-2">
                                <?php
                                    while ($kupon = $get_kupon_undian->fetch_object()) {
                                ?>
                                    <span class="border-dark border-2 px-2 border-dashed text-center"><?=$kupon->kupon_id?></span> 
                                <?php 
                                    }
                                ?>                         
                                </div>
                                <?php
                                } else {
                                ?>
                                <div class="col-3">
                                    <p class="size-12 text-warning">Belum memiliki kupon.</p>
                                </div>
                                <?php 
                                }
                                ?>
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
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada undian.</span></p>

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