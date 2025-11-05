<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classStokisJualPinCart.php';

    $cm = new classMember();
    $obj = new classStokisJualPinCart();

    if(!isset($_POST['id_member'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_member = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$id_member){
        echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan.']);
        return false;
    }
    $delete = $obj->delete_cart($id_member, $id_stokis);
    if(!$delete){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    echo json_encode(['status' => true, 'html' => '', 'subtotal' => rp(0), 'total_nilai_produk' => '0', 'total' => rp(0)]);
    return true;