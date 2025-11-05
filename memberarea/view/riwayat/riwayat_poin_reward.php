<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    if(isset($_GET['plan_reward'])){
        $plan_reward = base64_decode($_GET['plan_reward']);
    } else {
        $get_plan_reward = $cpl->get_plan_reward();
        if($get_plan_reward){
            $plan_reward = $get_plan_reward->id;
        } else {
            exit;
        }
    }
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .poin-list {
        width: 100%;
    }

    .bonus-item {
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
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pb-5 pt-0">
        <div class="row">
            <div class="col">
                <?php if($_binary == true) { ?>
                <div class="swiper-container poin_swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto" onclick="get_poin(0, '', '', '', this)">
                            Semua
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".kiri"
                            style="width:auto" onclick="get_poin(0, 'kiri', 'd', 'posting', this)">
                            Kiri
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".kanan"
                            style="width:auto" onclick="get_poin(0, 'kanan', 'd', 'posting', this)">
                            Kanan
                        </button>
                    </div>
                </div>
                <?php } ?>
                <div class="poin-list">
                </div>
                <div class="load-list" display="none">                    
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_poin(0)">Load More</div>
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
    $(document).ready(function () {
        get_poin(0, '', '', '', null);                        
        var bonusSwiper = new Swiper(".poin_swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });
    });


    function get_poin(start = 0, posisi = '', status = '', type = '', e) {
        if(e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/riwayat/riwayat_poin_reward.php',
            data: {
                start: start,
                posisi: posisi,
                status: status,
                type: type,
                id_plan: '<?=$plan_reward?>'
            },
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    if(start == 0){
                        $('.poin-list').html(obj.html);
                    } else {
                        $('.poin-list').append(obj.html);
                    }
                    if(obj.count > 0){
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_poin('${obj.start}', '${obj.type}')`);
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
            complete: function () {
                loader_close();
            }
        });
    }
</script>
<?php include 'view/layout/footer.php'; ?>