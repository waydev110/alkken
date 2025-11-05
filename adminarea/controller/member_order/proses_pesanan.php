<?php
require_once '../../../model/classMember.php';
require_once '../../../model/classMemberOrder.php';
require_once '../../../model/classMemberOrderDetail.php';
require_once '../../../model/classKodeAktivasi.php';
require_once '../../../model/classSMS.php';
require_once '../../../model/classBonusSponsor.php';
require_once '../../../model/classBonusGenerasi.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classStokisProduk.php';

$cm = new classMember();
$obj = new classMemberOrder();
$cmod = new classMemberOrderDetail();
$cka = new classKodeAktivasi();
$csms = new classSMS();
$cks = new classBonusSponsor();
$ckg = new classBonusGenerasi();
$cw = new classWallet();
$csp = new classStokisProduk();

$id_order = addslashes(strip_tags($_POST['id']));
$created_at = date('Y-m-d H:i:s');


$order = $obj->show($id_order);
$id_member = $order->id_member;
$member = $cm->show($id_member);
if (!$member) {
    echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan.']);
    return false;
}
$stokis_id = $order->stokis_id;
$order = $cmod->index($id_order);
// while($detail = $order->fetch_object()){
// $kode_aktivasi = $cka->generate_code(12);
// $cka->set_kode_aktivasi($kode_aktivasi);
// $cka->set_jumlah_hu($jumlah_hu);
// $cka->set_harga($nominal);  
// $cka->set_bonus_generasi($bonus_generasi);    
// $cka->set_status_aktivasi('0');
// $cka->set_id_member($id_member);
// $cka->set_id_stokis($id_stokis);
// $cka->set_created_at($created_at);

// $create_kodeaktivasi = $cka->create();

// if(!$create_kodeaktivasi){
//     echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Gagal membuat Kode Aktivasi.']);
//     return false;
// }
// }
$obj->set_status('1');
$obj->set_updated_at($created_at);
$obj->set_tgl_proses($created_at);
$update = $obj->update_status($id_order);
if (!$update) {
    // $csms->smsOrderProses($order->id_member, $order->nominal, $updated_at);
    echo json_encode(['status' => false, 'message' => 'Pesanan gagal diteruskan ke Stokis.']);
    return false;
}
$csp->create_member_order($id_order, 'd', $stokis_id, $created_at);
echo json_encode(['status' => true, 'message' => 'Pesanan berhasil diteruskan ke Stokis.']);
return false;
