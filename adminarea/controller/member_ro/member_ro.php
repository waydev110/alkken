<?php 
    $request = $_REQUEST;
    require_once '../../../helper/all.php';
    require_once '../../../model/classMemberRO.php';
    $obj = new classMemberRO();
    $data = $obj->datatable($request);
    echo $data;
?>