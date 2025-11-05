<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}
    include('../../../helper/all_member.php');
    include("../../../model/classSpinReward.php");  
    include("../../../model/classWallet.php");
	include("../../../model/classWithdraw.php");
    $csr = new classSpinReward();
    $cw = new classWallet();
    $cwd  = new classWithdraw();
    $rewards = $csr->getRewards();
    
    $saldo_reward = $cw->saldo($session_member_id, 'reward');

    if($saldo_reward < $_harga_spin){
        echo json_encode(['error' => 'Saldo reward tidak cukup.']);
        exit;
    }

    if (!$rewards || count($rewards) === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'No reward available']);
        exit;
    }
    $totalChance = array_sum(array_column($rewards, 'persentase_peluang'));
    $rand = mt_rand(1, 10000) / 100;

    $accumulated = 0;
    $selectedReward = null;

    foreach ($rewards as $reward) {
        $accumulated += $reward['persentase_peluang'];
        if ($rand <= $accumulated) {
            $idReward = $reward['id'];
            $selectedReward = $reward['id']-1;
            break;
        }
    }

    if (!$selectedReward) {
        $idReward = 1;
        $selectedReward = 0;
    }

    $rewardData = $csr->show($idReward);
    if (!$rewardData) {
        http_response_code(404);
        echo json_encode(['error' => 'Reward not found']);
        exit;
    }

    $id_member = $session_member_id;
    $jenis_saldo = 'reward';
    $nominal = $rewardData->nominal;
    $type_reward = $nominal > 0 ? 'cash' : 'barang';
    $status_transfer = $nominal > 0 ? '1' : '0';
    $type = 'spin_reward';
    $status = 'k';
    $id_kodeaktivasi = null;
    $keterangan1 = 'Spin Reward: ' . currency($_harga_spin);
    $keterangan2 = 'Spin Reward: ' . $rewardData->reward;
    $created_at = date('Y-m-d H:i:s');

    $csr->id_member = $id_member;
    $csr->id_spin_reward = $rewardData->id;
    $csr->nama_reward = $rewardData->reward;
    $csr->harga_spin = $_harga_spin;
    $csr->type = $type_reward;
    $csr->status_transfer = $status_transfer;
    $csr->created_at = $created_at;
    $create_pemenang = $csr->create();

    if(!$create_pemenang){
        http_response_code(404);
        echo json_encode(['error' => 'Reward not found']);
        exit;
    }

    $wallet_keluar = $cw->create_wallet($id_member, $jenis_saldo, $_harga_spin, $type, $status, $id_kodeaktivasi, $keterangan1, $created_at);

    if($nominal > 0 && $wallet_keluar) {
        $jenis_saldo = 'cash';
        $status = 'd';
        $cw->create_wallet($id_member, $jenis_saldo, $nominal, $type, $status, $id_kodeaktivasi, $keterangan2, $created_at);
    }

    $percent_admin = 10;

    $admin = floor($nominal*$percent_admin/100);
    $total = $nominal - $admin;

    $cw->set_id_member($id_member);     
    $cw->set_jenis_saldo('cash');  
    $cw->set_nominal($nominal);
    $cw->set_type('penarikan');
    $cw->set_status('k');
    $cw->set_dari_member($id_member);
    $cw->set_keterangan('Penarikan');
    $cw->set_created_at($created_at);

    $insert_wallet = $cw->create();

    if($insert_wallet){
        
        $cwd->set_id_member($id_member);
        $cwd->set_jenis_saldo('cash');  
        $cwd->set_jenis_penarikan('bank');  
        $cwd->set_jumlah($nominal);  
        $cwd->set_admin($admin);  
        $cwd->set_total($total);  
        $cwd->set_status_transfer('0');
        $cwd->set_id_wallet($insert_wallet);
        $cwd->set_created_at($created_at);

        $create_penarikan = $cwd->create();
        if(!$create_penarikan){
            $cw->delete($insert_wallet);
            echo json_encode(['status' => false, 'message' => 'Permintaan Penarikan Gagal.']);
            return false;
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Permintaan Penarikan Gagal.']);
        return false;
    }


    echo json_encode([
        'status' => true,
        'index' => $selectedReward,
        'harga_spin' => $_harga_spin,
        'saldo_reward' => $saldo_reward-$_harga_spin
    ]);
