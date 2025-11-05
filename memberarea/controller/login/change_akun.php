<?php
session_start();
if(isset($_POST['id_member'])){
	require_once '../../../model/classLoginMember.php';

	$obj = new classLoginMember();

	$id_member = addslashes(strip_tags($_POST['id_member']));

	$cek = $obj->CekAkun($id_member, $_SESSION['session_group_akun']);
	$id_member = $cek->id_member;
	$_password = $cek->pass_member;

	if($cek){
		$login = $obj->LoginSubmit($id_member, base64_decode($_password), true);
		if($login){
            echo json_encode(['status' => true]);
            return true;
		} else {
            echo json_encode(['status' => $_SESSION['session_id_member']]);
            return false;
        }
	}else{
        echo json_encode(['status' => false]);
        return false;
	}	
}else{
    echo json_encode(['status' => false]);
    return false;
}
