<?php 
$request = $_REQUEST;

require_once '../../helper/all.php';
require_once '../../model/classBonus.php';
$obj = new classBonus();

$admin = $_admin;
$tanggal = date("Y-m-d");

$data = $obj->datatable_laporan($request, $tanggal, $admin);
echo json_encode($data);
return true;
?>