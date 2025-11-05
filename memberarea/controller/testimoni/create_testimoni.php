<?php
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classTestimoni.php';    
    
    $obj = new classTestimoni();

    if(!isset($_POST['testimoni'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }

    $testimoni = addslashes(strip_tags($_POST['testimoni'])); 
    $id_member = $session_member_id;
    $created_at = date('Y-m-d H:i:s');
    $obj->set_testimoni($testimoni);
    $obj->set_id_member($id_member);
    $obj->set_created_at($created_at);

    $create = $obj->create();
    if($create){
        echo json_encode(['status' => true, 'message' => 'Testimoni berhasil disubmit.']);
        return true;
    } else {
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal submit testimoni.']);
        return false;
    }
?>