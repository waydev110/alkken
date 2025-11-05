<?php 

require_once '../../../model/classMemberOrder.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classMemberOrder();

$id = addslashes(strip_tags($_POST['id']));

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('4');
$obj->set_updated_at($updated_at);
$update = $obj->update_status($id, $session_stokis_id);

if(!$update){
    echo json_encode(['status' => false]);
    return false;
}
echo json_encode(['status' => true]);
return true;
?>