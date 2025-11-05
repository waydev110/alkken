<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classBonusReward.php';
$obj = new classBonusReward();

$data = $obj->datatable($request);
echo json_encode($data);
return true;
?>