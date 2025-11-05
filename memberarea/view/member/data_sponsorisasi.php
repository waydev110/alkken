<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    $sponsori = $cm->data_sponsori($session_member_id);
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
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-4 pb-4">
        <div class="row">
            <div class="col">
                <?php
            if($sponsori->num_rows > 0) {
                echo '<h5 class="mb-4">Total '.$lang['sponsor'].' = '.$sponsori->num_rows.'</h5>';
            ?>
                <div class="bonus-list">
                    <?php
                while($row = $sponsori->fetch_object()){
                    $tanggal = $row->created_at;
                    if($row->peringkat == 0){
                        $peringkat = 'Non Peringkat';
                        $cperingkat = 'muted';
                    } else {
                        $peringkat = $row->nama_peringkat;
                        $cperingkat = 'success';
                    }
                ?>
                    <div class="card mb-3 rounded-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="text-default fw-bold mb-0 size-12"><?=$row->id_member?></p>
                                    <p class="text-default fw-bold mb-0 size-14"><?=$row->nama_member?></p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
                <?php
            } else {
            ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center ps-0">
                                <p class="mb-0"><span class="text-muted size-12">Anda belum mensponsori.</span></p>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
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
    });
</script>
<?php include 'view/layout/footer.php'; ?>