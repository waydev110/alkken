<?php 
require_once("../helper/all.php");
require_once("../model/classUndianKupon.php");
$obj = new classUndianKupon();
?>

<style type="text/css">
    .table-custom>thead>tr>th,
    .table-custom>tfoot>tr>th {
        vertical-align: middle;
        border-bottom: 2px solid #fff;
        background: #5f8f66;
        color: #e8e8e8;
    }

    .table-custom>tbody>tr>td:last-child {
        vertical-align: middle;
    }

    .table-custom.table-striped>tbody>tr:nth-child(2n+1)>td,
    .table-custom.table-striped>tbody>tr:nth-child(2n+1)>th {
        background-color: #dff0d8;
    }

    .table-custom.table-striped>tbody>tr>td,
    .table-custom.table-striped>tbody>tr>th {
        padding: 4px 10px;
    }

    .table-custom.dataTable thead>tr>th.sorting_disabled {
        padding-right: 8px;
    }

    .table-primary>thead>tr>th,
    .table-primary>tfoot>tr>th {
        vertical-align: middle;
        border-bottom: 2px solid #fff;
        background: #605ca8;
        color: #e8e8e8;
    }

    .table-primary.table-striped>tbody>tr:nth-child(2n+1)>td,
    .table-primary.table-striped>tbody>tr:nth-child(2n+1)>th {
        background-color: #b2afe1;
    }
</style>


<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">STATISTIK KUPON UNDIAN</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h4><?=currency($obj->total_kupon(1))?></h4>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="index.php?go=kupon_bulanan" class="small-box-footer">Kupon Bulanan</a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h4><?=currency($obj->total_kupon(2))?></h4>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="index.php?go=kupon_tiga_bulanan" class="small-box-footer">Kupon Tiga Bulanan</a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h4><?=currency($obj->total_kupon(3))?></h4>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="index.php?go=kupon_tahunan" class="small-box-footer">Kupon Tahunan</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <a href="index.php?jenis_kupon=1" class="btn btn-lg btn-primary">Undi Kupon Bulanan</a>
    </div>
    <div class="col-lg-4 col-xs-6">
        <a href="index.php?jenis_kupon=2" class="btn btn-lg btn-primary">Undi Kupon Tiga Bulanan</a>
    </div>
    <div class="col-lg-4 col-xs-6">
        <a href="index.php?jenis_kupon=3" class="btn btn-lg btn-primary">Undi Kupon Tahunan</a>
    </div>
</div>