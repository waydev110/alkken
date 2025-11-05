<?php
    require_once '../../../model/classBonusReward.php';

    $obj = new classBonusReward();
    
    if(isset($_POST['id_plan']) && isset($_POST['jenis_reward'])){
        $id_plan = addslashes(strip_tags($_POST['id_plan']));
        $jenis_reward = addslashes(strip_tags($_POST['jenis_reward']));
        $created_at = date('Y-m-d H:i:s');
        if($jenis_reward == 'reward'){
            $query = $obj->reset_poin($id_plan, $created_at);
        } else if($jenis_reward == 'reward_pribadi'){
            $query = $obj->reset_poin_pribadi($id_plan, $created_at);
        } else {
            $query = false;
        }
        if($query){
            echo json_encode(['status' => true, 'message' => 'Berhasil direset.']);
            return true;
        }
    }
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal direset.']);
    return true;
        