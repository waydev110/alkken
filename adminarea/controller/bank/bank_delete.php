<?php 
    require_once '../../../helper/string.php';
    require_once '../../../model/classBank.php';
    $mod_url = 'bank';
    
    $obj = new classBank();
    $id = base64_decode($_POST['id']);
    $deleted_at = date('Y-m-d H:i:s');

    $obj->set_deleted_at($deleted_at);

    $delete = $obj->delete($id);

    if(!$delete){
        echo json_encode(['status' => false, 'message' => 'Bank gagal dihide.']);
        return false;
    }
    echo json_encode(['status' => true, 'message' => 'Bank berhasil dihide.']);
    return true;
?>