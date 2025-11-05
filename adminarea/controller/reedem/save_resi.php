<?php 

require_once '../../../helper/all.php';
require_once '../../../model/classMemberReedem.php';
require_once '../../../model/classSMS.php';

$csms= new classSMS();
$obj = new classMemberReedem();

$id = addslashes(strip_tags($_POST['id_order']));
$jasa_ekspedisi = addslashes(strip_tags($_POST['jasa_ekspedisi']));
$no_resi = addslashes(strip_tags($_POST['noresi']));
$biaya_kirim = number($_POST['biaya_kirim']);

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('2');
$obj->set_jasa_ekspedisi($jasa_ekspedisi);
$obj->set_no_resi($no_resi);
$obj->set_biaya_kirim($biaya_kirim);
$obj->set_updated_at($updated_at);
$update = $obj->save_resi($id);

if($update){
    $data = $obj->show($id);
    $csms->smsKirimProduk($data->id_member, $updated_at, $data->qty, $data->nama_jasa_ekspedisi,$no_resi, currency($biaya_kirim));
    echo json_encode(['status' => true, 'message' => 'Resi berhasil disimpan.']);
}else{
    echo json_encode(['status' => false, 'message' => 'Resi gagal disimpan.']);
}
?>