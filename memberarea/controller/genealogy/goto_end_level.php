<?php
require_once '../../../helper/all_member.php';
if(isset($_POST['id_member'])){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    $id_member = base64_decode($_POST['id_member']);
    $member = $cm->downline($id_member);
    
    if($member == true){
        echo site_url('genealogy&id='.base64_encode($member->id));
    } else {
        echo 'false';
    }
} else {
    echo 'false';
}