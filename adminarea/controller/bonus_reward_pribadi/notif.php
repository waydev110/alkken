<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classSMS.php';
$csms = new classSMS(); 

$table = 'mlm_bonus_reward_paket';
$nama_bonus = $lang['bonus_reward'];

$id = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$bonus = $obj->show_by_id($table, $id);
$id_member = $bonus->id_member;

$csms->smsTransferBonus($id_member, $nama_bonus, $nominal_bonus, '', $tanggal);
echo json_encode(['status' => true, 'message' => 'Terkirim']);
?>