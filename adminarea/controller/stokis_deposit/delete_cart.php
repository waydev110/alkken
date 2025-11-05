<?php
    session_start();
    $id_admin = $_SESSION['id_login'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDepositCartByAdmin.php';

    $obj = new classStokisDepositCartByAdmin();

    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_stokis = addslashes(strip_tags($_POST['id_stokis']));
    $delete = $obj->delete_cart($id_stokis, $id_admin);
    if(!$delete){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    echo json_encode(['status' => true, 'html' => '', 'subtotal' => rp(0), 'total' => rp(0)]);
    return true;