<?php
require_once '../../../helper/all_member.php';

if(isset($_POST['wa'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $hp_member = addslashes(strip_tags($_POST['wa']));
    
    $result = $cm->cek_wa($hp_member);
    
    if($result <= 1){
        echo 'true';
    }else{
        echo 'false';
    }
} else {
    echo 'false';
}