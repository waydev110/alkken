<?php 
	require_once '../../../model/classSMS.php';
	$csms = new classSMS();
	$id_member = addslashes(strip_tags($_POST['id']));
	$csms->smsDataLogin($id_member);
	echo "success";
?>