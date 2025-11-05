<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classKodeAktivasi.php';
$obj = new classKodeAktivasi();

$data = $obj->datatable_history($request);
echo json_encode($data);
return true;
?>