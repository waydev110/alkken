<?php   
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCart.php';
require_once '../../../model/classCRUD.php';
require_once '../../../model/classMemberOrderDetail.php';
require_once '../../../model/classStokisMember.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCart();
$obj = new classCRUD();
$cmod = new classMemberOrderDetail();
$csm = new classStokisMember();


if(!isset($_POST['id_stokis'])){
    echo json_encode(['status' => false, 'message' => 'Pilih Stokis terlebih dahulu.']);
    return false;
}
$id_stokis = addslashes(strip_tags($_POST['id_stokis']));
$stokis = $csm->detail($id_stokis);
if(empty($stokis)){
    echo json_encode(['status' => false, 'message' => 'Stokis tidak ditemukan.']);
    return false;
}

$id_member = $session_member_id;

$created_at = date('Y-m-d H:i:s');
// $alamat_kirim = $_POST['alamat_kirim'];
$id_cart = $_POST['id_cart'];
$keterangan = ''; 
$member = $cm->detail($id_member);

$produk_cart = $cc->order($id_member);

while($row = $produk_cart->fetch_object()) {
    $obj->id_member = $id_member;
    $obj->id_stokis = $id_stokis;
    $obj->nominal = $row->nominal+mt_rand(100, 999);  
    $obj->id_provinsi = $member->id_provinsi;
    $obj->id_kota = $member->id_kota;   
    $obj->id_kecamatan = $member->id_kecamatan;
    $obj->id_kelurahan = $member->id_kelurahan;
    $obj->kodepos = $member->kodepos_member;
    $obj->alamat_kirim = $member->alamat_member; 
    $obj->status = -1;  
    $obj->created_at = $created_at; 
    $create = $obj->create('mlm_member_order');
    if(!$create){
        echo json_encode(['status' => false, 'message' => 'Pesanan gagal.']);
        return false;
    }
    $create_detail = $cmod->create($id_member, $create, $created_at);
    if(!$create_detail){
        echo json_encode(['status' => false, 'message' => 'Detail Pesanan gagal.']);
        return false;
    }
    $cc->set_id_member($id_member);
    $cc->set_checked('1');
    $cc->set_status('1');
    $cc->set_updated_at($created_at);
    $update_status = $cc->update_status();
}

$message = '<p class="text-center text-muted mb-2 size-18">Belanja Produk Berhasil</p>
<p class="text-center text-muted mb-2 size-12">Anda dapat mengecek status pesanan anda di halaman Riwayat Pesanan.</p>
';
echo json_encode(['status' => true, 'message' => $message]);
return true;

?>