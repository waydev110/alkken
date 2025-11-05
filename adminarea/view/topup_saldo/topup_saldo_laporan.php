<?php 
require_once '../model/classMember.php';
$cm = new classMember();
require_once '../model/classTopupSaldo.php';
$obj = new classTopupSaldo();
$query = $obj->laporan();
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
                                <th class="text-center">Status</th>
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
                                <td class="text-center">
                                    <?=status_proses($data->status)?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" onclick="send_notif('<?=$data->id_member?>', '<?=$data->total_bayar?>', '<?=$data->updated_at?>', '<?=$data->id_member?>', this)" class="btn btn-info btn-xs"><i class="fa fa-bell"></i> Kirim Notif</button>
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
                                <th class="text-center">Status</th>
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
    function send_notif(id_member, nominal, updated_at, e) {
        if(confirm('Anda yakin ingin mengirim ulang notifikasi?') == true) {
            $.ajax({
                url: 'controller/topup_saldo/send_notif.php',
                data: {
                    id_member: id_member,
                    nominal: nominal,
                    updated_at: updated_at,
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