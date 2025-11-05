
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<?php
require_once '../model/classProduk.php';
require_once '../model/classProdukJenis.php';
$cpj = new classProdukJenis();
$obj = new classProduk();
$products = $obj->index();
$produk_jenis = $cpj->index();
$link_referral = 'https://netlife.id/'.$session_user_member;
if ($products->num_rows > 0) {
?>
    <style>
        .product-item {
            margin-bottom: 25px;
            padding: 10px;
            border: 0px solid #FFF;
            background-color: #FFF;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 6px 0px;
            -webkit-box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 6px 0px;
            -moz-box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 6px 0px;
        }

        .product-item img {
            border-radius: 0;
        }

        .product-item .title {
            font-size: 13px;
        }

        .product-item .price {
            font-size: 16px;
            font-weight: bold;
            color: #ee5b1e;
        }

        .img-banner {
            position: absolute;
            width: 140%;
            top: -50px;
        }

        .owl-item {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .product-item .btn-warning {
            background: #f64749;
            color: #FFF;
        }

        .product-item .btn-warning i {
            font-size: 12px !important;
        }
    </style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5><?=$title?></h5>
            </div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col-12">
                <div class="mu-product-area mt-4">
                    <div class="row">                    
                        <div class="col-12">
                            <div class="swiper-container product-swiper mb-3">
                                <div class="filter-button-group swiper-wrapper">
                                    <?php
                                    while($row = $produk_jenis->fetch_object()){
                                    ?>
                                    <button class="btn-category swiper-slide tag size-13 fw-normal <?=$row->id == '1' ? 'active' : ''?>" type="button" data-filter=".cat<?=$row->id?>"
                                        style="width:auto"><?=$row->name?>
                                    </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row isotope-list">
                        <!--<div class="owl-carousel owl-theme">-->
                        <?php
                        while ($product = $products->fetch_object()) {
                        ?>
                            <div class="col-md-3 col-6 isotope-item cat<?=$product->id_produk_jenis?>">
                                <div class="product-item">
                                    <img class="img-responsive" src="../images/produk/<?= $product->gambar ?>" alt="image" width="100%">
                                    <div class="mt-2 mb-2">
                                        <a href="?go=produk_detail&produk=<?= $product->slug ?>" class="title"><?= strtoupper($product->nama_produk) ?></a>
                                        <!--<h3 class="price">-->
                                            <?php 
                                                // echo rp($product->harga) 
                                            ?>
                                        <!--</h3>-->
                                    </div>
                                    <div class="row">
                                        <div class="col-auto align-self-center pe-0">
                                            <a href="https://api.whatsapp.com/send?text=Hallo kawan, ini ada informasi bisnis menarik, semoga bermanfaat buat kita semua, silahkan buka web saya ya <?=$link_referral?>" class="text-success"><i class="fab fa-whatsapp"></i></a>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$link_referral?>" class="text-primary" target="_blank"><i class="fab fa-facebook"></i></a>
                                            
                                        </div>
                                        <div class="col align-self-center">
                                            <div class="d-flex justify-content-end">
                                                <a href="?go=produk_detail&produk=<?= $product->slug ?>" class="btn btn-theme btn-sm shadow-sm rounded-pill">Detail Produk</a>
            
                                                <!-- <button type="button" class="btn btn-warning btn-sm shadow-sm rounded-pill" onclick="addToCart('<?= $product->id ?>')"><i class="fa-solid fa-cart-plus"></i></button> -->
                                            </div>
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
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>

<script>
    $(document).ready(function() {
        var productSwiper = new Swiper(".product-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false,
            breakpoints: {
                // ketika layar berukuran >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        var $grid = $('.isotope-list').isotope({
            itemSelector: '.isotope-item',
            layoutMode: 'fitRows',
        });

        $('.filter-button-group').on('click', '.btn-category', function() {
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
<?php
}
?>