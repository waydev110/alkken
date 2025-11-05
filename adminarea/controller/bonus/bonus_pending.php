<?php 
$request = $_REQUEST;

require_once '../../helper/all.php';
require_once '../../model/classBonus.php';
require_once '../../model/classSMS.php';
$obj = new classBonus();
$csms = new classSMS(); 

$admin = $_admin;
$limit_transfer = $_limit_transfer;
$updated_at = date('Y-m-d H:i:s');

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$arr_bonus = [
    'mlm_bonus_sponsor' => 'Bonus Sponsor',
    'mlm_bonus_sponsor_monoleg' => 'Bonus Sponsor Monoleg',
    'mlm_bonus_pasangan' => 'Bonus Pasangan'
];
foreach ($arr_bonus as $table => $label) {
    $query = $obj->update_pending($table, $id_member, $tanggal, $updated_at);
    if(!$query){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$label.' gagal dipending.']);
    }
}
echo json_encode(['status' => true, 'message' => 'Dipending']);
?>