<?php
require_once '../model/classBerita.php';
require_once '../model/classMember.php';
require_once '../model/classSlideShow.php';
require_once '../model/classKodeAktivasi.php';
require_once '../model/classTestimoni.php';
require_once '../model/classBonus.php';
require_once '../model/classPlan.php';
// require_once '../model/classWallet.php';
// require_once '../model/classWithdraw.php';

$cbns = new classBonus();
// $top_income = $cbns->top_income(date("Y-m"));
$total_bonus = $cbns->total_bonus($session_member_id);

$cpl = new classPlan();
$plan_pasangan = $cpl->plan_pasangan();
$plan_reward = $cpl->plan_reward();

$cm = new classMember();
$new_member = $cm->new_member();
$total_sponsori = $cm->sponsori($session_member_id);

$member = $cm->detail($session_member_id);
$limit_penarikan = $cpl->show($member->id_plan)->maximal_wd;

$css = new classSlideShow();
$slide = $css->index();

$cb = new classBerita();
$berita = $cb->dashboard();

$cka = new classKodeAktivasi();
// $kode = $cka->total($session_member_id);
// $cw = new classWallet();
// $saldo_wallet = $cw->saldo($session_member_id, 'cash');
// $saldo_poin = $cw->saldo($session_member_id, 'poin');
// $saldo_reedem = $cw->saldo($session_member_id, 'reedem');
// $total_cash = $cw->total_cash($session_member_id, 'cash');
// $total_poin = $cw->total_poin($session_member_id, 'poin');


// $cwd = new classWithdraw();
// $total_penarikan = $cwd->total_wd_today($session_member_id, 'cash', date('Y-m-d'));
// $total_pin = 0;

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
    .form-floating-2>label.error {
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
<style>
    @media (max-width: 800px) {
        body {
            font-size: 12px !important;
        }
    }

    .curved-background {
        position: relative;
        background-color: var(--mlm-theme-color);
        height: 220px;
        z-index: 0;
    }

    .curved-background::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 0;
        width: 100%;
        height: 100px;
        background-color: var(--mlm-theme-color);
        border-radius: 0 0 50% 50%;
        z-index: -1;
    }

    .replika-container {
        position: relative;
        height: 40px;
        margin-bottom: 10px;
    }

    .replika-desc,
    .replika-icon {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        opacity: 0;
        transform: translateY(100%);
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }

    .replika-desc.active,
    .replika-icon.active {
        animation: slideUp 0.5s forwards;
    }

    .replika-desc.hidden,
    .replika-icon.hidden {
        animation: slideDown 0.5s forwards;
    }

    /* Tambahkan animasi keyframes untuk slide up dan slide down */
    @keyframes slideUp {
        0% {
            transform: translateY(100%);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideDown {
        0% {
            transform: translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateY(100%);
            opacity: 0;
        }
    }

</style>
<!-- Begin page -->
<main class="h-100">
    <header class="header position-fixed bg-theme px-4" id="blockHeader">
        <!-- <div class="main-container container"> -->
        <div class="row mb-0">
            <!-- <div class="col-auto align-self-center pe-0">
                    <div class="btn btn-outline text-theme menu-btn">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div> -->
            <div class="col-auto align-self-center ps-1 pe-0">
                <img src="../logo-white.png" alt="" width="30">
            </div>
            <div class="col align-self-center pt-1 ps-1">
                <span class="fw-normal text-light"><?= $session_id_member ?></span>
                <!-- <span class="fw-bold"><?= $sitename ?></span> -->
            </div>
            <div class="col-auto align-self-center text-end pe-1">
                <!-- <p class="fw-bold size-14 mb-0"><?= $session_id_member ?></p>
                    <p class="size-11"><?= strtoupper($session_nama_samaran) ?></p> -->
            </div>
            <div class="col-auto align-self-center ps-0">
                <!-- <img src="../images/plan/<?= $member->icon_plan ?>" alt="" width="50"> -->
            </div>
            <?php
            include 'view/layout/cart.php';
            ?>
        </div>
        <!-- </div> -->
    </header>
    <div class="curved-background bg-theme pt-2 pb-2">
        <div class="mt-0 rounded-15 pt-3 pb-3">
            <div class="d-flex flex-wrap justify-content-evenly align-self-center">
                <div class="text-center flex-grow-1">
                    <a href="<?= site_url('stok_pin') ?>" class="text-white">
                        <i class="fa-light fa-2x fa-key"></i>
                    </a>
                    <p class="text-white mt-1 size-11">Stok Pin</p>
                </div>
                <div class="text-center flex-grow-1">
                    <a href="<?= site_url('upgrade') ?>" class="text-white">
                        <i class="fa-light fa-2x fa-arrow-left-from-arc fa-rotate-90"></i>
                    </a>
                    <p class="text-white mt-1 size-11 fw-light">Upgrade Paket</p>
                </div>
                <div class="text-center flex-grow-1">
                    <a href="<?= site_url('posting_ro') ?>" class="text-white">
                        <i class="fa-light fa-2x fa-plus-circle"></i>
                    </a>
                    <p class="text-white mt-1 size-11 fw-light">Posting RO</p>
                </div>
                <div class="text-center flex-grow-1">
                    <a href="<?= site_url('transfer_pin') ?>" class="text-white">
                        <i class="fa-light fa-2x fa-paper-plane"></i>
                    </a>
                    <p class="text-white mt-1 size-11 fw-light">Transfer Pin</p>
                </div>
            </div>
        </div>
        <div class="container pt-4 text-center">
            <div class="replika-container">
                <p class="replika-desc text-light active">Dapatkan <span class="fw-bold text-yellow">Bonus Sponsor</span> setiap pendaftaran member baru dan pembelian produk dari link referralmu</p>
                <div class="replika-icon">
                    <p class="text-light">Maksimalkan Potensi Bisnis kamu dengan <span class="fw-bold text-yellow">Web Replika</span>! Jadi Gampang Cuan</p>
                </div>
            </div>
            <div class="form-group">
                <a href="<?= site_url('link_referral') ?>" class="btn btn-md btn-light rounded-pill">KLIK DISINI</a>
            </div>
        </div>
    </div>
    <div class="main-container container">
        
        <?php include("view/dashboard/nav_header.php"); ?>
        <?php
        // include 'view/dashboard/info_jaringan.php'; 
        ?>
    </div>

    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <?php
        //   include 'view/dashboard/info_penting.php'; 
        // include 'view/dashboard/saldo_wallet.php'; 
        ?>
        <?php include 'view/dashboard/slide.php'; ?>
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
                <?php
                // include 'view/dashboard/widget.php'; 
                ?>
            </div>
        </div>
        <!-- <div class="row" style="margin-top:-70px">
        </div> -->
        <?php
        include 'view/dashboard/product.php';
        ?>
        <?php
        include 'view/dashboard/slide_certificate.php';
        ?>
        <?php
        include 'view/dashboard/berita.php';
        ?>
    </div>
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <?php include 'view/dashboard/pengumuman.php'; ?>
    <?php include 'view/dashboard/birthday.php'; ?>
</main>

<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const desc = document.querySelector('.replika-desc');
        const icon = document.querySelector('.replika-icon');
        let isDescVisible = true;

        setInterval(() => {
            if (isDescVisible) {
                desc.classList.remove('active');
                desc.classList.add('hidden');
                setTimeout(() => {
                    icon.classList.remove('hidden');
                    icon.classList.add('active');
                }, 500); // Delay untuk transisi keluar
            } else {
                icon.classList.remove('active');
                icon.classList.add('hidden');
                setTimeout(() => {
                    desc.classList.remove('hidden');
                    desc.classList.add('active');
                }, 500); // Delay untuk transisi keluar
            }
            isDescVisible = !isDescVisible;
        }, 3000); // Berganti setiap 3 detik
    });
</script>


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

        var productSwiper = new Swiper(".product-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false,
            breakpoints: {
                // ketika layar berukuran >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        var $grid = $('.isotope-list').isotope({
            itemSelector: '.isotope-item',
            layoutMode: 'fitRows',
        });

        $('.filter-button-group').on('click', '.btn-category', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $('.btn-category').removeClass('active');
            $(this).addClass('active');
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

        var newsSwiper = new Swiper(".news-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false,
            breakpoints: {
                // ketika layar berukuran >= 320px
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 15
                },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
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

        $('.owl-carousel2').owlCarousel({
            stagePadding: 10,
            loop: false,
            margin: 10,
            nav: false,
            navText: [],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
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