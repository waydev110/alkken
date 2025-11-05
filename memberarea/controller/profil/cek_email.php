<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['email'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $email = addslashes(strip_tags($_POST['email']));
    
    $result = $cm->cek_email($email);
    
    if($result == 0){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}