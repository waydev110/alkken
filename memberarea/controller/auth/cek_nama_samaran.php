<?php
ob_start();
require_once '../../../helper/all_member.php';

if(isset($_POST['username'])){
    require_once '../../../model/classAuth.php';
    
    $c = new classAuth();
    $user_member = strtolower(addslashes(strip_tags($_POST['username'])));
    
    $result = $c->cek_nama_samaran($user_member);
    if($result == true){
        echo json_encode(['status' => true]);
    }else{
        echo json_encode(['status' => false]);
    }
} else {
    echo json_encode(['status' => false]);
}