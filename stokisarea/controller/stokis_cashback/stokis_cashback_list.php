<?php 
session_start();
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classStokisCashback.php';
$obj = new classStokisCashback();

$session_stokis_id = $_SESSION['session_stokis_id'];
$data = $obj->datatable($session_stokis_id, $request);
echo json_encode($data);
return true;
?>