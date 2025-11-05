<?php 
$request = $_REQUEST;

require_once '../../../helper/all.php';
require_once '../../../model/classBonusReward.php';
require_once '../../../model/classWallet.php';
require_once '../../../model/classSMS.php';
$obj = new classBonusReward();
$cw = new classWallet();
$csms = new classSMS();

$id = $_POST['id'];
$id_member = $_POST['id_member'];
$tanggal = $_POST['tanggal'];
$nominal_bonus = $_POST['nominal_bonus'];
$jenis = $_POST['jenis'];
$reward = $_POST['reward'];
$updated_at = date('Y-m-d H:i:s');

$query = $obj->update_transfer($id, $id_member, $tanggal, $updated_at);
if($query){
    if($jenis == '1'){
          
        $keterangan = 'Autosave dari Bonus Reward';    
        $cw->set_id_member($id_member);
        $cw->set_jenis_saldo('poin');
        $cw->set_nominal($nominal_bonus);
        $cw->set_type('bonus_reward');
        $cw->set_keterangan($keterangan);
        $cw->set_status('d');
        $cw->set_status_transfer('0');
        $cw->set_dari_member($id_member);
        $cw->set_id_kodeaktivasi('0');
        $cw->set_dibaca('0');
        $cw->set_created_at($updated_at);                 
        $create = $cw->create();
        $csms->smsRewardPoin($id_member, 'Bonus Reward', $nominal_bonus, $updated_at);
    }
    echo json_encode(['status' => true, 'message' => 'Diapprove']);
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Bonus gagal Diapprove.']);
}
?>