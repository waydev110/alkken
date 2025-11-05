<?php 
$request = $_REQUEST;

require_once '../../../helper/string.php';
require_once '../../../model/classUndianPemenang.php';
$obj = new classUndianPemenang();

$id = $_POST['id'];
$updated_at = date('Y-m-d H:i:s');

$query = $obj->update_transfer($id, $updated_at);
if($query){
    echo json_encode(['status' => true, 'message' => 'Diproses']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Pemenang gagal diproses.']);
}
?>