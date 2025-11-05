<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classSMS.php';
$csms = new classSMS(); 

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$csms->smsTransferBonus($id_member, 'Bonus', $nominal_bonus, '', $tanggal);
echo json_encode(['status' => true, 'message' => 'Terkirim']);
?>