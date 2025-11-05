<?php 
    include("model/classPeraihAutoMaintain.php");
    include("model/classProdukPaketAutoMaintain.php");
    include ("model/classAutoMaintain.php");
    
    $cam = new classAutoMaintain();
    $cpam = new classPeraihAutoMaintain();
    $cppam = new classProdukPaketAutoMaintain();
    
    $query = $cpam->index($session_member_id);
    $query_paket = $cppam->index();
    
    $total =$cam->cek_total_auto_maintain($session_member_id);
    $sisa_saldo =$cam->sisa_saldo($session_member_id);
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
            <div class="col-12">
                <div class="card rounded-0 mb-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4 class="size-14 p-4">Total Saldo Automaintain : <?=rp($total)?></h4>
                        </div>
                        <div class="col-sm-6">
                            <h4 class="size-14 p-4 bg-warning text-light">Sisa Saldo Automaintain : <?=rp($sisa_saldo)?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <?php
            if($query->num_rows > 0) {
            ?>
                <div class="swiper-container bonus-swiper mb-3">
                    <div class="filter-button-group swiper-wrapper">
                        <button class="btn-category swiper-slide tag active" type="button" data-option-value="*"
                            style="width:auto">
                            Semua
                        </button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".belum"
                            style="width:auto"> Belum diklaim</button>
                        <button class="btn-category swiper-slide tag" type="button" data-filter=".sudah"
                            style="width:auto">Sudah diklaim</button>
                    </div>
                </div>
                <div class="bonus-list">
                    <?php
                while($data = $query->fetch_object()){
                ?>
                    <div
                        class="card mb-0 rounded-0 border-0 border-bottom bonus-item <?=$data->status_klaim_produk == '0' ? 'belum':'sudah'?>">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <p class="mb-0 text-theme size-12"><?=bulan($data->created_at)?> <?=date('Y', strtotime($data->created_at))?></p>
                                    <p class="text-default fw-bold mb-0 size-16">
                                            <?=$data->id_produk_paketautomaintain=='0'? 'Belum diklaim':$cppam->get_nama_paket_produk($data->id_produk_paketautomaintain);?>
                                    </p>
                                    <p class="mb-0 text-theme size-12"><?=$data->resi_pengiriman == '' ? '':'No Resi : '.$data->resi_pengiriman?></p>
                                </div>
                                <div class="col-auto align-self-right">
                                    <?php
            						if($data->status_klaim_produk=='0'){
            							?>
                                    <button type="button" class="btn btn-default btn-sm rounded-pill"
                                        onclick="myModalKlaim('<?=$data->id;?>')"><i class="fa fa-tags"></i> Klaim
                                        Produk</button>
                                    <?php
            						}else{
            							?>
                                    <p class="mb-0 text-theme size-12"><?=tgl_indo_jam($data->updated_at)?></p>
                                    <a href="https://www.jet.co.id/track" accept-charset="UTF-8" id="track-package-form"
                                        target="_blank">
                                        <i class="fa fa-truck"></i> Trace & Track</a>
                                    </form>
                                    <?php
            						}
            						?>
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
    <!-- Modal -->
    <div class="modal fade" id="myModalKlaimAutoMaintain" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title size-14" id="myModalLabel">Klaim Produk Auto Maintain</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div class="modal-body">
                        <input type="hidden" name="id_klaim" id="id_klaim">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-floating mb-3">
                                    <select name="id_paket" id="id_paket" size="1" class="form-control" required="required">
                                        <option value="-" selected="selected">-- Pilih Paket Produk --</option>
                                        option
                                        <?php 
        							while ($data_paket = $query_paket->fetch_object()) {
        								echo '<option value="'.$data_paket->id.'">'.strtoupper($data_paket->nama_paket).'</option>';
        							}
        							?>
                                    </select>
                                    <label class="form-control-label" for="id_paket">Paket Produk</label>
                                </div>
                            </div>
                            <div class="col-12">
                               <div class="form-group form-floating mb-4">
                                   <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman"></textarea>
                                   <label class="form-control-label" for="alamat_pengiriman">Alamat</label>
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-default rounded-pill" onclick="klaimProduk()">Klaim sekarang</button>
                    </div>
                </form>
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

        var bonusSwiper = new Swiper(".bonus-swiper", {
            slidesPerView: "auto",
            spaceBetween: 10,
            pagination: false
        });

        var $grid = $('.bonus-list').isotope({
            // options...
            itemSelector: '.bonus-item',
            layoutMode: 'vertical',
        });

        // filter items on button click
        $('.filter-button-group').on('click', '.btn-category', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
            $('.btn-category').removeClass('active');
            $(this).addClass('active');
        });

    });
    function myModalKlaim(id_klaim) {
        $("#id_klaim").val(id_klaim);
        $('#myModalKlaimAutoMaintain').modal('show');
    }
        

    function klaimProduk(){

        if ($("#id_paket").val() == '-') {
            alert("Pilih Paket");
        } else
        if ($("#alamat_pengiriman").val() == '') {
            alert("Isi alamat pengiriman");
        } else {
            var id_klaim = $("#id_klaim").val();
            var id_paket = $("#id_paket").val();
            var alamat_pengiriman = $("#alamat_pengiriman").val();

            $.ajax({
                url: "controller/automaintain/klaim_produk_auto_maintain.php",
                data: { id_klaim:id_klaim, id_paket:id_paket, alamat_pengiriman:alamat_pengiriman},
                type: "POST",
                cache: false,
                success: function (result) {
                    if (result == "ok") {
                        alert('Berhasil klaim produk.');
                        document.location ="?go=klaim_produk_automaintain";
                    } else {
                        alert('Gagal klaim produk.');
                        document.location ="?go=klaim_produk_automaintain";

                    }
                }
            });
        }
    }
</script>
<?php include("view/layout/footer.php"); ?>