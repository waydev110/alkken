<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['username_marketplace'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $username_marketplace = addslashes(strip_tags($_POST['username_marketplace']));
    
    $result = $cm->cek_username_marketplace($session_member_id, $username_marketplace);
    
    if($result == 0){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}