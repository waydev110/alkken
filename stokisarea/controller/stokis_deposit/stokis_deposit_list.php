<?php 
session_start();
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisDeposit.php';
$obj = new classStokisDeposit();

$session_stokis_id = $_SESSION['session_stokis_id'];
$data = $obj->datatable_riwayat_stokis($session_stokis_id, $request);
echo json_encode($data);
return true;
?>