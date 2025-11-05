<?php 
require_once("../helper/all.php");
require_once("../model/classMember.php");
$cm = new classMember();
require_once("../model/classStokisMember.php");
$csm = new classStokisMember();
require_once("../model/classStokisDepositDetail.php");
$csdd = new classStokisDepositDetail();
require_once("../model/classBonus.php");
$cb = new classBonus();
$total_new_member = $cm->total_new_member();
$total_new_stokis = $csm->total_new_stokis();
$omset_deposit = $csdd->osmet_deposit();
$total_transfer = $cb->total_transfer();
?>
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?=currency($total_new_member) ?></h3>

                <p>New <?=$lang['member']?></p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="<?=site_url('member_list')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=currency($total_new_stokis) ?></h3>

                <p>New <?=$lang['stokis']?></p>
            </div>
            <div class="icon">
                <i class="fa fa-store"></i>
            </div>
            <a href="<?=site_url('stokis_member')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h4 style="margin-bottom:20px"><?=rp($omset_deposit) ?></h4>
                <p>Omset</p>
            </div>
            <div class="icon">
                <i class="fa fa-chart-line-up"></i>
            </div>
            <a href="<?=site_url('stokis_deposit_riwayat')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h4 style="margin-bottom:20px"><?=rp($total_transfer) ?></h4>
                <p>Bonus Ditransfer</p>
            </div>
            <div class="icon">
                <i class="fa fa-paper-plane"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>