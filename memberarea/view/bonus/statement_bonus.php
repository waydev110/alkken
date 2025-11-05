<?php 
    date_default_timezone_set("Asia/Jakarta");
    $now = date("Y-m-d");
    $first_date = date("Y-m-01", strtotime($now));
    $last_date = date("Y-m-t", strtotime($now));
    $bulan = date("Y-m", strtotime($now));
    $bulan_indo = bulan($first_date);
    
    require_once '../model/classBonus.php';
    $obj = new classBonus();

    // $statement_bonus = $obj->statement_bonus($session_member_id, $bulan);
    $total_bonus = $obj->jumlah_bonus($session_member_id, $bulan);
    $total_penarikan = $obj->jumlah_penarikan($session_member_id, $bulan);
    
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
</style>
<!-- Begin page -->
<main class="h-100 has-header bg-dark">
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
    <div class="main-container pt-4 pb-4 container">
        <div class="row px-2">
            <div class="col-auto align-self-center">
                <h5 class="text-primary mb-0 lh-xs" data-bulan="<?=$bulan?>" data-tgl="<?=$first_date?>" id="statement_bulan"><?=$bulan_indo?></h5>
                <small class="text-muted size-11 mt-0" id="statement_tgl"><?=tgl_bulan($first_date)?> - <?=tgl_indo($last_date)?></small>
            </div>
            <div class="col text-end">
                <button class="btn btn-default rounded-circle" id="btnPrev">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class="btn btn-default rounded-circle" id="btnNext">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div class="d-flex flex-nowrap align-self-center px-0">
            <button class="btn btn-default flex-grow-1 m-2 text-start pe-1 py-4 size-28 active" data-param="cash" id="btnStatementBonus">
                <div class="row">
                    <div class="col-auto pe-2">
                        <div class="avatar avatar-30 shadow-sm rounded-circle me-0">
                            <i class="fa-duotone fa-arrow-down-to-bracket"></i>
                        </div>
                    </div>
                    <div class="col ms-0 ps-0">
                        <p class="mb-0 size-9">Bonus</p>
                        <h5 id="total_bonus"><?=currency($total_bonus)?></h5>
                    </div>
                </div>
            </button>
            <button class="btn btn-outline-default flex-grow-1 m-2 text-start pe-1 py-4 size-28" data-param="penarikan" id="btnStatementPenarikan">
                <div class="row">
                    <div class="col-auto pe-2">
                        <div class="avatar avatar-30 shadow-sm rounded-circle">
                            <i class="fa-duotone fa-arrow-up-from-bracket"></i>
                        </div>
                    </div>
                    <div class="col ms-0 ps-0">
                        <p class="mb-0 size-10">Ditransfer</p>
                        <h5 id="text-primary total_penarikan"><?=currency($total_penarikan)?></h5>
                    </div>
                </div>
            </button>
        </div>
        <div id="bonus-item">
            <div class="card mx-2 mt-2 shadow-none rounded-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col">
                            <p class="text-muted text-center"><i class="fa-light fa-lightbulb-dollar fa-8x"></i></p>                            
                            <h6 class="text-center fw-normal">Statement bonus kosong.</h6>
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
<script src="assets/vendor/momentjs/moment.js"></script>
<script>
    var btnStatementBonus = $('#btnStatementBonus');
    var btnStatementPenarikan = $('#btnStatementPenarikan');

    $(document).ready(function () {
        var bulan = $('#statement_bulan').data('bulan');
        statement_bonus(bulan);

        $('#btnNext').on('click', function(){
            var bulan = $('#statement_bulan').data('bulan');
            var nextMonth = moment(bulan).add(1, 'M').format('Y-MM');
            var param = $(this).closest('.main-container').find('.btn-default.active').data('param');
            if(param == 'cash'){
                statement_bonus(nextMonth);
            } else {
                statement_penarikan(nextMonth);
            }
            $('#statement_bulan').data('bulan', nextMonth);
        });

        $('#btnPrev').on('click', function(){
            var bulan = $('#statement_bulan').data('bulan');
            var prevMonth = moment(bulan).add(-1, 'M').format('Y-MM');
            var param = $(this).closest('.main-container').find('.btn-default.active').data('param');
            if(param == 'cash'){
                statement_bonus(prevMonth);
            } else {
                statement_penarikan(prevMonth);
            }
            $('#statement_bulan').data('bulan', prevMonth);
        });

        btnStatementBonus.on('click', function(){
            var bulan = $('#statement_bulan').data('bulan');
            statement_bonus(bulan);
            toggleBtn($(this));
        });

        btnStatementPenarikan.on('click', function(){
            var bulan = $('#statement_bulan').data('bulan');
            statement_penarikan(bulan);
            toggleBtn($(this));
        });
    });

    function statement_bonus(bulan) {        
        $.ajax({
            type:'POST',
            url: 'controller/bonus/statement_bonus.php',
            data: {bulan : bulan},
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#bonus-item').html(obj.html);
                    $('#statement_bulan').text(obj.statement_bulan);
                    $('#statement_tgl').text(obj.statement_tgl);
                    $('#total_bonus').text(obj.total_bonus);
                    $('#total_penarikan').text(obj.total_penarikan);
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

    function statement_penarikan(bulan) {        
        $.ajax({
            type:'POST',
            url: 'controller/bonus/statement_penarikan.php',
            data: {bulan : bulan},
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#bonus-item').html(obj.html);
                    $('#statement_bulan').text(obj.statement_bulan);
                    $('#statement_tgl').text(obj.statement_tgl);
                    $('#total_bonus').text(obj.total_bonus);
                    $('#total_penarikan').text(obj.total_penarikan);
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

    function toggleBtn(e){
        if(e.attr('id') == 'btnStatementBonus'){
            btnStatementBonus.removeClass('btn-outline-default').addClass('btn-default active');
            btnStatementPenarikan.removeClass('btn-default').addClass('btn-outline-default');
        } else {
            btnStatementPenarikan.removeClass('btn-outline-default').addClass('btn-default active');
            btnStatementBonus.removeClass('btn-default').addClass('btn-outline-default');
        }
    }
</script>
<?php include 'view/layout/footer.php'; ?>