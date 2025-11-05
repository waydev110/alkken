<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDepositCart.php';

    $obj = new classStokisDepositCart();

    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
    $delete = $obj->delete_cart($id_stokis, $id_stokis_tujuan);
    if(!$delete){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    echo json_encode(['status' => true, 'html' => '', 'subtotal' => rp(0), 'diskon' => rp(0), 'total' => rp(0)]);
    return true;