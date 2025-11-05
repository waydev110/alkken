<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBonusSupport.php';
$obj = new classBonusSupport();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>