<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
require_once '../../../model/classSMS.php';
$obj = new classManageBonus();
$csms = new classSMS(); 

$table = 'mlm_bonus_reward_paket';
$nama_bonus = $lang['bonus_reward'];

$id = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');

$query = $obj->update_reject_by_id($table, $id, $tanggal, $updated_at);
if(!$query){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$nama_bonus.' gagal disembunyikan.']);
}
echo json_encode(['status' => true, 'message' => 'Disembunyikan']);
?>