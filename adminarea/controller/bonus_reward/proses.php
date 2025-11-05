<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
require_once '../../../model/classSMS.php';
$obj = new classManageBonus();
$csms = new classSMS();

$table = 'mlm_bonus_reward';
$nama_bonus = $lang['bonus_reward'];

$id = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');
$bonus = $obj->show_by_id($table, $id);
$id_member = $bonus->id_member;

$query = $obj->update_transfer_by_id($table, $id, $tanggal, $updated_at);
if($query){
    $csms->smsTransferBonus($id_member, $nama_bonus, $nominal_bonus, '', date('Y-m-d H:i:s'));
    echo json_encode(['status' => true, 'message' => 'Ditransfer']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$nama_bonus.' ditransfer.']);
}
?>