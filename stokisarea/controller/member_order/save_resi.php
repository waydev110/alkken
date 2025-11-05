<?php 
session_start();
$session_stokis_id = $_SESSION['session_stokis_id'];
require_once '../../../helper/all.php';
require_once '../../../model/classMemberOrder.php';
require_once '../../../model/classSMS.php';

$csms= new classSMS();
$obj = new classMemberOrder();

$id = addslashes(strip_tags($_POST['id_order']));
$jasa_ekspedisi = addslashes(strip_tags($_POST['jasa_ekspedisi']));
$noresi = addslashes(strip_tags($_POST['noresi']));
$biaya_kirim = number($_POST['biaya_kirim']);

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('2');
$obj->set_jasa_ekspedisi($jasa_ekspedisi);
$obj->set_no_resi($noresi);
$obj->set_biaya_kirim($biaya_kirim);
$obj->set_updated_at($updated_at);
$update = $obj->save_resi_stokis($id, $session_stokis_id);

if(!$update){
    echo json_encode(['status' => false]);
    return false;
}
echo json_encode(['status' => true]);
return true;
?>