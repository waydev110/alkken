<?php 
session_start();
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisTransfer.php';
$obj = new classStokisTransfer();

$session_stokis_id = $_SESSION['session_stokis_id'];
$data = $obj->datatable_terima($session_stokis_id, $request);
echo json_encode($data);
return true;
?>