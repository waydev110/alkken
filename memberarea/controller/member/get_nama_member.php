<?php
if(isset($_POST['id_member'])){
    require_once '../../../helper/session.php';    
    require_once '../../../model/classMember.php';
    $cm = new classMember();
    
    $id_member_lama = $_SESSION['session_id_member'];
    $id_member_baru = addslashes(strip_tags($_POST['id_member']));
    if($id_member_lama == $id_member_baru){
        echo json_encode(['status' => false, 'message' => 'Tidak dapat mengirim ke akun sendiri.']);
        return false;
    }
    $result = $cm->show_nama($id_member_baru);

    if($result){
        $id = base64_encode($result->id);
        $id_member = $result->id_member;
        $nama_member = strtoupper($result->nama_member);
        echo json_encode(['status' => true, 'id' => $id, 'id_member' => $id_member, 'nama_member' => $nama_member]);
    } else {
        echo json_encode(['status' => false, 'message' => 'Tidak ditemukan.']);
        return false;
    }
}