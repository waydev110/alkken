<?php 

require_once '../../../helper/all.php';
require_once '../../../model/classMemberReedem.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';

$csms= new classSMS();
$obj = new classMemberReedem();
$cw = new classWallet();

$id = addslashes(strip_tags($_POST['id']));
$data = $obj->show($id);

if(empty($data)){
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}
echo json_encode(['status' => true, 'data' => $data]);
return false;
?>