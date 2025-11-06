<?php 
    require_once '../model/classBonus.php';

    $cbns = new classBonus();
    $total_bonus = $cbns->total_bonus($session_member_id);

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
    .input-group:not(.has-validation) > :not(:last-child):not(.dropdown-toggle):not(.dropdown-menu), .input-group:not(.has-validation) > .dropdown-toggle:nth-last-child(n + 3) {
        border-radius: 40px!important;
        font-size: 12px !important;
        color:#000;
    }
    .input-group .input-group-append{
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
      background-color:#1983d1;
      color:#fff;
      border: 1px solid var(--mlm-theme-bordercolor);
    }
    .menuswiper .swiper-wrapper .swiper-slide{
        width: 150px;
    }
    .certificate-container {
        position: relative;
        text-align: center;
        color: #8e6922;
    }
    .certificate-container .title-name {
        position: absolute;
        width: 100%;
        top: 42%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .title-name h1 {
        font-size: calc(22px + 0.390625vw);
    }
    .certificate-container .title-nominal {
        position: absolute;
        width: 100%;
        bottom: 44%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .title-nominal h2 {
        font-size: calc(36px + 0.2vw);
    }
    .certificate-container .title-poin {
        position: absolute;
        width: 100%;
        bottom: 33%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .title-poin h2 {
        font-size: calc(32px + 0.2vw);
    }
    @media (max-width: 800px) {
        .certificate-container .title-name {
            top: 38%;
            left: 50%;
        }
        .certificate-container .title-nominal {
            bottom: 46%;
            left: 50%;
        }
        .certificate-container .title-poin {
            bottom: 32%;
            left: 50%;
        }
        .title-name h1 {
            font-size: calc(12px + 0.2vw);
        }
        .title-nominal h2 {
            font-size: calc(12px + 0.2vw);
        }
    }
    
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&display=swap" rel="stylesheet">
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

    <div class="main-container container" id="blockFirstForm">
        <?php include 'view/dashboard/certificate.php'; ?>
    </div>
</main>

<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<?php include 'view/layout/footer.php'; ?>