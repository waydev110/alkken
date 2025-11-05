<?php 
session_start();
$session_stokis_id = $_SESSION['session_stokis_id'];
require_once '../../../helper/all.php';
require_once '../../../model/classMemberOrder.php';

$obj = new classMemberOrder();

$id = addslashes(strip_tags($_POST['id']));
$data = $obj->show_stokis($id, $session_stokis_id);

if(!$data){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}
echo json_encode(['status' => true, 'data' => $data]);
return false;
?>