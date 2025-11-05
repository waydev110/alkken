<?php 
    require_once("../model/classMember.php");
    require_once("../model/classWallet.php");
    
    $cm = new classMember();
    $cw = new classWallet();

    $saldo_reward = $cw->saldo($session_member_id, 'reward');
?>
<?php include("view/layout/header.php"); ?>
<?php include("view/layout/loader.php"); ?>
<?php include("view/layout/sidebar.php"); ?>
<style>
    .item-reward {
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .item-reward:hover {
        border: 3px solid #3d7198;
    }
</style>
<link rel="stylesheet" href="assets/vendor/spinWheel/css/index.css"/>
<style>
    .wheel-wrapper {
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
        aspect-ratio: 1/1;
        position: relative;
    }

    .main-container {
        padding-top: 0px !important; /* beri jarak dari header */
        padding-bottom: 100px; /* beri jarak bawah jika tombol mepet */
    }

    .card.p-4.mb-5 {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    button {
        max-width: 300px;
    }

    .btn-spin {
        margin-top: 20px;
    }

    /* Jika ingin memastikan roda tidak terpotong */
    html, body {
        height: 100%;
        overflow-x: hidden;
    }
    body {
        font-family: "Arimo", sans-serif;
        font-weight: 400;
        font-size: 18px;
        overflow-y: auto;
        background-color: #e8eefc;
    }
</style>

<main class="h-100 has-header">
    <header class="header position-fixed bg-theme">
        <div class="row">
            <?php include("view/layout/back.php"); ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4">
                <a href="<?=site_url('riwayat_spin_reward')?>"><i class="fa fa-history"></i> Riwayat</a>
            </div>
        </div>
    </header>
    <div class="main-container pt-4" id="blockFirstForm" style="background-repeat:no-repeat; background-position:top;  background-size:cover;background-image: url(bgspin2.jpg);">
        <div class="row">
            <div class="col align-self-center px-2">
                <div class="card border-0 bg-transparent shadow-none mt-2 mb-2 text-center">
                    <div class="wheel-wrapper"></div>
                    <div class="row mt-1">
                        <div class="col align-self-center" id="btnContainer">
                            <?php if ($saldo_reward >= $_harga_spin) { ?>
                                <button class="btn btn-primary rounded-pill btn-spin px-5">Putar 1x <?=currency($_harga_spin)?></button>
                            <?php } else { ?>
                                <button class="btn btn-secondary rounded-pill px-5" disabled>Saldo tidak Cukup</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade bs-example-modal-md" id="modalHadiah" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body text-center pb-0">
                    <div id="reward-container">

                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary btn-sm py-2 px-4 fw-bold rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include("view/layout/assets_js.php"); ?>
<script type="module" src="view/spin/index.js"></script>
<?php include("view/layout/footer.php"); ?>