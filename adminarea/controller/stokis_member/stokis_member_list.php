<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisMember.php';
$obj = new classStokisMember();
$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>