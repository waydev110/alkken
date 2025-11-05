<?php 
$request = $_REQUEST;
require_once '../../../helper/all.php';
require_once '../../../model/classStokisDeposit.php';
$obj = new classStokisDeposit();
$data = $obj->datatable_riwayat($request);
echo json_encode($data);
return true;
?>