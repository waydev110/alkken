<?php
require_once '../model/classBerita.php';
require_once '../model/classMember.php';
require_once '../model/classSlideShow.php';
require_once '../model/classKodeAktivasi.php';
require_once '../model/classTestimoni.php';
require_once '../model/classBonus.php';
require_once '../model/classPlan.php';
require_once '../model/classWallet.php';
require_once '../model/classWithdraw.php';

$cbns = new classBonus();
$top_income = $cbns->top_income(date("Y-m"));
$total_bonus = $cbns->total_bonus($session_member_id);

$cpl = new classPlan();
$plan_pasangan = $cpl->plan_pasangan();
$plan_pasangan_level = $cpl->plan_pasangan_level();
$plan_reward = $cpl->plan_reward();
$plan_reward_pribadi = $cpl->plan_reward_pribadi();

$cm = new classMember();
$new_member = $cm->new_member();
$jumlah_poin_paket = $cm->jumlah_poin_paket($session_member_id);
$total_sponsori = $cm->sponsori($session_member_id);

$member = $cm->detail($session_member_id);
$limit_penarikan = $cpl->show($member->id_plan)->maximal_wd;

$css = new classSlideShow();
$slide = $css->index();

$cb = new classBerita();
$berita = $cb->dashboard();

$cka = new classKodeAktivasi();
// $kode = $cka->total($session_member_id);
$cw = new classWallet();
$saldo_wallet = $cw->saldo($session_member_id, 'cash');
$saldo_poin = $cw->saldo($session_member_id, 'poin');
$saldo_reedem = $cw->saldo($session_member_id, 'reedem');
$total_cash = $cw->total_cash($session_member_id, 'cash');
$total_poin = $cw->total_poin($session_member_id, 'poin');


$cwd = new classWithdraw();
$total_penarikan = $cwd->total_wd_today($session_member_id, 'cash', date('Y-m-d'));
$total_pin = 0;

$ct = new classTestimoni();
$testimonies = $ct->index();
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->

<style>
    .form-floating>label.error {
        position: absolute;
        top: 105px !important;
        font-size: 12px;
    }

    .input-group:not(.has-validation)> :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu),
    .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n + 3) {
        border-radius: 40px !important;
        font-size: 12px !important;
        color: #000;
    }

    .input-group .input-group-append {
        position: absolute;
        top: -5px !important;
        right: 10px !important;
    }

    .tag-akun {
        display: inline-block;
        padding: 2px 8px;
        line-height: 10px;
        font-size: 10px;
        border-radius: 30px;
        background-color: #193d53;
        color: #fff;
        border: 1px solid var(--mlm-theme-bordercolor);
    }

    .menuswiper .swiper-wrapper .swiper-slide {
        width: 150px;
    }

    .certificate-container {
        position: relative;
        text-align: center;
        color: #2e3c3d;
    }

    .certificate-container .title-name {
        position: absolute;
        width: 100%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .title-name h1 {
        font-size: calc(18px + 0.390625vw);
    }

    .certificate-container .title-nominal {
        position: absolute;
        width: 100%;
        bottom: 36%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .title-nominal h2 {
        font-size: calc(24px + 0.2vw);
    }

    .certificate-container .title-poin {
        position: absolute;
        width: 100%;
        bottom: 33%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .title-poin h2 {
        font-size: calc(18px + 0.2vw);
    }

    @media (max-width: 800px) {
        .certificate-container .title-name {
            top: 49%;
            left: 50%;
        }

        .certificate-container .title-nominal {
            bottom: 40%;
            left: 50%;
        }

        .certificate-container .title-poin {
            bottom: 32%;
            left: 50%;
        }
    }

    .swiper-pagination .swiper-pagination-bullet {
        background-color: #FFF;
    }
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
<!-- Begin page -->
<main class="h-100">
    <div class="main-container container">
        <header class="header position-relative px-0" id="blockHeader">
            <div class="row mb-2">
                <?php include 'view/layout/back.php'; ?>
                <div class="col align-self-center pt-1">
                    <h5><?= $title ?></h5>
                </div>
                <div class="col-auto px-4"></div>
            </div>
        </header>
    </div>

    <div class="main-container container" id="blockFirstForm">
        <?php include 'view/dashboard/nav_header.php'; ?>
        <?php
        //   include 'view/dashboard/info_penting.php'; 
        include 'view/dashboard/saldo_wallet.php'; ?>
        <?php
        include 'view/dashboard/menu.php'; ?>
        <?php
        // include 'view/dashboard/index_pasangan.php'; 
        ?>
        <?php
        // include 'view/dashboard/rekap_bonus.php'; 
        ?>
        <?php
        // include 'view/dashboard/product.php';
        ?>
        <div class="row mt-4">
            <div class="col-12 col-md-6 col-lg-6 order-lg-1 order-1">
                <?php include 'view/dashboard/slide.php'; ?>
            </div>
            <div class="col-12 col-md-6 col-lg-6 order-lg-1 order-1">
                <?php include 'view/dashboard/widget.php'; ?>
            </div>
        </div>
        <!-- <div class="row" style="margin-top:-70px">
        </div> -->
        <?php include 'view/dashboard/product.php'; ?>
        <?php include 'view/dashboard/berita.php'; ?>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <?php include 'view/dashboard/pengumuman.php'; ?>
    <?php include 'view/dashboard/birthday.php'; ?>
</main>

<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('#modalAlert').find('.modal-content').length > 0) {
            $('#modalAlert').modal('show');
        }
        if ($('#modalBirthday').find('.modal-body').length > 0) {
            $('#modalBirthday').modal('show');
        }
        var blockHeader = $('#blockHeader');
        var blockFirstForm = $('#blockFirstForm');
        var blockNextForm = $('#blockNextForm');
        var frmTestimoni = $('#frmTestimoni');
        var formCekPIN = $('#formCekPIN');
        var btnSubmitTestimoni = $('#btnSubmitTestimoni');

        btnSubmitTestimoni.on("click", function(e) {
            if (frmTestimoni.valid()) {
                blockHeader.hide();
                blockFirstForm.hide();
                blockNextForm.show();
            }
            e.preventDefault();
        });

        frmTestimoni.validate({
            rules: {
                testimoni: {
                    required: true,
                    minlength: 50
                }
            },
            messages: {
                testimoni: {
                    required: "Testimoni tidak boleh kosong.",
                    minlength: "Testimoni minimal 50 karakter."
                }
            }
        });

        formCekPIN.on("submit", function(e) {
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                success: function(result) {
                    if (result == true) {
                        frmTestimoni.submit();
                    } else {
                        if (result == 'limit') {
                            formCekPIN.html('');
                            formCekPIN.prepend(
                                '<p class="form-error text-center text-danger mb-1">Anda salah memasukan PIN sebanyak 3 kali.</p><p class="form-error text-center text-danger mb-3">Silahkan coba beberapa saat lagi.</p>'
                            );
                        } else {
                            if (formCekPIN.find('.form-error').length == 0) {
                                formCekPIN.prepend(
                                    '<p class="form-error text-center text-danger mb-3">PIN yang anda masukan salah.</p>'
                                );
                            }
                        }
                    }
                }
            });
            e.preventDefault();
        });

        frmTestimoni.on("submit", function(e) {
            e.preventDefault();
            var dataString = $(this).serialize();
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: dataString,
                beforeSend: function() {
                    loader_open();
                },
                success: function(result) {
                    blockHeader.show();
                    blockFirstForm.show();
                    blockNextForm.hide();
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        document.location = "index.php";
                    } else {
                        infoText(obj.message);
                    }
                },
                complete: function() {
                    loader_close();
                }
            });
        });

        var bonusSwiper = new Swiper(".home-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        var menuSwiper = new Swiper(".menu-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        $('.owl-carousel').owlCarousel({
            stagePadding: 0,
            loop: false,
            margin: 10,
            nav: true,
            navText: [],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    });

    function infoText(message) {
        Swal.fire(message);
    }

    function showComment(e, id) {
        $('#' + id).show();
        $(e).remove();
    }
</script>

<script>
    function addToCart(id_produk) {
        var qty = $("#qty").val();
        $.ajax({
            url: "controller/member_order/add_to_cart.php",
            data: {
                id_produk: id_produk,
                qty: qty
            },
            type: "POST",
            beforeSend: function() {
                loader_open();
            },
            success: function(result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    $('.count-indicator').text(obj.count);
                }
            },
            complete: function() {
                loader_close();
            }
        });
    }
</script>
<!-- page level custom script -->
<?php include 'view/layout/footer.php'; ?>