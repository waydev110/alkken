<?php
require_once '../model/classWebReplika.php';
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
<main class="h-100 has-header">
    <!-- Header -->
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include 'view/layout/back.php'; ?>
            <div class="col align-self-center pt-1">
                <h5><?= $title ?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- <div>
        <img src="../bg-web-replika.jpg" width="100%" alt="">
    </div> -->
    <div class="main-container container mt-4 mb-4">
        <div class="row">
        <?php
        $cwr = new classWebReplika();
        $web_replika = $cwr->index();
        $no = 0;
        while ($row = $web_replika->fetch_object()) {
            $no++;
            $link_referral = $row->web_replika . '/' . $session_id_member;
        ?>
        <div class="col-sm-4">
            <div class="card mt-2">
                <div class="card-body size-13">
                    <div class="row">
                        <div class="col align-self-center">
                            <div class="row">
                                <div class="col align-self-center">
                                    <a class="" href="<?= $link_referral ?>" class="fw-medium" id="link_referral<?= $no ?>"><?= $link_referral ?></a>
                                </div>
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-sm btn-transparent" onclick="copyToClipboard('#link_referral<?= $no ?>')">
                                        <i class="fa fa-clone"></i> Salin
                                    </button>
                                </div>
                            </div>
                            <a class="" href="https://api.whatsapp.com/send?text=Hallo kawan, ini ada informasi bisnis menarik, semoga bermanfaat buat kita semua, silahkan buka web saya ya <?= $link_referral ?>/<?= $data_member->user_member; ?>"><span class="text-dark">Bagikan ke No WA di Kontak Kamu - </span>Klik aja disini</a><br>
                            <a class="" href="https://www.facebook.com/sharer/sharer.php?u=<?= $link_referral ?>/<?= $data_member->user_member; ?>" target="_blank"> <span class="text-dark">Share on Facebook - </span>Klik aja disini </a>
                        </div>
                    </div>
                </div>
                <div class="row mx-0">
                    <div class="col-12">
                        <div class="progress bg-none h-2 hideonprogressbar" data-target="hideonprogress">
                            <div class="progress-bar bg-theme" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
        }
        ?>
            
        </div>
    </div>
</main>
<!-- Page ends-->
<?php include 'view/layout/nav-bottom.php'; ?>
<?php include 'view/layout/assets_js.php'; ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<?php include 'view/layout/footer.php'; ?>