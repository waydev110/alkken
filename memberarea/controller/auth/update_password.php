<?php
ob_start();
require_once '../../../helper/all_member.php';

if(isset($_POST['new_password']) && isset($_POST['conf_password'])){
    require_once '../../../model/classAuth.php';
    require_once '../../../model/classSMS.php';
    
    $c = new classAuth();
    $sms = new classSMS();
    $id = $session_member_id;
    $password = addslashes(strip_tags($_POST['new_password']));
    
    $result = $c->update_password($id, $password);
    
    if($result == true){
        $sms->smsGantiPassword($id);
        redirect('change_password_successfull');
    }else{
        echo "false";
    }
} else {
    redirect('404');
}