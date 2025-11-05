<?php
ob_start();
require_once '../../../helper/all_member.php';

if(isset($_POST['old_password'])){
    require_once '../../../model/classAuth.php';
    
    $c = new classAuth();
    $id = $session_member_id;
    $password = addslashes(strip_tags($_POST['old_password']));
    
    $result = $c->cek_password($id, $password);
    
    if($result == true){
        echo true;
    }else{
        echo "false";
    }
} else {
    redirect('404');
}