<?php 

require_once '../../../model/classMemberOrder.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$csms= new classSMS();
$obj = new classMemberOrder();
$cw = new classWallet();

$id = addslashes(strip_tags($_POST['id']));

$updated_at = date('Y-m-d H:i:s',time());

$obj->set_status('2');
$obj->set_updated_at($updated_at);
$update = $obj->update_status($id);

if($update){
    $cw->set_deleted_at($updated_at);
    $delete_wallet = $cw->delete_wallet($id);
    if($delete_wallet){
        echo "ok";
    } else {
        $obj->set_status('0');
        $update = $obj->update_status($id);
        echo "false";
    }
}else{
	echo "false";
}
?>