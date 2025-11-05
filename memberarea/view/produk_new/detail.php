<?php
if (!isset($_GET['produk'])) {
    redirect('404');
}

$slug = $_GET['produk'];
require_once '../model/classProduk.php';
require_once '../model/classProdukImage.php';

$cp = new classProduk();
$cpi = new classProdukImage();
$product = $cp->url_slug($slug);
if(!$product){
    redirect('404');
}
$images = $cpi->index($product->id);
?>
<?php include("view/layout/header.php"); ?>
<link rel="stylesheet" href="assets/css/style-product.css">

<?php include("view/layout/sidebar.php"); ?>
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
<main class="h-100 px-3 has-header">
    <?php include 'view/layout/back.php'; ?>
    <div class="main-container container pb-4 pt-4">
        <div class="card pt-0 rounded-0 shadow-none border-0">
            <div class="row">
                <div class="col-12 col-md-5 mb-4">
                    <div class="product-imgs">
                        <!-- Swiper Main -->
                        <div class="swiper main-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="rounded-6 w-100" src="<?= base_url() ?>images/produk/<?= $product->gambar ?>" alt="image">
                                </div>
                                <?php while ($row = $images->fetch_object()) { ?>
                                    <div class="swiper-slide">
                                        <img class="rounded-6 w-100" src="<?= base_url() ?>images/produk/<?= $row->gambar ?>" alt="<?= $row->gambar ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="swiper-pagination mt-2"></div>
                        </div>

                        <!-- Swiper Thumbs -->
                        <div class="swiper thumb-swiper mt-2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img class="rounded-6 w-100" src="<?= base_url() ?>images/produk/<?= $product->gambar ?>" />
                                </div>
                                <?php
                                $images->data_seek(0);
                                while ($row = $images->fetch_object()) { ?>
                                    <div class="swiper-slide">
                                        <img class="rounded-6 w-100" src="<?= base_url() ?>images/produk/<?= $row->gambar ?>" />
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <div class="product-content">
                        <p class="product-title mt-0 mb-2"><?= $product->nama_produk ?></p>
                        <p class="product-price mb-2"><?= rp($product->harga) ?></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="col product-price mt-2 mb-2 align-self-center">
                        <span>Deskripsi Produk</span>
                        <button type="button" class="btn btn-xs btn-transparent px-1 py-1" onclick="copyToClipboard('#keterangan')" style="margin-top:-5px">
                            <img src="<?= base_url() ?>images/icons/copy.png" alt="Salin" width="20">
                        </button>
                    </div>
                    <div class="card p-4 rounded-6">
                        <div id="keterangan"><?= $product->keterangan ?></div>
                        <a href="javascript:void(0)" id="toggleDescription" class="show-all">Lihat Semua</a>
                    </div>

                    <p class="product-price mt-4 mb-0">Bagikan</p>
                    <div class="social-links">
                        <a href="#">
                            <img src="<?= base_url() ?>images/icons/fb.png" alt="">
                        </a>
                        <a href="#">
                            <img src="<?= base_url() ?>images/icons/wa.png" alt="">
                        </a>
                    </div>

                    <div class="col product-price mt-4 mb-2 align-self-center">
                        <span>Link Promosi</span>
                        <button type="button" class="btn btn-xs btn-transparent px-1 py-1" onclick="copyToClipboard('#link_promosi')" style="margin-top:-5px">
                            <img src="<?= base_url() ?>images/icons/copy.png" alt="Salin" width="20">
                        </button>
                    </div>
                    <div class="card p-4 rounded-6">
                        <div id="link_promosi"><?= site_url('produk_detail&produk='.$slug) ?></div>
                    </div>

                    <a href="#" class="btn btn-outline-default btn-md rounded-pill mt-5 mb-2 w-100 shadow-none">Promosi Otomatis</a>
                    <button type="button" class="btn btn-default btn-md w-100 rounded-pill shadow-none" onclick="addToCart('<?= $product->id ?>')">Order</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("view/layout/nav-bottom.php"); ?>
<?php include("view/layout/assets_js.php"); ?>

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
            url: "controller/order/add_to_cart.php",
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
                    window.location = obj.redirectUrl;
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: obj.message,
                        icon: 'error'
                    });
                }
            },
            complete: function() {
                loader_close();
            }
        });
    }
</script>

<?php include("view/layout/footer.php"); ?>