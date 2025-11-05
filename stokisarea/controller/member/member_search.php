<?php 
    require_once '../../../model/classMember.php';
    
    $obj = new classMember();

    $id_member = $_POST['id_member'];
    $member = $obj->show_by_id($id_member);
    if($member){
        echo json_encode(['status' => true, 'id_member' => $member->id_member, 'nama_member' => $member->nama_samaran]);
        return true;
    }
    echo json_encode(['status' => false, 'nama_member' => 'NOT FOUND']);
    return false;
?>