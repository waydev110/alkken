<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classManageBonusNetborn.php';
require_once('../../../model/classSaldoPenarikan.php');
require_once '../../../model/classSMS.php';
$obj = new classManageBonusNetborn();
$csp = new classSaldoPenarikan();
$csms = new classSMS();

$table = 'mlm_bonus_upline';
$nama_bonus = $lang['bonus_generasi'];

$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');
$additional_conditions = ["k.jenis_bonus IN (15,16,17)"];

$query = $obj->update_transfer($table, $id_member, $tanggal, $updated_at, $additional_conditions);
if($query) {
    $csp->id_member = $id_member;
    $csp->jenis_saldo = 'saldo_wd';
    $csp->nominal  = $nominal_bonus;
    $csp->type = 'transfer_bonus';
    $csp->status = 'k';
    $csp->keterangan = 'Transfer Bonus Netborn senilai '.rp($nominal_bonus);
    $csp->id_kodeaktivasi = 0;
    $csp->created_at = $updated_at;
    $csp->create();
    $csms->smsTransferBonus($id_member, $nama_bonus, $nominal_bonus, '', date('Y-m-d H:i:s'));
    echo json_encode(['status' => true, 'message' => 'Ditransfer']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. '.$nama_bonus.' ditransfer.']);
}
?>