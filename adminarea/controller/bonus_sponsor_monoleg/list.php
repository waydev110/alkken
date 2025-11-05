<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBonusSponsor.php';
$obj = new classBonusSponsor();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>