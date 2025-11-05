<?php 
    require_once '../model/classDashboardStokis.php';
    $cd = new classDashboardStokis();
    $pin_order = $cd->pin_order($session_stokis_id);
    $saldo = $cd->saldo($session_stokis_id);
?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h4 class="text-right"><?=$pin_order?></h4>
                <p>Total Transaksi</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="<?=site_url('jual_pin_list')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h4 class="text-right"><?=currency($cd->stok_produk($session_stokis_id, 'debet'))?></h4>
                <p>Total Produk</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="<?=site_url('stok_produk')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h4 class="text-right"><?=currency($cd->stok_produk($session_stokis_id, 'kredit'))?></h4>
                <p>Produk Terjual</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="<?=site_url('stok_produk')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
            <h4 class="text-right"><?=currency($cd->stok_produk($session_stokis_id))?></h4>
                <p>Stok Produk</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?=site_url('stok_produk')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-lg-12 col-xs-12">
        <?php require_once('view/stok_produk/stok_produk.php') ?> 
    </div>
</div>
<script>
    var modalDetail = $('#modalDetail');
    var dataTable;
    $(document).ready(function () {
        dataTable = $("#example1").DataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1
        });
    });
</script>