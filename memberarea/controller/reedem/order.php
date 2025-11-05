<?php   
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCartReedem.php';
require_once '../../../model/classMemberReedem.php';
require_once '../../../model/classMemberReedemDetail.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classPlan.php';
require_once '../../../model/classBonusSupport.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCartReedem();
$obj = new classMemberReedem();
$cmod = new classMemberReedemDetail();
$cw = new classWallet();
$cpl = new classPlan();
$cbsr = new classBonusSupport();
$sisa_saldo = $cw->saldo($session_member_id, 'reedem');

$id_member = $session_member_id;

$created_at = date('Y-m-d H:i:s');
// $alamat_kirim = $_POST['alamat_kirim'];
$id_cart = $_POST['id_cart'];
$keterangan = ''; 
$member = $cm->detail($id_member);

$produk_cart = $cc->total_order($id_member);
if(!$produk_cart){
    echo json_encode(['status' => false, 'message' => 'Belanja Produk gagal.']);
    return false;
}
$total_bayar = $produk_cart->nominal;

if($total_bayar > $sisa_saldo){
    $nominal = $total_bayar - $sisa_saldo + mt_rand(100, 999);
    $saldo_poin = $sisa_saldo;
    $status = -1;
} else {
    $nominal = 0;
    $saldo_poin = $total_bayar;
    $status = 0;
}

$keterangan = 'Belanja Produk sebesar '.currency($saldo_poin);
$cw->set_id_member($id_member);
$cw->set_jenis_saldo('reedem');
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
    $obj->set_id_member($id_member);
    $obj->set_qty($produk_cart->qty);
    $obj->set_nominal($nominal);
    $obj->set_saldo_poin($saldo_poin);
    $obj->set_id_wallet($id_wallet);
    $obj->set_status($status);
    $obj->set_id_stokis($produk_cart->id_stokis);
    $obj->set_id_provinsi($member->id_provinsi);
    $obj->set_id_kota($member->id_kota);
    $obj->set_id_kecamatan($member->id_kecamatan);
    $obj->set_id_kelurahan($member->id_kelurahan);
    $obj->set_alamat_kirim($member->alamat_member);
    $obj->set_kodepos($member->kodepos_member);
    $obj->set_keterangan($keterangan);
    $obj->set_created_at($created_at);
    $create = $obj->create();
    if(!$create){
        $cw->delete($id_wallet, $id_member);
        echo json_encode(['status' => false, 'message' => 'Belanja Produk gagal.']);
        return false;
    }

    $create_detail = $cmod->create($id_member, $produk_cart->id_stokis, $create, $created_at);
    if(!$create_detail){
        $obj->delete($create);
        $cw->delete($id_wallet, $id_member);
        echo json_encode(['status' => false, 'message' => 'Belanja Produk gagal.']);
        return false;
    }

    $cc->set_id_member($id_member);
    $cc->set_id_stokis($produk_cart->id_stokis);
    $cc->set_checked('1');
    $cc->set_status('1');
    $cc->set_updated_at($created_at);
    $update_status = $cc->update_status();

    $message = '<p class="text-center text-muted mb-2 size-18">Belanja Produk Berhasil</p>
    <p class="text-center text-muted mb-2 size-12">Anda dapat mengecek status pesanan anda di halaman Riwayat Belanja Produk.</p>
    ';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
} else {
    echo json_encode(['status' => false, 'message' => 'Belanja Produk gagal. Gagal mengurangi saldo wallet.']);
    return false;
}
?>