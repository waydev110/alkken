<?php 
    date_default_timezone_set("Asia/Jakarta");
    $now = date("Y-m-d");
    $first_date = date("Y-m-01", strtotime($now));
    $last_date = date("Y-m-t", strtotime($now));
    $bulan = date("Y-m", strtotime($now));
    $bulan_indo = bulan($first_date);
    
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .kode_aktivasi-list {
        width: 100%;
    }

    .kode_aktivasi-item {
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
    <div class="main-container container">
        <div class="row px-2">
            <div class="col-auto align-self-center">
                <h5 class="mb-0 lh-xs" data-bulan="<?=$bulan?>" data-tgl="<?=$first_date?>" id="statement_bulan">
                    <?=$bulan_indo?></h5>
                <small class="text-muted size-11 mt-0" id="statement_tgl"><?=tgl_bulan($first_date)?> -
                    <?=tgl_indo($last_date)?></small>
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
            <button class="btn btn-default active flex-grow-1 m-2 text-start px-2 py-4 size-28" data-param="terima" id="btnRiwayatTerima">
                <div class="row">
                    <div class="col-auto pe-2">
                        <div class="avatar avatar-30 shadow-sm rounded-circle me-0">
                            <i class="fa-solid fa-box-full"></i>
                        </div>
                    </div>
                    <div class="col ms-0 ps-0">
                        <p class="mb-0 size-9">Diterima <span class="" id="terima"></span></p>
                        <h6 id="total_terima">0</h6>
                    </div>
                </div>
            </button>
            <button class="btn btn-outline-default flex-grow-1 m-2 text-start px-2 py-4 size-28" data-param="kirim" id="btnRiwayatKirim">
                <div class="row">
                    <div class="col-auto pe-2">
                        <div class="avatar avatar-30 shadow-sm rounded-circle">
                            <i class="fa-solid fa-paper-plane"></i>
                        </div>
                    </div>
                    <div class="col ms-0 ps-0">
                        <p class="mb-0 size-10">Ditransfer <span class="" id="kirim"></span></p>
                        <h6 id="total_kirim">0</h6>
                    </div>
                </div>
            </button>
        </div>
        <div id="kode_aktivasi-item">
            <div class="card mx-2 mt-2 shadow-none rounded-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col">
                            <p class="text-muted text-center"><i class="fa-light fa-box-open fa-8x"></i></p>
                            <h6 class="text-center fw-normal">Tidak ada riwayat.</h6>
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
    var btnRiwayatTerima = $('#btnRiwayatTerima');
    var btnRiwayatKirim = $('#btnRiwayatKirim');
    $(document).ready(function () {
        var bulan = $('#statement_bulan').data('bulan');
        riwayat(bulan, 'terima');

        $('#btnNext').on('click', function () {
            var bulan = $('#statement_bulan').data('bulan');
            var nextMonth = moment(bulan).add(1, 'M').format('YYYY-MM');
            var param = $(this).closest('.main-container').find('.btn-default.active').data('param');
            riwayat(nextMonth, param);
            $('#statement_bulan').data('bulan', nextMonth);
        });

        $('#btnPrev').on('click', function () {
            var bulan = $('#statement_bulan').data('bulan');
            var prevMonth = moment(bulan).add(-1, 'M').format('YYYY-MM');
            var param = $(this).closest('.main-container').find('.btn-default.active').data('param');
            riwayat(prevMonth, param);
            $('#statement_bulan').data('bulan', prevMonth);
        });

        btnRiwayatTerima.on('click', function () {
            var bulan = $('#statement_bulan').data('bulan');
            riwayat(bulan, 'terima');
            toggleBtn($(this));
        });

        btnRiwayatKirim.on('click', function () {
            var bulan = $('#statement_bulan').data('bulan');
            riwayat(bulan, 'kirim');
            toggleBtn($(this));
        });
    });

    function riwayat(bulan, jenis) {
        $.ajax({
            type: 'POST',
            url: 'controller/transfer_pin/riwayat_transfer_pin.php',
            data: {
                bulan: bulan,
                jenis: jenis
            },
            beforeSend: function () {
                loader_open();
            },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('#kode_aktivasi-item').html(obj.html);
                    $('#statement_bulan').text(obj.statement_bulan);
                    $('#statement_tgl').text(obj.statement_tgl);
                    $('#total_terima').text(obj.total_terima);
                    $('#total_kirim').text(obj.total_kirim);
                    $('#terima').text(obj.total_peringkat_terima);
                    $('#kirim').text(obj.total_peringkat_kirim);
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

    function toggleBtn(e) {
        if (e.attr('id') == 'btnRiwayatTerima') {
            btnRiwayatTerima.removeClass('btn-outline-default').addClass('btn-default active');
            // elID.closest('.avatar').removeClass('bg-theme text-white').addClass('bg-theme-light text-theme');

            btnRiwayatKirim.removeClass('btn-default').addClass('btn-outline-default');
            // disID.closest('.avatar').removeClass('bg-theme-light text-theme').addClass('bg-theme text-white');
        } else {
            btnRiwayatKirim.removeClass('btn-outline-default').addClass('btn-default active');
            // elID.closest('.avatar').removeClass('bg-theme text-white').addClass('bg-theme-light text-theme');

            btnRiwayatTerima.removeClass('btn-default').addClass('btn-outline-default');
            // disID.closest('.avatar').removeClass('bg-theme-light text-theme').addClass('bg-theme text-white');
        }
    }
</script>