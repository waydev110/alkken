<?php

require_once '../../../model/classLogin.php';

$obj = new classLogin();

$_username = addslashes(strip_tags($_POST['identity']));
$_password = addslashes(strip_tags($_POST['password']));

$cek = $obj->CekLogin($_username, $_password);

if($cek > 0){
	$login = $obj->LoginSubmit($_username, $_password);
	if($login){
		echo true;
	}else{
		echo false;
	}
}else{
	echo false;
}