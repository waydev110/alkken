<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBank.php';
$obj = new classBank();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>