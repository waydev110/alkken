<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDeposit.php';
    
    $obj = new classStokisDeposit();

    if(!isset($_POST['id_deposit'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_deposit = addslashes(strip_tags($_POST['id_deposit']));
    $updated_at = date('Y-m-d H:i:s');
    $status_proses = '3';

    $obj->set_status($status_proses);
    $obj->set_id_stokis($id_stokis);
    $obj->set_updated_at($updated_at);
    $update_status = $obj->update_status($id_deposit, $id_stokis);
    if(!$update_status){
        echo json_encode(['status' => false, 'message' => 'Deposit Order tidak dapat dibatalkan.']);
        return false;
    }
    echo json_encode(['status' => true]);
    return true;