<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classBonusSupport.php';
    $obj = new classBonusSupport();
    $data = $obj->index_list($session_member_id);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .data-list {
        width: 100%;
    }

    .data-item {
        width: 100%;
    }

    th,
    td {
        font-size: 11px;
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
            if($data->num_rows > 0) {
            ?>
                <div class="data-list">
                <?php
                $no = 0;
                while($row = $data->fetch_object()) {
                    $no++;
                    $periode = $row->periode;
                    $nominal = $row->nominal;
                    $created_at = $row->created_at;
                ?>
                    <div class="card mb-0 rounded-5 border-0 border-bottom bonus-item">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="row">
                                        <div class="col-auto align-self-center pe-0">
                                            <div class="avatar avatar-30 bg-theme text-white rounded-pill"><?=$no?></div>
                                        </div>
                                        <div class="col align-self-center">
                                            <p class="mb-0 text-dark size-12">Autosave<br>Tanggal <?=tgl_bulan($created_at)?></p>
                                            <p class="mb-0 text-dark size-16">Bonus Support</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center text-end">
                                    <p class="text-default fw-bold mb-0 size-16"><?=rps($nominal)?></p>
                                    <p class="text-default fw-bold mb-0 size-12">selama <?=currency($periode)?> bulan</p>
                                    <a href="<?=site_url('bonus_support_detail')?>&id=<?=$row->id_autosave?>" class="btn btn-sm btn-primary rounded-pill">Detail Bonus</a>
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
                                <p class="mb-0"><span class="text-muted size-12">Tidak ada bonus.</span></p>
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
<?php include 'view/layout/footer.php'; ?>