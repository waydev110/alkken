<?php
require_once("../helper/all.php");
if ($_SESSION['level_login'] == '5' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1') {
    require_once("../model/classUndianKupon.php");
    $obj = new classUndianKupon();
    require_once("../model/classBonus.php");
    $cbns = new classBonus();
    // require_once("../model/classWallet.php");
    // $cw = new classWallet();

?>
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
            <a href="undian.php?jenis_kupon=1" class="btn btn-lg btn-block btn-default">Undi Kupon Bulanan</a>
        </div>
        <div class="col-lg-4 col-xs-6">
            <a href="undian.php?jenis_kupon=2" class="btn btn-lg btn-block btn-warning">Undi Kupon Tiga Bulanan</a>
        </div>
        <div class="col-lg-4 col-xs-6">
            <a href="undian.php?jenis_kupon=3" class="btn btn-lg btn-block btn-danger">Undi Kupon Tahunan</a>
        </div>
    </div>
    <br>
<?php }
if ($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1') {
?>
    <?php
    require_once("../model/classHome.php");
    $ch = new classHome();

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

    <?php
    if ($_SESSION['level_login'] == '3' || $_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1') {

    ?>
        <?php $statistik_bonus = $cbns->statistik_bonus();
        if ($statistik_bonus->num_rows > 0) {

        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">STATISTIK BONUS</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Jenis Bonus</th>
                                    <th class="text-center">Ditransfer</th>
                                    <th class="text-center">Pending</th>
                                    <th class="text-center">Reject</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $total_transfer = 0;
                                $total_pending = 0;
                                $total_reject = 0;
                                $total_bonus = 0;
                                while ($row = $statistik_bonus->fetch_object()) {
                                    $no++;
        
                                    $total_transfer += $row->transfer;
                                    $total_pending += $row->pending;
                                    $total_reject += $row->reject;
                                    $total_bonus += $row->total;
        
        
                                ?>
                                    <tr>
                                        <td class="text-center"><?=$no?></td>
                                        <td><?=strtoupper($lang[$row->type])?></td>
                                        <td class="text-right"><?=rp($row->transfer)?></td>
                                        <td class="text-right"><?=rp($row->pending)?></td>
                                        <td class="text-right"><?=rp($row->reject)?></td>
                                        <td class="text-right"><?=rp($row->total)?></td>
                                    </tr>
                                <?php
                                }
        
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th class="text-right"><?=rp($total_transfer)?></th>
                                    <th class="text-right"><?=rp($total_pending)?></th>
                                    <th class="text-right"><?=rp($total_reject)?></th>
                                    <th class="text-right"><?=rp($total_bonus)?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

            <!-- <div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">STATISTIK WALLET</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Wallet</th>
                            <th class="text-center">Masuk</th>
                            <th class="text-center">Keluar</th>
                            <th class="text-center">Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>Wallet Cash</td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('cash')->masuk)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('cash')->keluar)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('cash')->sisa)
                                                    ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td>Wallet Autosave</td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('poin')->masuk)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('poin')->keluar)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('poin')->sisa)
                                                    ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td>Wallet Reedem</td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('reedem')->masuk)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('reedem')->keluar)
                                                    ?></td>
                            <td class="text-right"><?php
                                                    // rp($cw->saldo_wallet('reedem')->sisa)
                                                    ?></td>
                        </tr> -->
            <!--<tr>-->
            <!--    <td class="text-center">4</td>-->
            <!--    <td>Admin</td>-->
            <!--    <td class="text-right" colspan="3"><?php
                                                        // rp($cw->saldo_wallet('admin')->masuk)
                                                        ?></td>-->
            <!--</tr>-->
            <!-- </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->
    <?php
        }
    }

    ?>

    <?php
    if ($_SESSION['level_login'] == '2' || $_SESSION['level_login'] == '1') {

    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">STATISTIK DEPOSIT STOKIS</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=rp($ch->get_deposit_stokis('subtotal'))?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Total Nominal</a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=rp($ch->get_deposit_stokis('diskon'))?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Total Diskon</a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=rp($ch->get_deposit_stokis('nominal'))?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Total Deposit</a>
            </div>
        </div>
    </div>
    <?php }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">STATISTIK LAINNYA</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_member_today(), 0, '.', '.');?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Member Hari ini</a>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_member(), 0, '.', '.');?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Total Member</a>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_stokis(), 0, '.', '.');?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Total Stokis</a>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_pin_ro('1') + $ch->get_total_pin_ro('0'), 0, '.', '.');?></h4>
                    </h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Total PIN RO</a>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_pin('0'), 0, '.', '.');?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Total PIN Pending</a>
            </div>
        </div>
        <div class="col-lg-2 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=number_format($ch->get_total_pin('1'), 0, '.', '.');?></h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Total PIN Aktif</a>
            </div>
        </div>
    </div>
    <!-- <div class="row">
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-danger" onclick="rekap_bonus_pasangan(4)">Rekap Bonus
            Pasangan</button>
    </div>
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-danger" onclick="rekap_bonus_support()">Rekap Bonus
            Support</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-primary" onclick="rekap_bonus('sponsor')">Rekap Wallet Bonus Sponsor</button>
    </div>
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-primary" onclick="rekap_bonus('pasangan')">Rekap Wallet Bonus Pasangan</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-primary" onclick="reset_poin(11, 'reward')">Reset Poin Reward
            Promo Titik</button>
    </div>
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-warning" onclick="reset_poin(12, 'reward_pribadi')">Reset Poin
            Reward Promo Sponsor</button>
    </div>
    <div class="col-lg-4 col-xs-6">
        <button type="button" class="btn btn-block btn-info" onclick="reset_poin(13, 'reward_pribadi')">Reset Poin
            Reward Promo Poin Sponsor</button>
    </div>
</div> -->

<?php
}

?>
<script>
    // function reset_poin(id_plan, jenis_reward) {
    //     if (confirm('Apakah anda yakin akan mereset Poin Reward?')) {
    //         $.ajax({
    //             url: 'controller/reward/reset_poin.php',
    //             type: 'post',
    //             data: {
    //                 id_plan: id_plan,
    //                 jenis_reward: jenis_reward,
    //             },
    //             success: function(result) {
    //                 const obj = JSON.parse(result);
    //                 if (obj.status == true) {
    //                     alert(obj.message);
    //                     window.location = "index.php";
    //                 } else {
    //                     alert(obj.message);
    //                 }
    //             }
    //         });
    //     }
    // }

    // function rekap_bonus_pasangan(id_plan) {
    //     if (confirm('Apakah anda yakin akan merekap Bonus Pasangan?')) {
    //         $.ajax({
    //             url: 'controller/bonus_pasangan/rekap_bonus_baru.php',
    //             type: 'post',
    //             data: {
    //                 id_plan: id_plan
    //             },
    //             success: function(result) {
    //                 const obj = JSON.parse(result);
    //                 if (obj.status == true) {
    //                     alert(obj.message);
    //                     window.location = "index.php";
    //                 } else {
    //                     alert(obj.message);
    //                 }
    //             }
    //         });
    //     }
    // }

    // function rekap_bonus(bonus) {
    //     if (confirm('Apakah anda yakin akan merekap wallet Bonus?')) {
    //         $.ajax({
    //             url: 'controller/bonus_' + bonus + '/rekap_bonus.php',
    //             type: 'post',
    //             success: function(result) {
    //                 const obj = JSON.parse(result);
    //                 if (obj.status == true) {
    //                     alert(obj.message);
    //                     window.location = "index.php";
    //                 } else {
    //                     alert(obj.message);
    //                 }
    //             }
    //         });
    //     }
    // }

    // function rekap_bonus_support() {
    //     if (confirm('Apakah anda yakin akan merekap Bonus Support?')) {
    //         $.ajax({
    //             url: 'controller/bonus_support/rekap_bonus_support.php',
    //             type: 'post',
    //             success: function(result) {
    //                 const obj = JSON.parse(result);
    //                 if (obj.status == true) {
    //                     alert(obj.message);
    //                     window.location = "index.php";
    //                 } else {
    //                     alert(obj.message);
    //                 }
    //             }
    //         });
    //     }
    // }
</script>