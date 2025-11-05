<?php 
require_once("../model/classMember.php");
$cm = new classMember();
require_once("../model/classWithdraw.php");
$obj = new classWithdraw();
$query = $obj->index_transfer('bank');
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Penarikan</h3>
            </div>
            <div class="box-body box-profile">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal Penarikan</th>
                                <th class="text-center">ID Member</th>
                                <th>Atas Nama</th>
                                <th>Nama Bank</th>
                                <th>No Rekening</th>
                                <th class="text-right">jumlah</th>
                                <th class="text-right">Admin</th>-->
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
                                <td><?=$member->atas_nama_rekening?></td>
                                <td><?=$member->nama_bank?></td>
                                <td><?=$member->no_rekening?></td>
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
                                <th>Atas Nama</th>
                                <th>Nama Bank</th>
                                <th>No Rekening</th>
                                <th class="text-right">jumlah</th>
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
            url: 'controller/penarikan/transfer.php',
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
            url: 'controller/penarikan/cancel.php',
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