<?php 
require_once '../../../model/classMember.php';
require_once '../../../model/classSMS.php';

$cm = new classMember();
$csms= new classSMS();

echo "success";
$id_member = addslashes(strip_tags($_POST['id']));
$csms->smsBirthDay($id_member);
?>