<?php  
    session_start();
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';

    $cm = new classMember();
    $id_member = addslashes(strip_tags($_POST['id_member']));
    $data_sponsor = $cm->detail($id_member);
    if(!$data_sponsor){
        echo json_encode(['status' => false, 'message' => 'Data Tidak ditemukan.']);
        return false;
    }
    echo json_encode(['status' => true, 'sponsor_id' => $data_sponsor->sponsor, 'id_sponsor' => $data_sponsor->id_sponsor, 'nama_samaran_sponsor' => $data_sponsor->nama_samaran_sponsor]);
    return true;

?>