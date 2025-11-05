<?php  
    session_start();
    require_once '../../../helper/all_member.php';
    require_once '../../../model/classMember.php';

    $cm = new classMember();
    $genealogy = $cm->genealogy_member($session_member_id);
    $member = $cm->detail($session_member_id);
    $option = '<option value="'.$session_member_id.'">'.$member->id_member.' ('.$member->nama_samaran.') - ROOT</option>';
    if($genealogy->num_rows > 0){
        while($row = $genealogy->fetch_object()) {
            $option .= '<option value="'.$row->id.'">'.$row->id_member.' ('.$row->nama_samaran.') - LEVEL '.$row->generasi.'</option>';
        }
    }
    echo json_encode(['status' => true, 'option' => $option]);
    return true;

?>