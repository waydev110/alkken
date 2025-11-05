<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classWallet.php';
$cw = new classWallet();

$member_id = $_POST['member_id'];
$saldo_masuk = number($_POST['saldo_masuk']);
$saldo_keluar = number($_POST['saldo_keluar']);
$bulan = $_POST['bulan'];
$created_at = date('Y-m-t H:i:s', strtotime($bulan));
if($saldo_masuk > 0){
    $keterangan = 'Tambah Saldo Autosave oleh Admin '.currency($saldo_masuk);    
    $cw->set_id_member($member_id);
    $cw->set_jenis_saldo('poin');
    $cw->set_nominal($saldo_masuk);
    $cw->set_type('tupo_automaintain'); 
    $cw->set_keterangan($keterangan);
    $cw->set_status('d');
    $cw->set_status_transfer('0');
    $cw->set_dari_member($member_id);
    $cw->set_id_kodeaktivasi('0');
    $cw->set_dibaca('0');
    $cw->set_created_at($created_at);                 
    $tambah_saldo = $cw->create();
}
if($saldo_keluar > 0){
    $keterangan = 'Kurangi Saldo Autosave oleh Admin '.currency($saldo_keluar);    
    $cw->set_id_member($member_id);
    $cw->set_jenis_saldo('poin');
    $cw->set_nominal($saldo_keluar);
    $cw->set_type('kurangi_saldo'); 
    $cw->set_keterangan($keterangan);
    $cw->set_status('k');
    $cw->set_status_transfer('0');
    $cw->set_dari_member($member_id);
    $cw->set_id_kodeaktivasi('0');
    $cw->set_dibaca('0');
    $cw->set_created_at($created_at);                 
    $kurangi_saldo = $cw->create();
}
if($tambah_saldo && $kurangi_saldo){
    echo json_encode(['status' => true, 'message' => 'Tambah & Kurangi Saldo berhasil.']);
    return false;
} else if($tambah_saldo) {
    echo json_encode(['status' => true, 'message' => 'Tambah Saldo berhasil.']);
    return false;
} else if($kurangi_saldo) {
    echo json_encode(['status' => true, 'message' => 'Kurangi Saldo berhasil.']);
    return false;
} else {
    echo json_encode(['status' => false, 'message' => 'Gagal.']);
    return false;
}
?>