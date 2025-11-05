<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBonusPasanganLevel.php';
$obj = new classBonusPasanganLevel();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>