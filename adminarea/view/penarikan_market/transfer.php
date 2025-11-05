<?php 
require_once("../model/classMember.php");
$cm = new classMember();
require_once("../model/classWithdraw.php");
$obj = new classWithdraw();
$query = $obj->index_transfer('market');
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Penarikan</h3>
                <div class="box-tools pull-right">
                    <a href="?go=riwayat_transfer_market" class="btn btn-primary btn-sm pull-right"><i class="fas fa-paper-plane"></i>
                        Riwayat Transfer</a>
                </div>
            </div>
            <div class="box-body box-profile">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">ID Member</th>
                                <th class="text-center">Nama Member</th>
                                <th class="text-center">Username Marketplace</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Admin</th>
                                <th class="text-right">Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no =1 ;
                            while ($data = $query->fetch_object()) {
                                $member = $cm->detail($data->id_member);
                            ?>
                            <tr>
                                <td class="text-center"><?=$no;?></td>
                                <td class="text-center"><?=$data->created_at?></td>
                                <td class="text-center"><?=$member->id_member?></td>
                                <td><?=$member->nama_member?></td>
                                <td><?=$member->username_marketplace?></td>
                                <td class="text-right"><?=currency($data->jumlah)?></td>
                                <td class="text-right"><?=currency($data->admin)?></td>
                                <td class="text-right"><?=currency($data->total)?></td>
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
                                <th class="text-center">Username Marketplace</th>
                                <th class="text-right">Jumlah</th>
                                <th class="text-right">Admin</th>
                                <th class="text-right">Total</th>
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