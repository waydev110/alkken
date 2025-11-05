<?php 

require_once '../../../helper/all.php';
require_once '../../../model/classMemberOrder.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';

$csms= new classSMS();
$obj = new classMemberOrder();
$cw = new classWallet();

$id = addslashes(strip_tags($_POST['id_order']));
$jasa_ekspedisi = addslashes(strip_tags($_POST['jasa_ekspedisi']));
$noresi = addslashes(strip_tags($_POST['noresi']));
$biaya_kirim = number($_POST['biaya_kirim']);

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('3');
$obj->set_jasa_ekspedisi($jasa_ekspedisi);
$obj->set_no_resi($noresi);
$obj->set_biaya_kirim($biaya_kirim);
$obj->set_updated_at($updated_at);
$update = $obj->save_resi($id);

if($update){
    echo "ok";
}else{
	echo "false";
}
?>