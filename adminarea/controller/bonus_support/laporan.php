<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusSupport.php';
$obj = new classBonusSupport();

$admin = $_admin;
$admin = 0;
$tanggal = date("Y-m-d");

$data = $obj->datatable_laporan($request, $tanggal, $admin);
echo json_encode($data);
return true;
?>