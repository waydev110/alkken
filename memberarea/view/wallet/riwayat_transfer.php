<?php 
    require_once '../model/classMember.php';
    $cm = new classMember();
    require_once '../model/classBonus.php';
    $obj = new classBonus();
    if(isset($_GET['jenis_bonus'])){
        $jenis_bonus = $_GET['jenis_bonus'];
    } else {
        redirect('404');
    }
    $data = $obj->riwayat_transfer($session_member_id, $jenis_bonus);
?>
<?php include 'view/layout/header.php'; ?>

<!-- loader section -->
<?php include 'view/layout/loader.php'; ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include 'view/layout/sidebar.php'; ?>

<!-- Sidebar main menu ends -->
<style type="text/css">
    .data-list{
        width: 100%;
    }
    .data-item{
        width: 100%;
    }
    th, td {
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
                <h5><?=$title?> Bonus <?=$lang[$jenis_bonus]?></h5>
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
                    $tanggal = $row->updated_at;
                    $member = $cm->detail($row->id_member);
                ?>
                    <div class="card mb-0 rounded-0 border-0 border-bottom data-item">
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col align-self-center">
                                    <div class="row mt-2">
                                        <div class="col-auto pe-0">
                                            <div class="avatar avatar-20 rounded-circle bg-light text-dark size-12"><i
                                        class="fa-light fa-building-columns"></i></div>
                                        </div>
                                        <div class="col">
                                            <p class="text-muted size-11"><?=$member->nama_bank?> - <?=$member->no_rekening?><br>
                                            a.n. <?=strtoupper($member->atas_nama_rekening)?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-right text-end mt-3">
                                    <p class="pt-2 lh-xs size-11 text-end">
                                        <?=tgl_indo_jam($tanggal)?>
                                    </p>
                                    <span class="text-default fw-bold mb-1 size-18"><?=rp($row->jumlah)?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-grid mt-2 text-end">
                                    <button type="button" class="btn btn-sm btn-light rounded-pill py-1 px-2 text-lowercase btn-detail" data-bs-toggle="collapse" href="#detail<?=strtotime($row->updated_at)?>"
                            role="button" aria-expanded="false" aria-controls="collapseExample"><span class="size-12"><i class="fa-solid fa-chevron-down"></i></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="collapse block-detail mt-0" id="detail<?=strtotime($row->updated_at)?>">
                            <?php
                                $details = $obj->detail_transfer($session_member_id, $row->updated_at);
                                while($detail = $details->fetch_object()) {
                                    $tanggal = $detail->updated_at;
                                
                            ?>
                            
                            <div class="card mb-0 rounded-0 border-0 border-bottom bonus-item <?=$detail->type?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-auto align-self-right">
                                            <p class="text-default fw-bold mb-1 size-18">
                                                <?=rp($detail->nominal)?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <p class="mb-0 text-muted size-11"><?=$detail->keterangan?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
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