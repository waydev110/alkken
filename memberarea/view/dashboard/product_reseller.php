<?php
require_once '../model/classProduk.php';
$obj = new classProduk();
// $products = $obj->index_populer();
$products = $obj->index_reseller();
$link_referral = 'https://netlife.id/' . $session_user_member;
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
    <div class="row mt-4">
        <div class="col py-2">
            <h5 class="title text-primary">Produk Terlaris</h5>
        </div>
        <div class="col-auto align-self-center">
            <a class="btn btn-sm btn-outline-default rounded-2" href="?go=product" class="">Lainnya</a>
        </div>
    </div>
    <div class="row">
        <div class="swiper-container product-swiper">
            <div class="swiper-wrapper">
                <?php
                while ($product = $products->fetch_object()) {
                ?>
                    <div class="swiper-slide">
                        <div class="product-item">
                            <img class="img-responsive" src="../images/produk/<?= $product->gambar ?>" alt="image" width="100%">
                            <div class="mt-2 mb-2">
                                <a href="?go=produk_detail&produk=<?= $product->slug ?>" class="title"><?= strtolower($product->nama_produk) ?> <?= $product->qty ?> <?= $product->satuan ?></a>
                                <h3 class="price">
                                <?php
                                echo rp($product->harga) 
                                ?>
                                </h3>
                                <!-- <p class="text-dark size-11">Terjual : <?=currency($product->total)?></p> -->
                            </div>
                            <div class="row">
                                <div class="col-auto align-self-center pe-0">
                                    <a href="https://api.whatsapp.com/send?text=Hallo kawan, ini ada informasi bisnis menarik, semoga bermanfaat buat kita semua, silahkan buka web saya ya <?= $link_referral ?>" class="text-success"><i class="fab fa-whatsapp"></i></a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link_referral ?>" class="text-primary" target="_blank"><i class="fab fa-facebook"></i></a>

                                </div>
                                <div class="col align-self-center">
                                    <div class="d-flex justify-content-end">
                                        <!-- <a href="?go=produk_detail&produk=<?= $product->slug ?>" class="btn btn-theme btn-sm shadow-sm rounded-pill">Detail Produk</a> -->
                                        <button type="button" class="btn btn-warning btn-sm shadow-sm rounded-pill" onclick="addToCart('<?= $product->id ?>')"><i class="fa-solid fa-cart-plus"></i></button>
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
<?php
}
?>