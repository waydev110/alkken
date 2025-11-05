<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusNetborn.php';
require_once '../../../model/classSMS.php';
$obj = new classBonusNetborn();
$csms = new classSMS(); 

$updated_at = date('Y-m-d H:i:s');

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$query = $obj->update_pending($id_member, $tanggal, $updated_at);
echo json_encode(['status' => true, 'message' => 'Dipending']);
?>