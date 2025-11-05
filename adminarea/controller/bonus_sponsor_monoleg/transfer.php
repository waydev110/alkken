<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusSponsorMonoleg.php';
$obj = new classBonusSponsorMonoleg();

$admin = $_admin;
$tanggal = date("Y-m-d");

$data = $obj->datatable_transfer($request, $tanggal, $admin);
echo json_encode($data);
return true;
?>