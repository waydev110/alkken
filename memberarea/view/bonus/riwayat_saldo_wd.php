<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    
    require_once '../model/classSaldoPenarikan.php';
    $csp = new classSaldoPenarikan();

    $member = $cm->detail($session_member_id);
    $jenis_wallet = 'saldo_wd';
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
                <h5>Saldo Bonus Netborn</h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container mt-4 pb-5 pt-0">
        <div class="p-3 bg-light rounded-15">
            <div class="row">
                <div class="col-4">
                    <h3 class="size-14">Total Saldo</h3>
                    <h2 class="size-14"><?=currency($csp->riwayat_saldo($jenis_wallet, $session_member_id)->debit)?></h2>
                </div>
                <div class="col-4">
                    <h3 class="size-14">Total Transfer</h3>
                    <h2 class="size-14"><?=currency($csp->riwayat_saldo($jenis_wallet, $session_member_id)->kredit)?></h2>
                </div>
                <div class="col-4">
                    <h3 class="size-14">Sisa Saldo</h3>
                    <h2 class="size-14"><?=currency($csp->riwayat_saldo($jenis_wallet, $session_member_id)->sisa)?></h2>
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
                            <button class="btn btn-default rounded-pill" id="btnMore" onclick="get_saldo(0)">Load More</div>
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
        get_saldo(0, '<?=$jenis_wallet?>', null); 
    });


    function get_saldo(start = 0, type = '', e) {
        if(e != null) {
            $('.swiper-slide').removeClass('active');
            $(e).addClass('active');
        }
        $.ajax({
            type: 'POST',
            url: 'controller/bonus/get_saldo_wd.php',
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
                        $('#btnMore').attr('onclick', `get_saldo('${obj.start}', '${obj.type}')`);
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