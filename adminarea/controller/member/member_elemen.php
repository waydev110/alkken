<?php 
$request = $_REQUEST;
require_once '../../../helper/string.php';
require_once '../../../model/classMember.php';
$obj = new classMember();
$data = $obj->datatable_elemen($request);
echo $data;
?>