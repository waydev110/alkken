<?php 
    require_once '../model/classMember.php';
    require_once '../model/classMemberOrder.php';
    $cm = new classMember();
    $obj = new classMemberOrder();
    $orders = $obj->index_member($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/style-product.css">
<link rel="stylesheet" href="assets/css/custom-memberarea.css">

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Sidebar main menu ends -->
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
            if($orders->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua Status
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status-1"
                            style="width:auto">
                            Menunggu Pembayaran
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status0"
                            style="width:auto">
                            Pending
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status1"
                            style="width:auto">
                            Diproses
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status2"
                            style="width:auto">
                            Dikirim
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status3"
                            style="width:auto">
                            Selesai
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status4"
                            style="width:auto">
                            Ditolak
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".status5"
                            style="width:auto">
                            Dibatalkan
                        </button>
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($row = $orders->fetch_object()){
                    $tanggal = $row->status == '0' ? $row->created_at : $row->updated_at;
                    $tanggal_order = $row->created_at;
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item status<?=$row->status?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <a href="?go=order_detail&id_order=<?=base64_encode($row->id)?>" class="size-11">Tanggal : <?=tgl_indo_jam($tanggal_order)?></a>
                                    <p class="text-muted fw-bold mb-0 size-12">
                                        <i class="fa fa-shop"></i> <?=$row->nama_stokis?> [<?=$row->nama_kota?>]
                                    </p>
                                    <p class="text-price fw-bold mb-0 size-18">
                                        <?=rp($row->nominal)?>
                                    </p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?php if($row->status == 2){ ?>
                                    <button class="btn btn-sm btn-default rounded-pill"
                                        onclick="konfirmasi_pesanan('<?=base64_encode($row->id)?>')">Konfirmasi
                                        Pesanan</button>

                                    <?php } else if($row->status <> '-1') { 
                                        echo vtgl_bonus(tgl_indo($row->updated_at), jam($row->updated_at));
                                    } else {
                                    ?>
                                    <button class="btn btn-sm btn-default rounded-pill"
                                        onclick="batalkan_pesanan('<?=base64_encode($row->id)?>')">Batalkan
                                        Pesanan</button>
                                    <a class="btn btn-sm btn-default rounded-pill"
                                        href="?go=pembayaran&id_order=<?=base64_encode($row->id)?>">Pembayaran</a>
                                    <?php
                                    }
                                    ?>
                                    <p class="mb-0"><span
                                            class="text-muted size-12 end"><?=vstatus_order($row->status)?></span></p>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada riwayat pesanan.</span></p>

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

    function konfirmasi_pesanan(id) {
        Swal.fire({
            title: 'Apakah anda yakin ingin konfirmasi pesanan ini?',
            showCancelButton: true,
            confirmButtonText: 'Ya, Selesai'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "controller/member_order/konfirmasi_pesanan.php",
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