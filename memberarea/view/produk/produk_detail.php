<?php
if (isset($_GET['produk'])) {
    $slug = $_GET['produk'];
}
require_once '../model/classProduk.php';
require_once '../model/classProdukImage.php';

$cp = new classProduk();
$cpi = new classProdukImage();
$product = $cp->show_produk($slug);
$images = $cpi->index($product->id);
?>
<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/style-product.css">

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<style>
    .img-select {
        overflow: hidden;
        /* Hindari scroll horizontal */
    }

    .swiper {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .swiper-wrapper {
        display: flex;
        flex-wrap: nowrap;
    }


    .swiper-slide img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
    }

    .thumb-swiper .swiper-slide {
        opacity: 0.5;
        cursor: pointer;
    }

    .thumb-swiper .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid #f1bb53;
        border-radius: 0.6rem !important;
    }

    .show-all {
        color: #979797;
        text-decoration: underline;
    }

    #keterangan {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        max-height: 20px;
        /* Batasi tinggi untuk baris pertama */
        transition: all 0.3s ease;
    }

    #keterangan.expand {
        max-height: none;
        /* Menghilangkan batasan saat terbuka */
    }
    #link_promosi {
        color: #007AFF;
        text-decoration: underline;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center text-left">
                <h5><?= $title ?></h5>
            </div>
            <?php include 'view/layout/cart.php'; ?>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col-12 col-md-5 mb-4">
                <div class="product-imgs">
                    <!-- Swiper Main -->
                    <div class="swiper main-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="rounded-6 w-100" src="../images/produk/<?= $product->gambar ?>" alt="image">
                            </div>
                            <?php while ($row = $images->fetch_object()) { ?>
                                <div class="swiper-slide">
                                    <img class="rounded-6 w-100" src="../images/produk/<?= $row->gambar ?>" alt="<?= $row->gambar ?>">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination mt-2"></div>
                    </div>

                    <!-- Swiper Thumbs -->
                    <div class="swiper thumb-swiper mt-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="rounded-6 w-100" src="../images/produk/<?= $product->gambar ?>" />
                            </div>
                            <?php
                            $images->data_seek(0);
                            while ($row = $images->fetch_object()) { ?>
                                <div class="swiper-slide">
                                    <img class="rounded-6 w-100" src="../images/produk/<?= $row->gambar ?>" />
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <div class="product-title">
                    <h1 class="mb-0"><?= $product->nama_produk ?></h1>
                </div>
                <h3 class="new-price mt-0 size-18"><span><?= rp($product->harga) ?></span></h3>
                <div class="product-detail mt-4 mb-4">
                    <p class="mb-0">Netto : <?= $product->qty . ' ' . $product->satuan ?></p>
                    <p class="mt-2">Deskripsi Produk :</p>
                    <?= $product->keterangan ?>
                    <p class="mt-4">Qty :</p>
                    <input type="number" class="form-control rounded-pill" name="qty" id="qty" value="1">
                </div>
                <div class="row">
                    <div class="col-md-6 d-grid order-lg-2">
                        <button type="button" class="btn btn-default btn-lg shadow-sm rounded-pill"
                            onclick="addToCart('<?= $product->id ?>')"><i class="fa-solid fa-cart-plus"></i> Tambahkan</button>
                    </div>
                    <div class="col-md-6 d-grid order-lg-1">
                        <a href="?go=product" class="btn btn-light btn-lg shadow-sm rounded-pill"><i
                                class="fa-solid fa-arrow-left"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
</main>
<!-- Page ends-->
<?php include 'view/layout/assets_js.php'; ?>

<script>
    $('#toggleDescription').on('click', function() {
        $('#keterangan').toggleClass('expand');

        if ($('#keterangan').hasClass('expand')) {
            $(this).text('Sembunyikan');
        } else {
            $(this).text('Lihat Semua');
        }
    });
    var thumbSwiper = new Swiper(".thumb-swiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            768: {
                slidesPerView: 4
            },
            1024: {
                slidesPerView: 4
            }
        }
    });

    var mainSwiper = new Swiper(".main-swiper", {
        spaceBetween: 10,
        loop: true,
        // pagination: {
        //     el: ".swiper-pagination",
        //     clickable: true,
        // },
        thumbs: {
            swiper: thumbSwiper,
        },
    });
    function addToCart(id_produk) {
        var qty = $("#qty").val();
        $.ajax({
            url: "controller/member_order/add_to_cart.php",
            data: {
                id_produk: id_produk,
                qty: qty
            },
            type: "POST",
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.count-indicator').text(obj.count);
                }
            },
            complete: function() {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>