<?php   
session_start();
require_once '../../../model/classMember.php';

$cm = new classMember();

$sponsor = $session_member_id;
$upline = $cm->show_id_upline(addslashes(strip_tags($_POST['upline'])));
if($upline){
    $data = $cm->cek_upline($upline, $sponsor);
    
    if($data->num_rows > 0){		
        $member = $cm->show($upline);	
        echo json_encode($member);
    }else{
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}
?>