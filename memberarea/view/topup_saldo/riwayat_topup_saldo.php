<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classTopupSaldo.php';
    $obj = new classTopupSaldo();
    $data = $obj->index_member($session_member_id);
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
                while($row = $data->fetch_object()){
                    $tanggal = $row->status == '0' ? $row->created_at : $row->updated_at;
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom data-item">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="mt-3 mb-0 text-dark size-12 tag tab-danger py-1">
                                        <?=code_topup($row->id)?></p>
                                    <div class="row mt-2">
                                        <div class="col-auto pe-0">
                                            <div class="avatar avatar-20 rounded-circle bg-light text-dark size-12"><i
                                                    class="fa-light fa-building-columns"></i></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-muted size-11">
                                                Total Bayar : <?=rp($row->total_bayar)?>
                                                <br><?=$row->nama_bank?> -
                                                <?=$row->no_rekening?><br>
                                                a.n. <?=strtoupper($row->atas_nama_rekening)?><br>
                                                <?=$row->cabang_rekening?><br>
                                                </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center mt-3">
                                    <?=vtgl_bonus(tgl_indo($tanggal), jam($tanggal))?>
                                    <p class="text-end text-default fw-bold mt-1 mb-2 size-18"><?=currency($row->nominal)?></p>
                                    <p class="mt-4 text-muted size-12 end"><?=vstatus_normal($row->status)?></p>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada riwayat transfer.</span></p>

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