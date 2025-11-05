<?php 
    require_once '../model/classMember.php';
    require_once '../model/classPlan.php';
    $cm = new classMember();
    $cpl = new classPlan();
    if(!isset($_GET['plan'])){
        return false;
    }
    $id_plan = base64_decode($_GET['plan']);
    $plan = $cpl->show($id_plan);
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
                <h5><?=$title?> <?=$plan->nama_plan?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pb-5 pt-0">
        <div class="row">
            <div class="col">
                <div class="poin-list mt-5">
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
        get_poin();  
    });
    function get_poin() {
        id_plan = '<?=$id_plan?>';
        $.ajax({
            type: 'POST',
            url: 'controller/riwayat/riwayat_poin_pasangan_level.php',
            data: {
                id_plan: id_plan
            },
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.poin-list').html(obj.html);
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