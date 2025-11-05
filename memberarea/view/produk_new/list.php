
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

    .btn-category{
        padding: 5px 15px;
        background-color: #FFFFFF;
        border:1px solid #EFB036;
        height: 28px;
        color: #464646;
    }

    .btn-category:hover, .btn-category.active{
        background: #EFB036;
        color: #FFFFFF;
    }
</style>
<main class="h-100 px-3 has-header">
    <?php include 'view/layout/back.php'; ?>
    <div class="main-container container pb-4 pt-2">
        <?php
        if ($kategori_produk->num_rows > 0) {
        ?>
        <div class="row">
            <div class="col-12">
                <div class="swiper-container container-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button id="all" class="btn-category swiper-slide tag" type="button" data-option-value="*" style="width:auto" onclick="getData(0, '', this)">
                            Semua
                        </button>                        
                        <?php
                        $slug_kategori = '';
                        if(isset($_GET['kategori'])){
                            $slug_kategori = $_GET['kategori'];
                        }
                        while ($row = $kategori_produk->fetch_object()) {
                        ?>
                        <button id="<?=$row->slug?>" class="btn-category swiper-slide tag" type="button" data-filter=".<?=$row->slug?>" style="width:auto" onclick="getData(0, '<?=$row->slug?>', this)">
                            <?= $row->nama_kategori ?>
                        </button>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="main-container container pb-4 pt-4">
            <div class="row" id="data-list">
            </div>
        </div>
    </div>
</main>

<?php include("view/layout/nav-bottom.php"); ?>
<?php include("view/layout/assets_js.php"); ?>

<script>
    $(document).ready(function () {
        var slug_kategori = '';
        getData(0, slug_kategori, null);                        
        var containerSwiper = new Swiper(".container-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });
    });

    function getData(start = 0, slug_kategori = '', e) {
        if(e != null) {
            $('.swiper-slide').removeClass('active');
            // $(e).addClass('active');
        }
        if(slug_kategori == ''){
            $('#all').addClass('active');                
        } else {
            $('#'+slug_kategori).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/produk/get_produk_stokis.php',
            data: {
                start: start,
                slug_kategori: slug_kategori
            },
            beforeSend: function () {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.load-list').remove();
                    if (start == 0) {
                        $('#data-list').html(obj.html);
                    } else {
                        $('#data-list').append(obj.html);
                    }
                } else {
                    Swal.fire({
                        text: obj.message,
                        customClass: {
                            confirmButton: 'btn-default rounded-pill px-5'
                        }
                    });
                }
            },
            complete: function () {
                loader_close();
            }
        });
    }
</script>

<?php include("view/layout/footer.php"); ?>