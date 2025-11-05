<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWithdraw.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classWithdraw();

$id = addslashes(strip_tags($_POST['id']));
$status_transfer = addslashes(strip_tags($_POST['status_transfer']));
$penarikan = $obj->show($id);
if($penarikan){
    if($status_transfer == '1'){        
        $total = $penarikan->total;
        if($penarikan->jenis_penarikan == 'coin') {
            $total = $penarikan->total_coin;
        }
        $csms->smsTransferPoin($penarikan->id_member,  $penarikan->jenis_penarikan, 'Penarikan', $total, $penarikan->updated_at);
    } else {
        $csms->smsCancelPoin($penarikan->id_member, $penarikan->total, $penarikan->updated_at);
    }
	echo "ok";
}else{
	echo "false";
}
?>