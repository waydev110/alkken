<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classLaporan.php';
$obj = new classLaporan();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>