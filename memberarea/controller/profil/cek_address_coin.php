<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['address_coin'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $address_coin = addslashes(strip_tags($_POST['address_coin']));
    
    $result = $cm->cek_address_coin($session_member_id, $address_coin);
    
    if($result == 0){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}