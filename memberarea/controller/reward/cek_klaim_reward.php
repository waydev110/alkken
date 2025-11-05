<?php
if(isset($_POST['idreward'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classMember.php';
    require_once '../../../model/classBonusRewardSetting.php';
    require_once '../../../model/classBonusReward.php';
    $cm = new classMember();
    $cbro = new classBonusRewardSetting();
    $cbns = new classBonusReward();
    
    $id_member = $session_member_id;
    $idreward = addslashes(strip_tags($_POST['idreward']));

    $bonus_reward = $cbns->bonus_reward($id_member, $idreward);
    if($bonus_reward){
        if($bonus_reward->status_transfer == '1'){
            echo json_encode(['status' => false, 'message' => 'Bonus sudah di transfer.']);
            return false;
        } else {
            echo json_encode(['status' => false, 'message' => 'Bonus sudah di klaim.']);
            return false;
        }
    }

    $result = $cbro->show($idreward);
    if($result->jenis == '0'){
        $nominal = rp($result->nominal);
    } else {
        $nominal = poin($result->nominal);
    }
    
    if($result){
        $html ='<div class="row py-3">
                    <h5 class="text-center mt-2 mb-2">REWARD</h5>
                    <div class="col align-self-center">
                        <h3 class="text-center text-danger">'.$result->reward.'</h3>
                    </div>
                    <h5 class="text-center mt-2 mb-2">SENILAI</h5>
                    <div class="col align-self-center">
                        <h3 class="text-center text-danger">'.$nominal.'</h3>
                    </div>
                </div>';
        echo json_encode(['status' => true, 'html' => $html]);
    } else {
        echo json_encode(['status' => false]);
    }
}