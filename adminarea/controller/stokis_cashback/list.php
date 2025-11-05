<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classStokisCashback.php';
$obj = new classStokisCashback();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>