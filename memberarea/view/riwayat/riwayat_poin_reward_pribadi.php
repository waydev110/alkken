<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
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
            url: 'controller/riwayat/riwayat_poin_reward_pribadi.php',
            data: {
                start: start,
                posisi: posisi,
                status: status,
                type: type,
                id_plan: 13
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