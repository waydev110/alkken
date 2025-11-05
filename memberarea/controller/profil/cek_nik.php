<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['nik'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $id = $session_member_id;
    $nik = addslashes(strip_tags($_POST['nik']));
    
    $result = $cm->cek_field_unique('no_ktp_member', $nik, $id);
    
    if($result == 0){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}