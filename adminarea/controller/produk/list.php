<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classProduk.php';
$obj = new classProduk();
$data = $obj->datatable($request);
echo $data;
?>