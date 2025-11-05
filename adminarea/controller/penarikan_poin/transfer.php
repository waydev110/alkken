<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWithdraw.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classWithdraw();


$id = addslashes(strip_tags($_POST['id']));
$penarikan = $obj->show($id);
$total = $penarikan->total;
if($penarikan->jenis_penarikan == 'coin') {

    $rupiah = $obj->rate_coin();
    $rate_coin = 1/$rupiah;
    $total_coin = $penarikan->total*$rate_coin;
    $obj->set_rate_coin($rate_coin);
    $obj->set_total_coin($total_coin);

    $total = $total_coin;

}
$updated_at = date('Y-m-d H:i:s',time());

$obj->set_updated_at($updated_at);
$update = $obj->update_transfer($id);

if($update){
	$csms->smsTransferPoin($penarikan->id_member, $penarikan->jenis_penarikan, 'Penarikan', $total, $updated_at);
	echo "ok";
}else{
	echo "false";
}
?>