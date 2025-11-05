<?php   
require_once '../../../helper/all_member.php';
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCartReedem.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCartReedem();

if(!isset($_POST['id'])){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}

$id_stokis = 0;
if(isset($_POST['id_stokis'])){
    $id_stokis = addslashes(strip_tags($_POST['id_stokis']));
}

$id_member = $session_member_id;
$id_produk = addslashes(strip_tags($_POST['id']));
if(isset($_POST['qty'])){
    $qty = addslashes(strip_tags($_POST['qty']));
} else {
    $qty = 1;
}

$produk = $cp->show($id_produk);
if(empty($produk)){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Produk tidak ditemukan.']);
    return false;
}

$total_keranjang = $cc->cek_keranjang($id_member, $id_produk);
if($total_keranjang == 0){
    $created_at = date('Y-m-d H:i:s');
    $cc->set_id_member($id_member);
    $cc->set_id_stokis($id_stokis);
    $cc->set_id_produk($id_produk);
    $cc->set_qty($qty);
    $cc->set_status(0);
    $cc->set_created_at($created_at);

    $create = $cc->create();
    if(!$create){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal menambahkan ke keranjang.']);
        return false;
    }

} else {
    $updated_at = date('Y-m-d H:i:s');
    $cc->set_id_member($id_member);
    $cc->set_id_produk($id_produk);
    $cc->set_qty($qty);
    $cc->set_updated_at($updated_at);
    $update = $cc->update();
    if(!$update){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal mengupdate keranjang.']);
        return false;
    }
}

$total_harga = rp($cc->total_harga($id_member));
echo json_encode(['status' => true, 'total_harga' => $total_harga]);
return true;

?>