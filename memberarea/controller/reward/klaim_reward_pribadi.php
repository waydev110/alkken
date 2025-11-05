<?php
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classMember.php';
    require_once '../../../model/classBonusRewardPaketSetting.php';
    require_once '../../../model/classBonusRewardPaket.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cbro = new classBonusRewardPaketSetting();
    $obj = new classBonusRewardPaket();
    $sms  = new classSMS();
    
    $id_member = $session_member_id;
    $idreward = addslashes(strip_tags($_POST['idreward']));

    $bonus_reward = $obj->bonus_reward($id_member, $idreward);
    if($bonus_reward){
        if($bonus_reward->status_transfer == '1'){
            echo json_encode(['status' => false, 'message' => 'Bonus sudah di transfer.']);
            return false;
        } else {
            echo json_encode(['status' => false, 'message' => 'Bonus sudah di klaim.']);
            return false;
        }
    }
    
    $set_bonus = $cbro->show($idreward);
    $poin_reward = $obj->jumlah_poin_reward_pribadi($session_member_id, $set_bonus->id_produk_jenis);

    if(!$set_bonus){
        echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan.']);
        return false;
    }

    if($poin_reward < $set_bonus->poin){
        echo json_encode(['status' => false, 'message' => 'Poin tidak cukup. Tidak dapat klaim reward.', 'poin_reward' => $poin_reward->poin_reward, 'poin_bonus' => $set_bonus->poin]);
        return false;
    }
    if($set_bonus->jenis == '0'){
        $nominal = rp($set_bonus->nominal);
    } else {
        $nominal = poin($set_bonus->nominal);
    }

    $reward = $set_bonus->reward;
    $keterangan = 'Klaim Reward '.$set_bonus->nama_reward_sponsor;
    try {
        $created_at = date('Y-m-d H:i:s');
        $obj->id_member = $session_member_id;
        $obj->nominal = $set_bonus->nominal;
        $obj->reward = $reward;
        $obj->poin = $set_bonus->poin;
        $obj->status_transfer = 0;     
        $obj->keterangan = $keterangan;   
        $obj->id_bonus_reward_setting = $idreward;  
        $obj->created_at = $created_at;     
        $obj->create();
    } catch (\Exception $e) {        
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $sms->smsKlaimReward($id_member, $set_bonus->nominal, $keterangan, $created_at);
    echo json_encode(['status' => true, 'message' => 'Klaim Reward '.$set_bonus->nama_reward_sponsor.' berhasil.']);
    return true;