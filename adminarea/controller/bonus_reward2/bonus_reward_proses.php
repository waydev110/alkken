<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusReward.php';
require_once '../../../model/classSMS.php';
$obj = new classBonusReward();
$csms = new classSMS();

$id = $_POST['id'];
$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');

$query = $obj->update_transfer($id, $id_member, $tanggal, $updated_at);
if($query){
    $csms->smsTransferBonus($id_member, 'Bonus Reward', $nominal_bonus, '', date('Y-m-d H:i:s'));
    echo json_encode(['status' => true, 'message' => 'Ditransfer']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Bonus gagal ditransfer.']);
}
?>