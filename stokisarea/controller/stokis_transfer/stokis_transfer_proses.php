<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisTransfer.php';
    
    $obj = new classStokisTransfer();

    if(!isset($_POST['id_transfer'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_transfer = addslashes(strip_tags($_POST['id_transfer']));
    $updated_at = date('Y-m-d H:i:s');
    $status_proses = '3';

    $obj->set_status($status_proses);
    $obj->set_id_stokis($id_stokis);
    $obj->set_updated_at($updated_at);
    $update_status = $obj->update_status($id_transfer, $id_stokis);
    if(!$update_status){
        echo json_encode(['status' => false, 'message' => 'Deposit Order tidak dapat dibatalkan.']);
        return false;
    }
    echo json_encode(['status' => true]);
    return true;