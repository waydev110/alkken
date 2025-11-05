<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisDeposit.php';
$obj = new classStokisDeposit();
$data = $obj->datatable($request, 0);
echo json_encode($data);
return true;
?>