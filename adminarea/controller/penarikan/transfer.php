<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWithdraw.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classWithdraw();

$id = addslashes(strip_tags($_POST['id']));
$updated_at = date('Y-m-d H:i:s',time());

$obj->set_updated_at($updated_at);
$update = $obj->update_transfer($id);

if($update){
    $penarikan = $obj->show($id);
	$csms->smsTransferBonus($penarikan->id_member, 'Penarikan', $penarikan->total, $penarikan->updated_at);
	echo "ok";
}else{
	echo "false";
}
?>