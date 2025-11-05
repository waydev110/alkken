<?php
session_start();
require_once '../../../model/classLogin.php';

$obj = new classLogin();

$_username = addslashes(strip_tags($_POST['var_usn']));
$_password = addslashes(strip_tags($_POST['var_pwd']));

$cek = $obj->CekLogin($_username, $_password);

if($cek > 0){
	$login = $obj->LoginSubmit($_username, $_password);
	if($login == 'true'){
		echo true;
	}else if($login == 'blokir'){
		echo "Maaf. Akun anda diblokir.";
	} else {
		echo "Login gagal. Kombinasi username dan password salah.";
    }
}else{
	echo "Anda tidak mempunyai akses.";
}