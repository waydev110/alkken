<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusRoAktif.php';
require_once '../../../model/classSMS.php';
$obj = new classBonusRoAktif();
$csms = new classSMS(); 

$admin = 5;
$limit_transfer = $_limit_transfer;
$updated_at = date('Y-m-d H:i:s');

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$arr_bonus = [
    'mlm_bonus_sponsor' => 'Bonus Sponsor RO Aktif',
    'mlm_bonus_cashback' => 'Bonus Cashback RO Aktif',
    'mlm_bonus_generasi' => 'Bonus Generasi RO Aktif',
    'mlm_bonus_upline' => 'Bonus Titik RO Aktif',
    'mlm_bonus_royalti_omset' => 'Bonus Royalti Omset RO Aktif'
];
foreach ($arr_bonus as $table => $label) {
    $query = $obj->update_transfer($table, $id_member, $tanggal, $updated_at, $admin);
    if(!$query){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$label.' gagal ditransfer.']);
    }
}
$csms->smsTransferBonus($id_member, 'Bonus', $nominal_bonus, '', date('Y-m-d H:i:s'));
echo json_encode(['status' => true, 'message' => 'Ditransfer']);
?>