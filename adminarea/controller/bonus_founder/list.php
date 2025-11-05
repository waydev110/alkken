<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBonusFounder.php';
$obj = new classBonusFounder();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>