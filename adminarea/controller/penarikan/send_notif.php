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
        $csms->smsTransferBonus($penarikan->id_member, 'Penarikan', $penarikan->total, $penarikan->updated_at);
    } else {
        $csms->smsCancelBonus($penarikan->id_member, $penarikan->total, $penarikan->updated_at);
    }
	echo "ok";
}else{
	echo "false";
}
?>