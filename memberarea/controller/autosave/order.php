<?php   
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCartAutosave.php';
require_once '../../../model/classMemberAutosave.php';
require_once '../../../model/classMemberAutosaveDetail.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classPlan.php';
require_once '../../../model/classBonusSupport.php';
require_once '../../../model/classSMS.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCartAutosave();
$obj = new classMemberAutosave();
$cmod = new classMemberAutosaveDetail();
$cw = new classWallet();
$cpl = new classPlan();
$cbsr = new classBonusSupport();
$csms = new classSMS();
$sisa_saldo = $cw->saldo($session_member_id, 'poin');

$id_member = $session_member_id;

$created_at = date('Y-m-d H:i:s');
// $alamat_kirim = $_POST['alamat_kirim'];
$id_cart = $_POST['id_cart'];
$keterangan = ''; 
$member = $cm->detail($id_member);

$produk_cart = $cc->total_order($id_member);
if(!$produk_cart){
    echo json_encode(['status' => false, 'message' => 'Klaim Produk Autosave gagal.']);
    return false;
}
$total_bayar = $produk_cart->nominal;
$plan = $cpl->show(99);

$harga_autosave = $plan->harga;

if($total_bayar < $harga_autosave){

    echo json_encode(['status' => false, 'message' => 'Belum memenuhi syarat minimal klaim. Minimal Klaim '.rp($harga_autosave).'.']);
    return true;

}

if($total_bayar > $sisa_saldo){
    // $nominal = $total_bayar - $sisa_saldo + mt_rand(100, 999);
    // $saldo_poin = $sisa_saldo;
    // $status = -1;

    echo json_encode(['status' => false, 'message' => 'Saldo tidak cukup. Silahkan Topup Saldo terlebih dahulu.']);
    return true;
} else {
    $nominal = 0;
    $saldo_poin = $total_bayar;
    $status = 0;
}

$keterangan = 'Klaim produk Autosave sebesar '.currency($saldo_poin);
$cw->set_id_member($id_member);
$cw->set_jenis_saldo('poin');
$cw->set_nominal($saldo_poin);
$cw->set_type('penarikan');
$cw->set_keterangan($keterangan);
$cw->set_status('k');
$cw->set_status_transfer('0');
$cw->set_dari_member($id_member);
$cw->set_id_kodeaktivasi('0');
$cw->set_dibaca('0');
$cw->set_created_at($created_at);                 
$id_wallet = $cw->create();

if($id_wallet > 0){
    $obj->id_member = $id_member;
    $obj->qty = $produk_cart->qty;
    $obj->nominal = $nominal;
    $obj->saldo_poin = $saldo_poin;
    $obj->id_wallet = $id_wallet;
    $obj->status = $status;
    $obj->id_stokis = $produk_cart->id_stokis;
    $obj->id_provinsi = $member->id_provinsi;
    $obj->id_kota = $member->id_kota;
    $obj->id_kecamatan = $member->id_kecamatan;
    $obj->id_kelurahan = $member->id_kelurahan;
    $obj->alamat_kirim = $member->alamat_member;
    $obj->kodepos = $member->kodepos_member;
    $obj->keterangan = $keterangan;
    $obj->created_at = $created_at;
    $create = $obj->create();
    if(!$create){
        $cw->delete($id_wallet, $id_member);
        echo json_encode(['status' => false, 'message' => 'Klaim Produk Autosave gagal.']);
        return false;
    }

    $create_detail = $cmod->create($id_member, $produk_cart->id_stokis, $create, $created_at);
    if(!$create_detail){
        $obj->delete($create);
        $cw->delete($id_wallet, $id_member);
        echo json_encode(['status' => false, 'message' => 'Klaim Produk Autosave gagal.']);
        return false;
    }

    $cc->set_id_member($id_member);
    $cc->set_id_stokis($produk_cart->id_stokis);
    $cc->set_checked('1');
    $cc->set_status('1');
    $cc->set_updated_at($created_at);
    $update_status = $cc->update_status();
    
    $total = $nominal+$saldo_poin;
    $csms->smsKlaimAutosave($id_member, $total, $created_at);

    $message = '<p class="text-center text-muted mb-2 size-18">Klaim Produk Autosave Berhasil</p>
    <p class="text-center text-muted mb-2 size-12">Anda dapat mengecek status klaim anda di halaman Riwayat Klaim Produk.</p>
    ';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
} else {
    echo json_encode(['status' => false, 'message' => 'Klaim Produk Autosave gagal. Gagal mengurangi saldo wallet.']);
    return false;
}
?>