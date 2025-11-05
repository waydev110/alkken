<?php
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();

    $id = $session_member_id;
    $username_marketplace = addslashes(strip_tags($_POST['username_marketplace']));
    $address_coin = addslashes(strip_tags($_POST['address_coin']));
    $cm->set_username_marketplace($username_marketplace);
    $cm->set_address_coin($address_coin);

    $result = $cm->update($id);
    
    if($result == true){
        echo true;
    }else{
        echo "false";
    }
} else {
    echo "no token";
}