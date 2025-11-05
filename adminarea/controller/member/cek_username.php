<?php
ob_start();
require_once '../../../helper/all.php';

if(isset($_POST['user_member'])){
    require_once '../../../model/classMember.php';
    
    $c = new classMember();
    $current_user_member = addslashes(strip_tags($_POST['current_user_member']));
    $user_member = addslashes(strip_tags($_POST['user_member']));
    
    $result = $c->cek_username($user_member, $current_user_member);
    if($result == true){
        echo json_encode(['status' => true]);
    }else{
        echo json_encode(['status' => false]);
    }
} else {
    echo json_encode(['status' => false]);
}