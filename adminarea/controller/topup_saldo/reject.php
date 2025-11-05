<?php 

require_once '../../../helper/all.php';
require_once '../../../model/classTopupSaldo.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$obj = new classTopupSaldo();
$cw = new classWallet();
$csms= new classSMS();

$id = base64_decode($_POST['id']);
$updated_at = date('Y-m-d H:i:s',time());
$reject = $obj->update_reject($id, $updated_at);

if($reject > 0){
    $data = $obj->show($id);
    echo json_encode(['status' => true, 'message' => 'Direject']);
    $csms->smsProsesTopup($data->id_member, $data->nominal, $updated_at, $status);
    return false;
}else{
    echo json_encode(['status' => false, 'message' => 'Gagal']);
    return false;
}
?>