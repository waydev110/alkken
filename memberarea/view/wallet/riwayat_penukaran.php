<?php 
    require_once '../model/classPenukaranPoin.php';
    $cpp = new classPenukaranPoin();
    $data = $cpp->index($session_member_id);
    
    require_once '../model/classPenukaranPoinDetail.php';
    $cppd = new classPenukaranPoinDetail();
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
                            Diproses
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".1"
                            style="width:150px">
                            Dikirim
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
                    $tanggal = $row->status == '0' ? $row->created_at : $row->updated_at;
                ?>
                    <div class="card mb-3 data-item <?=$row->status?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p>
                                        <div class="avatar avatar-30 bg-primary text-white shadow-sm rounded-1">
                                            <i class="fa-solid fa-gift"></i>
                                        </div>
                                        <span class="text-default fw-bold mb-1 size-18"><?=rp($cppd->sum($row->id))?></span>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
                                    <p class="mb-0"><span class="text-muted size-12 end"><?=vstatus_penukaran($row->status)?></span></p>
                                </div>
                            </div>
                            <div class="row d-block">
                                <div class="col-12">
                                    <a class="size-11 text-muted btn-detail" data-bs-toggle="collapse" href="#detail<?=$row->id?>"
                                        role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Detail Pesanan
                                    </a>
                                    <div class="collapse block-detail" id="detail<?=$row->id?>">
                                        <ul class="list-group list-group-flush">
                                            <?php
                                        $data_detail = $cppd->index($row->id);
                                        while($item = $data_detail->fetch_object()){
                                        ?>
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-auto">
                                                        <p>
                                                            <?=$item->nama_produk?>
                                                        </p>
                                                        <p class="tiny">
                                                            Harga :
                                                            <?=currency($item->harga_poin)?>x<?=$item->qty?>
                                                        </p>

                                                    </div>
                                                    <div class="col text-end">
                                                        <p class="tiny">
                                                            Jumlah
                                                        </p>
                                                        <p class="fw-bold">
                                                            <?=currency($item->harga_poin)?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </li>
                                            <?php
                                        }   
                                        ?>
                                        </ul>
                                        <?php
                                        if($row->status == '1'){
                                        ?>
                                        <div class="card mb-0">
                                            <div class="card-body">
                                                <h6 class="mt-2 size-11">#<?=$row->jasa_pengiriman?> - <?=$row->resi_pengiriman?></h6>
                                                <h6>Dikirim Ke Alamat:</h6>
                                                <div class="text-muted size-11 mt-2">
                                                    <h6><?=$row->nama_lengkap?></h6>
                                                    <p class="mb-0"><?=$row->no_telp?></p>
                                                    <p class="mb-0"><?=$row->alamat?> RT/RW : <?=$row->rtrw?> Kodepos : <?=$row->kodepos?></p>
                                                    <p class="mb-0"><?=$row->nama_kelurahan?> - <?=$row->nama_kecamatan?> - <?=$row->nama_kota?> -
                                                        <?=$row->nama_provinsi?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada riwayat penukaran.</span></p>

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
            percentPosition:true
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

        $('.block-detail').on('shown.bs.collapse', function() {
            $grid.isotope('layout');
        })

    });
</script>
<?php include 'view/layout/footer.php'; ?>