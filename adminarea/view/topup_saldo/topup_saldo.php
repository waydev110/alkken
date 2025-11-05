<?php 
require_once("../model/classMember.php");
$cm = new classMember();
require_once("../model/classTopupSaldo.php");
$obj = new classTopupSaldo();
$query = $obj->index();
?>
<style>
    th, td{
        font-size:12px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?=$title?></h3>
            </div>
            <div class="box-body box-profile">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">ID Member</th>
                                <th class="text-center">Nama Member</th>
                                <th class="text-center">Nominal Topup</th>
                                <th class="text-center">Bank</th>
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
                                <td class="text-center"><?=$data->created_at;?></td>
                                <td class="text-left"><?=$member->id_member;?></td>
                                <td class="text-left"><?=$member->nama_member;?></td>
                                <td class="text-right"><?=number_format($data->total_bayar,0,'.',',');?></td>
                                <td class="text-left"><?=$data->nama_bank;?> - <?=$data->no_rekening;?><br><?=$data->atas_nama_rekening;?></td>
                                <td class="text-center" width="140" id="aksi-<?=$no;?>">
                                    <div class="btn-group">
                                        <button type="button" onclick="reject('<?=base64_encode($data->id);?>', this)"
                                            class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Batalkan</button>
                                        <button type="button" onclick="proses('<?=base64_encode($data->id);?>', this)"
                                            class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i> Proses</button>
                                    </div>
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
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">ID Member</th>
                                <th class="text-center">Nama Member</th>
                                <th class="text-center">Nominal Topup</th>
                                <th class="text-center">Bank</th>
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
    function proses(id, e) {
        if(confirm('Anda yakin ingin memproses permintaan topup saldo ini?') == true) {
            $.ajax({
                url: 'controller/topup_saldo/proses.php',
                data: {
                    id: id
                },
                type: 'POST',
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $(e).closest('td').text(obj.message);
                    } else {
                        alert(obj.message);
                    }
                },
            });
        }
    }
    function reject(id, e) {
        if(confirm('Anda yakin ingin menolak permintaan topup saldo ini?') == true) {
            $.ajax({
                url: 'controller/topup_saldo/reject.php',
                data: {
                    id: id
                },
                type: 'POST',
                success: function (result) {
                    const obj = JSON.parse(result);
                    if (obj.status == true) {
                        $(e).closest('td').text(obj.message);
                    } else {
                        alert(obj.message);
                    }
                },
            });
        }
    }
</script>