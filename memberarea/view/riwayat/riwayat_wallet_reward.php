<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .saldo-list {
        width: 100%;
    }

    .saldo-item {
        width: 100%;
    }

    .btn-load {
        padding: 20px;
    }
</style>
<!-- Begin page -->
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center">
                <h5><?= $title ?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pb-5 mt-5">
        <div class="row">
            <div class="col">
                <div class="swiper-container saldo_swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag swiper-slide-active active" type="button" data-option-value="*" style="width:auto" onclick="get_saldo(0, '', this)">
                            Semua
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".d" style="width:auto" onclick="get_saldo(0, 'd', this)">
                            Saldo Masuk
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".k" style="width:auto" onclick="get_saldo(0, 'k', this)">
                            Saldo Keluar
                        </button>
                    </div>
                </div>
                <div class="saldo-list">
                </div>
                <div class="load-list" display="none">
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_saldo(0)">Load More
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    $(document).ready(function() {
        var saldoSwiper = new Swiper(".saldo_swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });
        get_saldo(0, '', null);
    });


    function get_saldo(start = 0, status = '', e) {
        if (e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/riwayat/riwayat_wallet_reward.php',
            data: {
                start: start,
                status: status
            },
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    if (start == 0) {
                        $('.saldo-list').html(obj.html);
                    } else {
                        $('.saldo-list').append(obj.html);
                    }
                    if (obj.count > 0) {
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_saldo('${obj.start}', '${obj.status_filter}')`);
                    } else {
                        $('.load-list').hide();
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
            complete: function() {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>