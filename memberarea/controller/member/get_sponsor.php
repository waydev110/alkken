<?php  
    session_start();
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';

    $cm = new classMember();
    $sponsor = addslashes(strip_tags($_POST['sponsor']));
    $sponsor = $cm->show_id($sponsor);
    if(!$sponsor){
        echo json_encode(['status' => false, 'message' => 'Data Tidak ditemukan.']);
        return false;
    }
    $upline = base64_decode(addslashes(strip_tags($_POST['upline'])));
    $data_sponsor = $cm->data_sponsor($session_member_id, $sponsor, $upline);
    if(!$data_sponsor){
        echo json_encode(['status' => false, 'upline' => $upline, 'message' => 'Data Sponsor Tidak ditemukan.']);
        return false;
    }
    echo json_encode(['status' => true, 'sponsor_id' => $data_sponsor->id, 'id_sponsor' => $data_sponsor->id_member, 'nama_samaran_sponsor' => $data_sponsor->nama_samaran]);
    return true;

?>