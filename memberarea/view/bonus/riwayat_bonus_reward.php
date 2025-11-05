<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    
    require_once '../model/classBonus.php';
    $cbns = new classBonus();

    require_once '../model/classPlan.php';
    $cpl = new classPlan();

    $member = $cm->detail($session_member_id);
    if(isset($_GET['jenis_bonus'])){
        $jenis_bonus = $_GET['jenis_bonus'];
    } else {
        redirect('404');
    }

    $show_name = $cpl->show($jenis_bonus)->show_name;
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .bonus-list {
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
                <h5>Bonus Reward <?=$show_name?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pb-5 pt-0">
        <div class="p-3 bg-light rounded-15">
            <div class="row">
                <div class="col-4">
                    <h3 class="size-14">Total Bonus</h3>
                    <h2 class="size-14"><?=currency($cbns->riwayat_bonus_reward($jenis_bonus, $session_member_id))?></h2>
                </div>
                <div class="col-4">
                    <h3 class="size-14">Ditransfer</h3>
                    <h2 class="size-14"><?=currency($cbns->riwayat_bonus_reward($jenis_bonus, $session_member_id, '1'))?></h2>
                </div>
                <div class="col-4">
                    <h3 class="size-14">Pending</h3>
                    <h2 class="size-14"><?=currency($cbns->riwayat_bonus_reward($jenis_bonus, $session_member_id, '0'))?></h2>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="bonus-list">
                </div>
                <div class="load-list" display="none">                    
                    <div class="col-12 btn-load">
                        <div class="row">
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_bonus(0)">Load More</div>
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
        get_bonus(0, '<?=$jenis_bonus?>', null); 
    });


    function get_bonus(start = 0, type = '', e) {
        if(e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/bonus/get_bonus_reward.php',
            data: {
                start: start,
                type: type
            },
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    if(start == 0){
                        $('.bonus-list').html(obj.html);
                    } else {
                        $('.bonus-list').append(obj.html);
                    }
                    if(obj.count > 0){
                        $('.load-list').show();
                        $('#btnMore').attr('onclick', `get_bonus('${obj.start}', '${obj.type}')`);
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