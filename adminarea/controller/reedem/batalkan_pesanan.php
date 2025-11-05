<?php 

require_once '../../../model/classMemberReedem.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classMemberReedem();
$cw = new classWallet();

$id = addslashes(strip_tags($_POST['id']));

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('4');
$obj->set_updated_at($updated_at);
$update = $obj->update_status($id);

if($update){
    $order = $obj->show($id);
    $cw->delete($order->id_wallet);
    echo json_encode(['status' => true, 'message' => 'Order berhasil ditolak.']);
}else{
    echo json_encode(['status' => false, 'message' => 'Order gagal ditolak.']);
}
?>