<?php
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classMember.php';
    require_once '../../../model/classBonusRewardSetting.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cbro = new classBonusRewardSetting();
    $obj = new classBonusReward();
    $sms  = new classSMS();
    
    $member_id = $session_member_id;
    $member = $cm->detail($member_id);
    $id_member = $member->id_member;
    $nama_samaran = $member->nama_samaran;
    $user_member = $member->user_member;
    $sponsor_id = $member->sponsor;
    $sponsor = $cm->detail($sponsor_id);
    $sponsor_peringkat = $sponsor->id_peringkat;
    $idreward = addslashes(strip_tags($_POST['idreward']));


    $bonus_reward = $obj->bonus_reward($member_id, $idreward);
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
    $poin_reward = $cm->jumlah_poin_reward($member_id, $set_bonus->id_plan);

    if(!$set_bonus){
        echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan.']);
        return false;
    }

    if($poin_reward->reward_kiri < $set_bonus->poin || $poin_reward->reward_kanan < $set_bonus->poin){
        echo json_encode(['status' => false, 'message' => 'Poin tidak cukup. Tidak dapat klaim reward.']);
        return false;
    }
    if($set_bonus->jenis == '0'){
        $nominal = rp($set_bonus->nominal);
    } else {
        $nominal = poin($set_bonus->nominal);
    }
    $keterangan = 'Klaim Reward '.$set_bonus->nama_plan;
    $nominal = $set_bonus->nominal;
    $reward = $set_bonus->reward;
    $poin = $set_bonus->poin;
    $id_bonus_reward_setting = $set_bonus->id;
    try {
        $created_at = date('Y-m-d H:i:s');
        $obj->set_id_member($member_id);
        $obj->set_nominal($nominal);
        $obj->set_reward($reward);
        $obj->set_poin($poin);
        $obj->set_id_bonus_reward_setting($id_bonus_reward_setting);
        $obj->set_status_transfer('0');
        $obj->set_keterangan($keterangan);   
        $obj->set_created_at($created_at);        

        $create = $obj->create();
        if($create){        
            if($set_bonus->id_plan == 4){
                $cm->update_peringkat($member_id, '0', $member->id_peringkat, $set_bonus->id, $created_at);
            }
            $sms->smsKlaimReward($member_id, $nominal, $keterangan, $created_at);   
            
        }
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    echo json_encode(['status' => true, 'message' => 'Klaim Reward berhasil.']);
    return true;