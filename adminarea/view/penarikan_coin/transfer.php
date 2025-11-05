<?php 
require_once("../model/classMember.php");
$cm = new classMember();
require_once("../model/classWithdraw.php");
$obj = new classWithdraw();
$query = $obj->index_transfer('coin');
$rupiah = $obj->rate_coin();
$coin = 1/$rupiah;
?>
<style>
    .fs-16 {
        font-size : 16px!important;
    }
    .fs-24 {
        font-size : 24px!important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Penarikan</h3>
                <div class="box-tools pull-right">
                    <a href="?go=riwayat_transfer_coin" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
                        Riwayat Transfer</a>
                </div>
            </div>
            <div class="box-body box-profile">
                <div class="table-responsive">  
                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green text-right">
                                <div class="inner">              
                                    <h4>
                                        1 coin = <?=rp($rupiah)?>
                                    </h4> 
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-3 col-xs-6">
                            <div class="small-box bg-green text-right">
                                <div class="inner">              
                                    <h4>
                                        Rp1 = <?=$coin?> coin
                                    </h4> 
                                </div>
                            </div>
                        </div>  
                        <div class="col-lg-6 col-xs-6">
                            <div class="small-box bg-green text-right">
                                <div class="inner"> 
                                    <form action="controller/rate_coin/rate_coin_create.php" method="post">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <h4>Rupiah</h4>

                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control fs-16 autonumeric3 text-right" name="rupiah" value="<?=$rupiah?>">

                                            </div>
                                            <div class="col-sm-4">
                                                <button class="btn btn-default fs-16 btn-sm pull-right">
                                                    Update Rate Coin</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>  
                    </div>  
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">ID Member</th>
                                <th class="text-center">Nama Member</th>
                                <th class="text-center">Address Coin</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Admin</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Rate Coin</th>
                                <th class="text-right">Total Coin</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no =1 ;
                            while ($data = $query->fetch_object()) {
                                $member = $cm->detail($data->id_member);
                                $total_coin = $data->total*$coin;
                            ?>
                            <tr>
                                <td class="text-center"><?=$no;?></td>
                                <td class="text-center"><?=$data->created_at?></td>
                                <td class="text-center"><?=$member->id_member?></td>
                                <td><?=$member->nama_member?></td>
                                <td><?=$member->address_coin?></td>
                                <td class="text-right"><?=currency($data->jumlah)?></td>
                                <td class="text-right"><?=currency($data->admin)?></td>
                                <td class="text-right"><?=currency($data->total)?></td>
                                <td class="text-right"><?=$coin?></td>
                                <td class="text-right"><?=$total_coin?></td>
                                <td class="text-center" id="aksi-<?=$no;?>">
                                    <button type="button" onclick="transfer(<?=$no?>, '<?=$data->id;?>')"
                                        class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i> Transfer</button>
                                    <button type="button" onclick="cancel(<?=$no?>, '<?=$data->id;?>')"
                                        class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Tolak</button>
                                </td>
                            </tr>
                            <?php
                                $no ++;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">ID Member</th>
                                <th class="text-center">Nama Member</th>
                                <th class="text-center">Address Coin</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Admin</th>
                                <th class="text-right">Total</th>
                                <th class="text-right">Rate Coin</th>
                                <th class="text-right">Total Coin</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function transfer(no, id) {
        $("#aksi-" + no).html(".........");
        $.ajax({
            url: 'controller/penarikan_poin/transfer.php',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'html',
            success: function (pesan) {
                if (pesan == "ok") {
                    $("#aksi-" + no).html("Ditransfer");
                }
            },
        });
    }
    function cancel(no, id) {
        $("#aksi-" + no).html(".........");
        $.ajax({
            url: 'controller/penarikan_poin/cancel.php',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'html',
            success: function (pesan) {
                if (pesan == "ok") {
                    $("#aksi-" + no).html("Dibatalkan");
                }
            },
        });
    }
</script>