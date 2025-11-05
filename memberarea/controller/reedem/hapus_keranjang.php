<?php   
session_start();
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCartReedem.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCartReedem();

if(!isset($_POST['id'])){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}
$id_member = $session_member_id;
$id = addslashes(strip_tags($_POST['id']));
$cart = $cc->show($id);
if(empty($cart)){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Keranjang tidak ditemukan.']);
    return false;
}
$deleted_at = date('Y-m-d H:i:s');
$cc->set_id($id);
$cc->set_id_member($id_member);
$cc->set_deleted_at($deleted_at); 
$delete = $cc->delete();
if(!$delete){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal mengupdate keranjang.']);
    return false;
}
$total_harga = rp($cc->total_harga($id_member));
echo json_encode(['status' => true, 'total_harga' => $total_harga]);
return true;

?>