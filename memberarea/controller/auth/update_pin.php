<?php
ob_start();
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    if(isset($_POST['new_pin'])){
        require_once '../../../model/classAuth.php';
        require_once '../../../model/classSMS.php';
        
        $c = new classAuth();
        $sms = new classSMS();
        $id = $session_member_id;
        $pin = $_POST['new_pin'];
        
        $result = $c->update_pin($id, $pin);
        
        if($result == true){
            $sms->smsGantiPIN($id);
            redirect('change_pin_successfull');
        }else{
            echo "false";
        }
    } else {
        redirect('404');
    }
} else {    
    redirect('home');
}