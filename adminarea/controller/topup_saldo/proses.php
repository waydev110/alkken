<?php 

require_once '../../../helper/all.php';
require_once '../../../model/classTopupSaldo.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$obj = new classTopupSaldo();
$cw = new classWallet();
$csms= new classSMS();

$id = base64_decode($_POST['id']);
$updated_at = date('Y-m-d H:i:s');
$update = $obj->update_transfer($id, $updated_at);

if($update > 0){
    $data = $obj->show($id);
    $keterangan = 'Topup Saldo Autosave. ID '.code_topup($data->id);
    $cw->set_id_member($data->id_member);
    $cw->set_jenis_saldo('poin');
    $cw->set_nominal($data->nominal);
    $cw->set_type('tupo_automaintain');
    $cw->set_keterangan($keterangan);
    $cw->set_status('d');
    $cw->set_status_transfer('0');
    $cw->set_dari_member($id);
    $cw->set_id_kodeaktivasi('0');
    $cw->set_dibaca('0');
    $cw->set_created_at($updated_at);

    $create_wallet = $cw->create();
    if($create_wallet){
        echo json_encode(['status' => true, 'message' => 'Diproses']);
        $csms->smsProsesTopup($data->id_member, $data->nominal, $updated_at, $status);
        return false;
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal']);
        return false;
    }
}else{
    echo json_encode(['status' => false, 'message' => 'Gagal']);
    return false;
}
?>