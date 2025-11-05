<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
require_once '../../../model/classSMS.php';
$obj = new classManageBonus();
$csms = new classSMS();

$table = 'mlm_bonus_cashback';
$nama_bonus = $lang['bonus_cashback'];

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');
$additional_conditions = ["k.jenis_bonus = '14'"];

$query = $obj->update_transfer($table, $id_member, $tanggal, $updated_at, $additional_conditions);
if($query){
    $csms->smsTransferBonus($id_member, $nama_bonus, $nominal_bonus, '', date('Y-m-d H:i:s'));
    echo json_encode(['status' => true, 'message' => 'Ditransfer']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$nama_bonus.' ditransfer.']);
}
?>