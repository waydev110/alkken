<?php
ob_start();
require_once '../../../helper/all.php';
if(isset($_POST['username'])){
    require_once '../../../model/classStokisMember.php';
    
    $obj = new classStokisMember();
    $usrname = strtolower(addslashes(strip_tags($_POST['username'])));
    $result = $obj->exist($usrname);
    if($result == true){
        echo json_encode(['status' => true]);
    }else{
        echo json_encode(['status' => false]);
    }
} else {
    echo json_encode(['status' => false]);
}