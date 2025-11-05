<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classStokisCashback.php';
require_once '../../../model/classSMS.php';
$obj = new classStokisCashback();
$csms = new classSMS();

$id_stokis = $_POST['id_stokis'];
$id_rekening = $_POST['id_rekening'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$updated_at = date('Y-m-d H:i:s');

$query = $obj->update_transfer($id_stokis, $id_rekening, $tanggal, $updated_at);
if($query){
    $csms->smsTransferStokisCashback($id_stokis,  $id_rekening, 'Fee Stokis', $nominal_bonus, '', date('Y-m-d H:i:s'));
    echo json_encode(['status' => true, 'message' => 'Ditransfer']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Bonus gagal ditransfer.']);
}
?>