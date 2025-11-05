<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .reward-list {
        width: 100%;
    }

    .reward-item {
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
                <div class="reward-list">
                </div>
                <div class="load-list" display="none">
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_reward(0)">Load More
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
        get_reward(0, null);
    });


    function get_reward(start = 0, e) {
        if (e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/spin_reward/riwayat_spin_reward.php',
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
                        $('.reward-list').html(obj.html);
                    } else {
                        $('.reward-list').append(obj.html);
                    }
                    if (obj.count > 0) {
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_reward('${obj.start}')`);
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