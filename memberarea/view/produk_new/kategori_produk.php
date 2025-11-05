<?php
require_once '../model/classProdukKategori.php';
$cpk = new classProdukKategori();
$kategori_produk = $cpk->index_member();
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

    .btn-category {
        padding: 5px 15px;
        background-color: #FFFFFF;
        border: 1px solid #EFB036;
        height: 28px;
        color: #464646;
    }

    .btn-category:hover,
    .btn-category.active {
        background: #EFB036;
        color: #FFFFFF;
    }
</style>
<main class="h-100 px-3 has-header">
    <?php include 'view/layout/back.php'; ?>
    <div class="main-container container pb-4 pt-4">
        <?php
        require_once '../model/classProdukKategori.php';
        $cpk = new classProdukKategori();
        $kategori_produk = $cpk->index_member();

        if ($kategori_produk->num_rows > 0) {
        ?>
            <div class="main-container container mt-4">
                <div class="row">
                    <?php
                    while ($row = $kategori_produk->fetch_object()) {
                    ?>
                        <div class="col-lg-2 col-md-2 col-xs-3 mb-3">
                            <div class="card bg-white shadow-sm rounded-6 mb-2">
                                <div class="card-body text-dark pt-3 pb-3 px-3">
                                    <div class="img-responsive">
                                        <a href="<?=site_url('produk&kategori='.$row->slug)?>"><img src="<?= base_url() ?>images/kategori/<?= $row->gambar ?>" width="100%"></a>
                                    </div>
                                </div>
                            </div>
                            <p class="size-rem-small text-dark text-center"><?= $row->nama_kategori ?></p>
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
</main>

<?php include("view/layout/nav-bottom.php"); ?>
<?php include("view/layout/assets_js.php"); ?>
<?php include("view/layout/footer.php"); ?>