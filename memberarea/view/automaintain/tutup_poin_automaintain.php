<?php 
    include ("model/classAutoMaintain.php");
    include ("model/classTutupPoinAutoMaintain.php");
    
    $cam = new classAutoMaintain();
    $ctpam = new classTutupPoinAutoMaintain();

    $cek_tupo_bulan_ini = $ctpam->cek_id($session_member_id);
    $saldo_capaian_bulan_ini = $cam->index_tupo($session_member_id, date('Y-m', time()));
    $saldo_capaian_tupo      = $cam->get_max_auto('nominal_automaintain');

    $query = $ctpam->index($session_member_id);

?>
<?php include("view/layout/header.php"); ?>

<!-- loader section -->
<?php include("view/layout/loader.php"); ?>
<!-- loader section ends -->


<!-- Sidebar main menu -->
<?php include("view/layout/sidebar.php"); ?>

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
    <header class="header position-fixed">
        <div class="row">
            <?php include("view/layout/back.php"); ?>
            <div class="col align-self-center">
                <h5><?=$title?></h5>
            </div>
            <div class="col-auto px-4"></div>
        </div>
    </header>
    <!-- Header ends -->

    <!-- main page content -->
    <div class="main-container container pt-0">
        <div class="row">
            <div class="col">
                <div class="card mb-0 rounded-0 border-0 border-bottom">
                    <div class="card-body bg-warning">
                        <div class="row">
                          <?php
                            if($cek_tupo_bulan_ini){
                                if(($saldo_capaian_tupo - $saldo_capaian_bulan_ini) > 0){
                            ?>
                            <div class="col align-self-center">
                                <!--<p class="mb-0 text-theme size-12"><?=tgl_indo($data->created_at)?></p>-->
                                <p class="mb-0 size-11">Saldo Capaian</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($saldo_capaian_tupo,0,',','.');?>
                                </p>
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-11">Saldo Automaintain</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($saldo_capaian_bulan_ini,0,',','.');?>
                                </p>
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-11">KekuranganTupo</p>
                                <p class="text-default fw-bold mb-1 size-16">
                                    Rp<?=number_format($saldo_capaian_tupo - $saldo_capaian_bulan_ini,0,',','.');?>
                                </p>
                            </div>
                            <div class="col-sm-12 col-md-auto align-self-center text-end">
                                <form action="?go=form_tupo_automaintain" method="post" accept-charset="utf-8">
                                    <button type="submit" name="btn_tupo" class="btn btn-sm btn-dark rounded-pill"><i class="fa fa-sign-in"></i> Tutup Poin</button>
                                </form>
                             </div>
                                <?php
                                }else{
                                ?>
                                <p class="mb-0 size-14">Anda sudah tutup poin bulan ini.</p>
                            <?php
                                }
                            } else {
                                ?>
                                <p class="mb-0 text-theme size-14">Tidak ada data.</p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            if($query->num_rows > 0) {
            ?>
                <div>
                    <?php
                while($data = $query->fetch_object()){
                ?>
                    <div
                        class="card mb-0 rounded-0 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="mb-0 text-theme size-11">Tanggal Tutup Poin</p>
                                    <p class="text-default fw-bold mb-1 size-16">
                                        <?=tgl_indo($data->created_at)?>
                                    </p>
                                </div>
                                <div class="col align-self-center">
                                    <p class="mb-0 text-theme size-11">Nominal Capaian</p>
                                    <p class="text-default fw-bold mb-1 size-16">
                                        Rp<?=number_format($data->nominal_automaintain,0,',','.');?>
                                    </p>
                                </div>
                                <div class="col align-self-center">
                                    <p class="mb-0 text-theme size-11">Nominal Terakhir</p>
                                    <p class="text-default fw-bold mb-1 size-16">
                                        Rp<?=number_format($data->nominal_saldo,0,',','.');?>
                                    </p>
                                </div>
                                <div class="col align-self-center">
                                    <p class="mb-0 text-theme size-11">Nominal Tupo</p>
                                    <p class="text-default fw-bold mb-1 size-16">
                                        Rp<?=number_format($data->nominal_kekurangan,0,',','.');?>
                                    </p>
                                </div>
                                <div class="col-sm-12 col-md-auto align-self-center text-end">
                                    <p class="mb-0 text-theme size-12 text-end"><?=$data->tgl_diterima=='0000-00-00 00:00:00'?'<span class="text-red">Menungu</span>':date('d/m/Y', strtotime($data->tgl_diterima));?></p>
                                    <a href="?go=invoice_tupo&q=<?=base64_encode($data->id);?>" class="btn btn-light btn-sm"> <i class="fas fa-receipt"></i> Invoice</a>
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
                                <p class="mb-0"><span class="text-muted size-12">Belum ada bonus.</span></p>

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
<?php include("view/layout/nav-bottom.php"); ?>
<?php include("view/layout/assets_js.php"); ?>
<script src="assets/js/jquery.isotope.min.js"></script>
<script>
    $(document).ready(function () {
    });
</script>
<?php include("view/layout/footer.php"); ?>