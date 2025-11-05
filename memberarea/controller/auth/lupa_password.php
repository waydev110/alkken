<?php

// require_once '../auth/recaptcha.php';
if(isset($_POST['id_member']) && addslashes(strip_tags($_POST['id_member'])) <> ''){
    require_once '../../../model/classAuth.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $csms = new classSMS();
    $id_member = addslashes(strip_tags($_POST['id_member']));

    $member = $cm->show_id_by_user_and_id($id_member);
    if($member){
    
        $result = $csms->smsLupaPassword($member->id);
        if($result){
            echo true;
        }else{
            echo "Permintaan lupa password gagal.";
        }

    } else {
        echo "Permintaan lupa password gagal.";
    }
} else {
    echo "Permintaan lupa password gagal.";
}