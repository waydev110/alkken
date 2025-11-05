<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classBonusReward.php';
    $obj = new classBonusReward();
    $results = $obj->index($session_member_id);
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
            if($results->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua Status
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status0"
                            style="width:auto">
                            Pending
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status1"
                            style="width:auto">
                            Diproses
                        </button>
                        <!-- <button class="btn-category swiper-slide tag" type="button" data-filter=".status3"
                            style="width:auto">
                            Dikirim
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status4"
                            style="width:auto">
                            Selesai
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status2"
                            style="width:auto">
                            Ditolak
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status5"
                            style="width:auto">
                            Dibatalkan
                        </button> -->
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($row = $results->fetch_object()){
                    $tanggal = $row->status == '0' ? $row->created_at : $row->updated_at;
                    $tanggal_order = $row->created_at;
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item status<?=$row->status?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto align-self-center">
                                    <div class="avatar avatar-50 pe-0 shadow-1">
                                        <img src="../images/reward/<?=$row->gambar?>" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="text-default fw-bold mb-0 size-16">
                                        <?=$row->reward?>
                                    </p>
                                    <p class="text-theme fw-bold mb-0 size-14">
                                        <?=poin($row->poin)?>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
                                    <p class="mt-4 mb-0 text-muted size-12 end"><?=vstatus_order($row->status)?></p>
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
                                <p class="mb-0"><span class="text-muted size-12">Data kosong.</span></p>

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

    function batalkan_pesanan(id) {
        Swal.fire({
            title: 'Apakah anda yakin ingin membatalkan pesanan ini?',
            showCancelButton: true,
            confirmButtonText: 'Ya, Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "controller/member_order/batalkan_pesanan.php",
                    data: {
                        id: id
                    },
                    type: "POST",
                    beforeSend: function () {
                        loader_open();
                    },
                    success: function (result) {
                        const obj = JSON.parse(result);
                        if (obj.status == true) {
                            document.location="?go=riwayat_order";
                        }
                    },
                    complete: function () {
                        loader_close();
                    }
                });
            }
        })
    }
</script>
<?php include 'view/layout/footer.php'; ?>