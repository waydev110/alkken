<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->

<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>
<!-- Sidebar main menu ends -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --color-black: #1a1a1a;
        --color-dark: #2d2d2d;
        --color-gold: #d4af37;
        --color-gold-light: #f4d47c;
        --color-white: #ffffff;
        --color-gray: #8a8a8a;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    }

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

    /* Modern Header Design */
    .hero-section {
        position: relative;
        width: 100%;
        background: linear-gradient(135deg, var(--color-black) 0%, var(--color-dark) 100%);
        min-height: 280px;
        padding: 20px 0;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, var(--color-gold) 0%, transparent 70%);
        opacity: 0.1;
        animation: pulse 4s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.15;
        }
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .welcome-text {
        font-size: 14px;
        color: var(--color-gray);
        font-weight: 300;
        letter-spacing: 1px;
    }

    .user-id {
        font-size: 24px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .member-badge {
        display: inline-block;
        padding: 6px 16px;
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        color: var(--color-black);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 10px;
    }

    /* Modern Stats Cards */
    .stats-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        padding: 16px;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        border-color: var(--color-gold);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
    }

    .stats-label {
        font-size: 11px;
        color: var(--color-gray);
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stats-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-gold);
        margin-top: 4px;
    }

    .stats-value i {
        font-size: 12px;
        margin-left: 4px;
    }

    /* Network Slider */
    .network-swiper .swiper-slide {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .network-swiper .swiper-slide:hover {
        border-color: var(--color-gold);
        transform: scale(1.02);
    }

    .network-card-title {
        font-size: 12px;
        color: var(--color-gold);
        font-weight: 600;
        margin-bottom: 16px;
    }

    .network-stat {
        text-align: center;
    }

    .network-stat-label {
        font-size: 11px;
        color: var(--color-gray);
        margin-bottom: 4px;
    }

    .network-stat-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--color-white);
    }

    /* Replika Banner */
    .replika-banner {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(244, 212, 124, 0.05) 100%);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        padding: 16px;
        position: relative;
        overflow: hidden;
    }

    .replika-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        animation: rotate 10s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .replika-text {
        font-size: 13px;
        color: var(--color-white);
        position: relative;
        z-index: 2;
    }

    .btn-gold {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        color: var(--color-black);
        border: none;
        padding: 10px 24px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 12px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        color: var(--color-black);
    }

    /* Product Cards */
    .product-item {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        padding: 12px;
        transition: all 0.3s ease;
    }

    .product-item:hover {
        transform: translateY(-8px);
        border-color: var(--color-gold);
        box-shadow: 0 12px 32px rgba(212, 175, 55, 0.3);
    }

    .product-item img {
        border-radius: 12px;
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .product-item .title {
        font-size: 13px;
        color: var(--color-dark);
        font-weight: 500;
        margin-top: 12px;
    }

    .product-item .price {
        font-size: 18px;
        font-weight: 700;
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-top: 8px;
    }

    /* Section Titles */
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--color-dark);
        margin-bottom: 20px;
        position: relative;
        padding-left: 16px;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 24px;
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        border-radius: 2px;
    }

    /* News & Testimonial Cards */
    .card-modern {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .card-modern:hover {
        border-color: var(--color-gold);
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
    }

    .card-modern .card-body {
        padding: 16px;
    }

    .card-modern .text-content {
        color: var(--color-white);
        font-size: 13px;
        line-height: 1.6;
    }

    .card-modern .text-muted {
        color: var(--color-gray) !important;
        font-size: 11px;
    }

    /* Home Menu Styles */
    .menu-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        padding: 12px;
        max-width: 100%;
    }

    @media (min-width: 576px) {
        .menu-container {
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            padding: 16px;
        }
    }

    @media (min-width: 768px) {
        .menu-container {
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            padding: 20px;
        }
    }

    @media (min-width: 992px) {
        .menu-container {
            grid-template-columns: repeat(8, 1fr);
            gap: 24px;
            padding: 24px;
        }
    }

    .main-menu {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .main-menu a {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .main-menu a:hover {
        transform: translateY(-4px);
    }

    .icon-menu {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(244, 212, 124, 0.05) 100%);
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .icon-menu img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }

    .main-menu a:hover .icon-menu {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-light) 100%);
        border-color: var(--color-gold);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }

    .main-menu p {
        font-size: 11px;
        font-weight: 500;
        color: var(--color-dark);
        margin: 0;
        line-height: 1.3;
    }

    /* Responsive adjustments */
    @media (max-width: 800px) {
        body {
            font-size: 12px !important;
        }

        .user-id {
            font-size: 20px;
        }

        .stats-value {
            font-size: 16px;
        }

        .menu-container {
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .icon-menu {
            width: 45px;
            height: 45px;
        }

        .icon-menu img {
            width: 24px;
            height: 24px;
        }

        .main-menu p {
            font-size: 10px;
        }
    }

    @media (max-width: 576px) {
        .menu-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    /* Container background */
    .main-container {
        background: transparent;
    }

    /* Swiper pagination */
    .swiper-pagination-bullet {
        background-color: var(--color-gold);
        opacity: 0.5;
    }

    .swiper-pagination-bullet-active {
        background-color: var(--color-gold);
        opacity: 1;
    }
    .swiper-container {
        z-index: 1;
        padding-top: 20px;
    }
</style>

<?php
// PHP code remains the same
require_once '../model/classBerita.php';
require_once '../model/classMember.php';
require_once '../model/classSlideShow.php';
require_once '../model/classKodeAktivasi.php';
require_once '../model/classTestimoni.php';
require_once '../model/classBonus.php';
require_once '../model/classBonusRewardPaket.php';
require_once '../model/classPlan.php';
require_once '../model/classWallet.php';

$cbns = new classBonus();
$total_bonus = $cbns->total_bonus($session_member_id);
$total_bonus_pending = $cbns->total_bonus($session_member_id, 0);
$total_bonus_transfer = $cbns->total_bonus($session_member_id, 1);
$saldo_wd = $cbns->saldo_wd($session_member_id);

$cpl = new classPlan();
$plan_pasangan = $cpl->plan_pasangan();
$plan_reward = $cpl->plan_reward();

$cm = new classMember();
$new_member = $cm->new_member();
$total_sponsori = $cm->sponsori($session_member_id);

$member = $cm->detail($session_member_id);
$limit_penarikan = $cpl->show($member->id_plan)->maximal_wd;
$max_autosave = $member->max_autosave;

$css = new classSlideShow();
$slide = $css->index();

$cb = new classBerita();
$berita = $cb->dashboard();

$cka = new classKodeAktivasi();
$total_kodeaktivasi_pending = $cka->total_kode_aktivasi($session_member_id, 0);
$total_kodeaktivasi_aktif = $cka->total_kode_aktivasi($session_member_id, 1);

$cw = new classWallet();
$saldo_poin = $cw->saldo($session_member_id, 'poin');
$total_poin = $cw->total_saldo($session_member_id, 'poin', 'd');
$total_poin_bulan_ini = $cw->total_saldo($session_member_id, 'poin', 'd', date('Y-m'));
$saldo_wallet = $cw->saldo($session_member_id, 'cash');
$saldo_reward = $cw->saldo($session_member_id, 'reward');

$ct = new classTestimoni();
$testimoni = $ct->index_member();

$cbrp = new classBonusRewardPaket();
?>

<main class="h-100">
    <header class="header position-relative hero-section" id="blockHeader">
        <div class="main-container container pt-3 hero-content">
            <!-- Top Bar -->
            <div class="row mb-3">
                <div class="col-auto">
                    <div class="btn btn-outline text-light menu-btn">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </div>
                <div class="col align-self-center text-end">
                    <img src="../logo-white.png" alt="" width="35" class="me-2">
                    <span class="text-light fw-bold"><?= $s->setting('sitename') ?></span>
                </div>
            </div>

            <!-- User Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <p class="welcome-text mb-1"><?= greetings(date('H')) ?></p>
                    <h2 class="user-id mb-2"><?= $session_id_member ?></h2>
                    <span class="member-badge">
                        <i class="fas fa-crown me-1"></i> Member <?= $member->nama_plan ?> <?= $member->short_name ?>
                    </span>
                    <span class="member-badge ms-2">
                        <i class="fas fa-star me-1"></i> <?= $member->nama_peringkat ?>
                    </span>
                </div>
            </div>

            <!-- Replika Banner -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="replika-banner">
                        <p class="replika-text mb-2">
                            <i class="fas fa-gift me-2"></i>
                            Maksimalkan Potensi Bisnis dengan <strong>Web Replika</strong>!
                        </p>
                        <a href="<?= site_url('link_referral') ?>" class="btn btn-gold btn-sm">
                            DAPATKAN SEKARANG <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <?php if ($show_modul) { ?>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div class="stats-card">
                            <p class="stats-label mb-1">Total Bonus</p>
                            <a href="<?= site_url('bonus') ?>" class="stats-value text-decoration-none">
                                <?= rp($total_bonus) ?> <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php if ($member->max_autosave > 0) { ?>
                    <div class="col-6">
                        <div class="stats-card">
                            <p class="stats-label mb-1">Kekurangan Autosave</p>
                            <a href="<?= site_url('riwayat_saldo_autosave') ?>" class="stats-value text-decoration-none">
                                <?= currency($max_autosave - $total_poin_bulan_ini) ?> <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-6">
                        <div class="stats-card">
                            <p class="stats-label mb-1">Saldo Bonus</p>
                            <a href="<?= site_url('riwayat_saldo_wd') ?>" class="stats-value text-decoration-none">
                                <?= currency($saldo_wd) ?> <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="col-6">
                        <div class="stats-card">
                            <p class="stats-label mb-1">Sharing Profit</p> -->
                            <?php
                            // $qualified_balik_modal = $cm->cek_sponsori_netreborn($session_member_id);
                            // if ($qualified_balik_modal == true) {
                            //     echo '<span class="badge bg-success"><i class="fa fa-check me-1"></i> Qualified</span>';
                            // } else {
                            //     echo '<span class="badge bg-warning text-dark">Not Qualified</span>';
                            // }
                            ?>
                        <!-- </div>
                    </div> -->
                </div>
            <?php } ?>

            <div class="row g-3">
                <div class="col-6">
                    <div class="stats-card">
                        <p class="stats-label mb-1">Wallet Cash</p>
                        <a href="<?= site_url('riwayat_wallet_cash') ?>" class="stats-value text-decoration-none">
                            <?= rp($saldo_wallet) ?> <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stats-card">
                        <p class="stats-label mb-1">Wallet Reward</p>
                        <a href="<?= site_url('riwayat_wallet_reward') ?>" class="stats-value text-decoration-none">
                            <?= rp($saldo_reward) ?> <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Network Swiper -->
            <div class="swiper-container network-swiper mt-4">
                <div class="swiper-wrapper">
                    <?php if ($show_modul) { ?>
                        <div class="swiper-slide">
                            <p class="network-card-title">Jumlah Bonus</p>
                            <div class="row">
                                <div class="col-6 network-stat">
                                    <p class="network-stat-label">Ditransfer</p>
                                    <p class="network-stat-value"><?= currency($total_bonus_transfer) ?></p>
                                </div>
                                <div class="col-6 network-stat">
                                    <p class="network-stat-label">Pending</p>
                                    <p class="network-stat-value"><?= currency($total_bonus_pending) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php if ($member->max_autosave > 0) { ?>
                        <div class="swiper-slide">
                            <p class="network-card-title">Saldo Autosave</p>
                            <div class="row">
                                <div class="col-6 network-stat">
                                    <p class="network-stat-label">Sisa Saldo</p>
                                    <p class="network-stat-value"><?= currency_minus($saldo_poin) ?></p>
                                </div>
                                <div class="col-6 network-stat">
                                    <p class="network-stat-label">Bulan Ini</p>
                                    <p class="network-stat-value"><?= currency($total_poin_bulan_ini) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="swiper-slide">
                        <p class="network-card-title">Kode Aktivasi</p>
                        <div class="row">
                            <div class="col-6 network-stat">
                                <p class="network-stat-label">Aktif</p>
                                <p class="network-stat-value"><?= currency($total_kodeaktivasi_aktif) ?></p>
                            </div>
                            <div class="col-6 network-stat">
                                <p class="network-stat-label">Pending</p>
                                <p class="network-stat-value"><?= currency($total_kodeaktivasi_pending) ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <p class="network-card-title">Jumlah Member</p>
                        <div class="row">
                            <div class="col-6 network-stat">
                                <p class="network-stat-label">Kiri</p>
                                <p class="network-stat-value"><?= currency($member->jumlah_kiri) ?></p>
                            </div>
                            <div class="col-6 network-stat">
                                <p class="network-stat-label">Kanan</p>
                                <p class="network-stat-value"><?= currency($member->jumlah_kanan) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="main-container container">
        <?php
        require_once '../model/classMenu.php';
        $cmenu = new classMenu();
        $home_menu = $cmenu->home_menu($show_modul);

        if ($home_menu->num_rows > 0) {
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm mt-4 mb-0">
                    <div class="card-body">
                        <div class="menu-container rounded-0 text-center">
                            <?php 
                                require_once '../model/classMember.php';
                                $cm = new classMember();
                                $member_akun = $cm->detail($session_member_id);
                                while ($row = $home_menu->fetch_object()) {
                                    // if($row->url == 'genealogy_level') {
                                        // if ($member_akun->id_plan >= 15 && $member_akun->id_plan <= 17 ) {
                                    ?>
                                    <div class="main-menu">
                                        <a href="<?= site_url($row->url) ?>" class="size-32">
                                            <div class="icon-menu icon-menu-40">
                                                <img src="../images/icons/<?=$row->icon?>" alt="">
                                            </div>
                                            <p class="text-black fw-normal size-11 mt-m-5"><?=$row->name?></p>
                                        </a>
                                    </div>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- Rest of the content remains the same -->
    <div class="main-container container pt-4 pb-4" id="blockFirstForm">
        <?php if ($slide->num_rows > 0) { ?>
            <div class="swiper-container sliderswiper mb-4">
                <div class="swiper-wrapper">
                    <?php while ($row = $slide->fetch_object()) { ?>
                        <div class="swiper-slide">
                            <a href="<?= site_url($row->url) ?>">
                                <img src="../images/slide_show/<?= $row->gambar ?>"
                                    alt="<?= $row->gambar ?>"
                                    class="w-100 rounded-3"
                                    style="border: 2px solid rgba(212, 175, 55, 0.3);">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        <?php } ?>

        <?php
        require_once '../model/classProduk.php';
        $obj = new classProduk();
        $products = $obj->index_reseller();
        $link_referral = $s->setting('site_host') . '/' . $session_user_member;
        if ($products->num_rows > 0) {
        ?>
            <div class="row mb-3">
                <div class="col">
                    <h3 class="section-title">Produk Terlaris</h3>
                </div>
                <div class="col-auto">
                    <a href="?go=product" class="btn btn-gold btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="swiper-container product-swiper mb-4">
                <div class="swiper-wrapper">
                    <?php while ($product = $products->fetch_object()) { ?>
                        <div class="swiper-slide">
                            <div class="product-item">
                                <img src="../images/produk/<?= $product->gambar ?>" alt="<?= $product->nama_produk ?>">
                                <div class="mt-2">
                                    <a href="?go=produk_detail&produk=<?= $product->slug ?>" class="title text-decoration-none">
                                        <?= strtolower($product->nama_produk) ?> <?= $product->qty ?> <?= $product->satuan ?>
                                    </a>
                                    <h3 class="price"><?= rp($product->harga) ?></h3>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-auto">
                                        <a href="https://api.whatsapp.com/send?text=<?= urlencode($link_referral) ?>"
                                            class="text-success me-2">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link_referral ?>"
                                            class="text-primary" target="_blank">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" class="btn btn-gold btn-sm" onclick="addToCart('<?= $product->id ?>')">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <!-- News Section -->
        <?php if ($berita->num_rows > 0) { ?>
            <div class="row mb-3">
                <div class="col">
                    <h3 class="section-title">Berita Terbaru</h3>
                </div>
                <div class="col-auto">
                    <a href="?go=berita" class="btn btn-gold btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="swiper-container news-swiper mb-4">
                <div class="swiper-wrapper">
                    <?php while ($row = $berita->fetch_object()) { ?>
                        <div class="swiper-slide">
                            <div class="card card-modern">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto">
                                            <div class="avatar avatar-60 rounded-3 overflow-hidden">
                                                <img src="../images/berita/<?= $row->gambar ?>" alt="<?= $row->gambar ?>" class="w-100 h-100 object-fit-cover">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a href="?go=berita_detail&title=<?= $row->slug ?>" class="text-content text-decoration-none d-block mb-1">
                                                <?= capital_word($row->judul) ?>
                                            </a>
                                            <p class="text-muted mb-0">
                                                <i class="far fa-calendar me-1"></i><?= tgl_indo($row->created_at) ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <!-- Testimonial Section -->
        <?php if ($testimoni->num_rows > 0) { ?>
            <div class="row mb-3">
                <div class="col">
                    <h3 class="section-title">Testimoni Member</h3>
                </div>
                <div class="col-auto">
                    <a href="?go=testimoni" class="btn btn-gold btn-sm">Lihat Semua</a>
                </div>
            </div>
            <div class="swiper-container testi-swiper">
                <div class="swiper-wrapper">
                    <?php while ($row = $testimoni->fetch_object()) { ?>
                        <div class="swiper-slide">
                            <div class="card card-modern" style="min-height: 180px;">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <p class="text-content fw-bold mb-0"><?= $row->nama_samaran ?></p>
                                            <p class="text-muted mb-0">Member <?= $row->nama_plan ?></p>
                                        </div>
                                        <div class="col-auto">
                                            <p class="text-muted mb-0"><?= tgl_indo_jam($row->created_at) ?></p>
                                        </div>
                                    </div>
                                    <p class="text-content">
                                        <?= substr($row->testimoni, 0, 150) ?>
                                        <span class="text-readmore" id="text<?= $row->id ?>" style="display:none">
                                            <?= substr($row->testimoni, 150) ?>
                                        </span>
                                        <?php if (strlen($row->testimoni) > 150) { ?>
                                            <a href="javascript:void(0);"
                                                class="text-gold"
                                                onclick="showComment(this, 'text<?= $row->id ?>')">
                                                Baca Selengkapnya
                                            </a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Modals -->
    <?php include 'view/auth/form_cek_pin.php'; ?>
    <?php include 'view/dashboard/pengumuman.php'; ?>
    <?php include 'view/dashboard/birthday.php'; ?>

    <div class="modal fade" id="modalCart" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: var(--color-dark); border: 1px solid var(--color-gold);">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title text-white">Berhasil</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-white"></div>
                <div class="modal-footer border-top border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="<?= site_url('cart') ?>" class="btn btn-gold">Lihat Keranjang</a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/vendor/jquery-validation-1.19.5/jquery.validate.min.js"></script>
<script src="assets/js/jquery.isotope.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Swipers
        var networkSwiper = new Swiper(".network-swiper", {
            slidesPerView: "auto",
            spaceBetween: 12,
            loop: true,
            breakpoints: {
                320: {
                    slidesPerView: 1.5,
                    spaceBetween: 12
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 16
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        var productSwiper = new Swiper(".product-swiper", {
            slidesPerView: "auto",
            spaceBetween: 12,
            breakpoints: {
                320: {
                    slidesPerView: 2,
                    spaceBetween: 12
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 16
                },
                1280: {
                    slidesPerView: 4,
                    spaceBetween: 20
                }
            }
        });

        var newsSwiper = new Swiper(".news-swiper", {
            slidesPerView: "auto",
            spaceBetween: 12,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 12
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 16
                },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });

        var testiSwiper = new Swiper(".testi-swiper", {
            slidesPerView: "auto",
            spaceBetween: 12,
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 12
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 16
                },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });

        var sliderSwiper = new Swiper(".sliderswiper", {
            slidesPerView: 1,
            spaceBetween: 16,
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            }
        });
    });

    function addToCart(id_produk) {
        var qty = $("#qty").val() || 1;
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
                    $('#modalCart .modal-body').html(obj.message);
                    $('#modalCart').modal('show');
                }
            },
            complete: function() {
                loader_close();
            }
        });
    }

    function showComment(e, id) {
        $('#' + id).show();
        $(e).remove();
    }

    function infoText(message) {
        Swal.fire(message);
    }
</script>

<?php include 'view/layout/footer.php'; ?>