<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWithdraw.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classWithdraw();
$cw = new classWallet();

$id = addslashes(strip_tags($_POST['id']));
$updated_at = date('Y-m-d H:i:s',time());

$obj->set_updated_at($updated_at);
$update = $obj->cancel_transfer($id);

if($update){
    $penarikan = $obj->show($id);
    $cw->delete($penarikan->id_wallet);
	$csms->smsCancelBonus($penarikan->id_member, $penarikan->total, $penarikan->updated_at);
	echo "ok";
}else{
	echo "false";
}
?>