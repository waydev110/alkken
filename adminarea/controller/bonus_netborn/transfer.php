<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusNetborn.php';
$obj = new classBonusNetborn();

$tanggal = date("Y-m-d");

$data = $obj->datatable_transfer($request, $tanggal);
echo json_encode($data);
return true;
?>