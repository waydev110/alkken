<?php
ob_start();
require_once '../../../helper/all_member.php';
require_once '../../../model/classAuth.php';

if(isset($_POST['cek_pin'])){
    
    $c = new classAuth();
    $id = $session_member_id;
    $pin = addslashes(strip_tags($_POST['cek_pin']));
    
    $result = $c->cek_pin($id, $pin);
    
    if($result == true){
        echo true;
    }else{
        echo "false";
    }
} else {
    redirect('404');
}