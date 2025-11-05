<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classManageBonusNetborn.php';
require_once '../../../model/classSMS.php';
$obj = new classManageBonusNetborn();
$csms = new classSMS(); 

$table = 'mlm_bonus_balik_modal';
$nama_bonus = $lang['bonus_balik_modal'];

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');
$additional_conditions = [];

$query = $obj->update_pending($table, $id_member, $tanggal, $updated_at, $additional_conditions);
if(!$query){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$nama_bonus.' gagal ditampilkan.']);
}
echo json_encode(['status' => true, 'message' => 'Ditampilkan']);
?>