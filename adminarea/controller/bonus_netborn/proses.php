<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusNetborn.php';
require_once('../../../model/classSaldoPenarikan.php');
require_once '../../../model/classSMS.php';
$obj = new classBonusNetborn();
$csp = new classSaldoPenarikan();
$csms = new classSMS(); 
$updated_at = date('Y-m-d H:i:s');

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$query = $obj->update_transfer($id_member, $tanggal, $updated_at);
if($query){
    $csp->id_member = $id_member;
    $csp->jenis_saldo = 'saldo_wd';
    $csp->nominal  = $nominal_bonus;
    $csp->type = 'transfer_bonus';
    $csp->status = 'k';
    $csp->keterangan = 'Transfer Bonus Netborn senilai '.rp($nominal_bonus);
    $csp->id_kodeaktivasi = 0;
    $csp->created_at = $updated_at;
    $csp->create();               
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Bonus gagal ditransfer.']);
    return false;
}
$csms->smsTransferBonus($id_member, 'Bonus', $nominal_bonus, '', date('Y-m-d H:i:s'));
echo json_encode(['status' => true, 'message' => 'Ditransfer']);
?>