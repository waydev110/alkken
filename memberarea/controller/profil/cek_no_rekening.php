<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['no_rekening'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $id = $session_member_id;
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    
    $result = $cm->cek_field_unique('no_rekening', $no_rekening, $id);
    
    if($result == 0){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}