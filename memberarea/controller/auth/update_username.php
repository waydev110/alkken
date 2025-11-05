<?php
ob_start();
require_once '../../../helper/all_member.php';

if(isset($_POST['username'])){
    require_once '../../../model/classAuth.php';
    require_once '../../../model/classSMS.php';
    
    $c = new classAuth();
    $sms = new classSMS();
    $id = $session_member_id;
    $username = addslashes(strip_tags($_POST['username']));
    
    $result = $c->update_username($id, $username);
    
    if($result == true){
        $_SESSION['session_user_member'] = $username;
        $sms->smsGantiPassword($id);
        echo json_encode(['status' => true, 'message' => 'Username berhasil diubah. Silahkan cek perubahan di halaman profil.']);
        return true;
    }else{
        echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan.']);
        return false;
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan.']);
    return false;
}