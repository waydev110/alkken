<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusRoAktif.php';
$obj = new classBonusRoAktif();

$admin = 5;
$tanggal = date("Y-m-d");

$data = $obj->datatable_laporan($request, $tanggal, $admin);
echo json_encode($data);
return true;
?>