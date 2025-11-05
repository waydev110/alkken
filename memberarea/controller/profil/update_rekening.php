<?php
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    require_once '../../../model/classMember.php';
    
    $c = new classMember();

    $id = $session_member_id;
    $id_bank = addslashes(strip_tags($_POST['bank']));
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    $atas_nama_rekening = addslashes(strip_tags($_POST['atas_nama_rekening']));
    $cabang_rekening = addslashes(strip_tags($_POST['cabang_rekening']));
    
    $c->set_id_bank($id_bank);
    $c->set_no_rekening($no_rekening);
    $c->set_atas_nama_rekening($atas_nama_rekening);
    $c->set_cabang_rekening($cabang_rekening);

    $result = $c->update($id);
    
    if($result == true){
        echo true;
    }else{
        echo "false";
    }
} else {
    echo "exfired";
}