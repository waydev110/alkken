<?php

require_once '../../../model/classLoginStokis.php';
    
$obj = new classLoginStokis();

$_username = addslashes(strip_tags($_POST['identity']));
$_password = addslashes(strip_tags($_POST['password']));
$login = $obj->LoginSubmit($_username, $_password);
if($login){
	echo true;
}else{
	echo false;
}