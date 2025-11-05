<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classStokisDepositCart.php';
    require_once '../../../model/classStokisPaket.php';

    $obj = new classStokisDepositCart();
    $csp = new classStokisPaket();
    
    $id_stokis = $_SESSION['session_stokis_id'];
    $id_paket_stokis = $_SESSION['session_paket_stokis'];

    if(!isset($_POST['id_produk'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_produk = addslashes(strip_tags($_POST['id_produk']));
    $id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
    $qty = number($_POST['qty']);
    $created_at = date('Y-m-d H:i:s');

    $total_keranjang = $obj->cek_keranjang($id_stokis, $id_stokis_tujuan, $id_produk);
    
    if($total_keranjang == 0){
        $created_at = date('Y-m-d H:i:s');
        $obj->set_id_stokis_tujuan($id_stokis_tujuan);
        $obj->set_id_stokis($id_stokis);
        $obj->set_id_produk($id_produk);
        $obj->set_qty($qty);
        $obj->set_status(0);
        $obj->set_created_at($created_at);
    
        $create = $obj->create();
        if(!$create){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal menambahkan ke keranjang.']);
            return false;
        }
    
    } else {
        $updated_at = date('Y-m-d H:i:s');
        $obj->set_id_stokis($id_stokis);
        $obj->set_id_produk($id_produk);
        $obj->set_qty($qty);
        $obj->set_updated_at($updated_at);
        $update = $obj->update();
        if(!$update){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal mengupdate keranjang.']);
            return false;
        }
    }
    
    $get_cart = $obj->get_cart($id_stokis, $id_stokis_tujuan);
    include 'card.php';
    $total = $subtotal - $fee_stokis;
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => rp($fee_stokis), 'total' => rp($total)]);
    return true;