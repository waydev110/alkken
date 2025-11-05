<?php 
$request = $_REQUEST;
include('../../../helper/string.php');
include('../../../model/classMember.php');
$obj = new classMember();
$data = $obj->datatable_download($request);
echo $data;
?>