<?php 
$request = $_REQUEST;

require_once '../../helper/all.php';
require_once '../../model/classBonus.php';
$obj = new classBonus();

$admin = $_admin;
$_limit_transfer = $_limit_transfer;
$tanggal = date("Y-m-d");

$data = $obj->datatable_transfer($request, $tanggal, $_limit_transfer, $admin);
echo json_encode($data);
return true;
?>