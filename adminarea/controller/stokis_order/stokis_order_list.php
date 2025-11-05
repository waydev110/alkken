<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisOrder.php';
$obj = new classStokisOrder();
$status_bayar = 0;
$status = 0;
$status_kirim = 0;
$data = $obj->datatable($request, $status_bayar, $status, $status_kirim);
echo json_encode($data);
return true;
?>