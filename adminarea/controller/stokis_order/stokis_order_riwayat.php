<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisOrder.php';
$obj = new classStokisOrder();
$status_bayar = 1;
$status = 1;
$status_kirim = 1;
$data = $obj->datatable_riwayat($request, $status_bayar, $status, $status_kirim);
echo json_encode($data);
return true;
?>