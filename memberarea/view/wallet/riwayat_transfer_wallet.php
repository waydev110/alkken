<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classWalletTransfer.php';
    $cwt = new classWalletTransfer();
    $data = $cwt->index_member($session_member_id, 'cash');
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
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">
                <?php
            if($data->num_rows > 0) {
            ?>
                <div class="data-list">
                    <?php
                while($row = $data->fetch_object()){
                    $tanggal = $row->created_at;
                    $member = $cm->detail($row->id_member);
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom data-item <?=$row->status_transfer?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p>
                                        <div class="avatar avatar-30 bg-primary text-white shadow-sm rounded-1">
                                            <i class="fa-solid fa-arrows-left-right"></i>
                                        </div>
                                        <span class="text-default fw-bold mb-1 size-18"><?=rp($row->jumlah)?></span>
                                    </p>
                                    <p class="m-0 p-0 lh-xs">
                                        <span class="text-muted size-10"><?=jenis_saldo($row->jenis_saldo_asal)?> ke <?=jenis_saldo($row->jenis_saldo_tujuan)?></span>
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