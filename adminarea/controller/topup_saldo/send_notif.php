<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classSMS.php';
$csms = new classSMS(); 

$id_member = $_POST['id_member'];
$nominal = $_POST['nominal'];
$updated_at = $_POST['updated_at'];
$status = 'proses';

$csms->smsProsesTopup($id_member, $nominal, $updated_at, $status);
echo json_encode(['status' => true, 'message' => 'Terkirim']);
?>