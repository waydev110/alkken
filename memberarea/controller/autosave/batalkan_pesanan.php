<?php   
session_start();
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMemberAutosave.php';
require_once '../../../model/classWallet.php';

$obj = new classMemberAutosave();
$cw = new classWallet();

if(!isset($_POST['id'])){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}
$id_member = $session_member_id;
$id = base64_decode($_POST['id']);

$order = $obj->pending($id, $id_member);
if(empty($order)){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Pesanan tidak ditemukan.']);
    return false;
}
$updated_at = date('Y-m-d H:i:s');
$obj->set_id($id);
$obj->set_id_member($id_member);
$obj->set_status('5');
$obj->set_updated_at($updated_at);
$update_status = $obj->batalkan_pesanan_member();  
if(!$update_status){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Pesanan gagal dibatalkan.']);
    return false;
}

$cw->delete($order->id_wallet, $id_member);
echo json_encode(['status' => true, 'message' => 'Terjadi Kesalahan. Pesanan berhasil dibatalkan.']);
return true;

?>