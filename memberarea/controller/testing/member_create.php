<?php
    require_once '../../../helper/all_member.php';  

    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberProspek.php';
    require_once '../../../model/classPaket.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cp = new classPaket();
    $cka = new classKodeAktivasi();
    $cks= new classBonusSponsor();
    $ckg= new classBonusGenerasi();
    $sms  = new classSMS();
    
    $created_at = date('Y-m-d H:i:s');
    // $cm->create_poin(4, 2, 3, $created_at);
    // $max = 20;
    // $insert = 4;
    // $bonus_generasi = 20000;
    // $id_kodeaktivasi = 3;
    // $create_bonus_generasi = $ckg->create($insert, $bonus_generasi, $id_kodeaktivasi, $max, $created_at);	
    
    $persentase_bonus_sponsor = $cks->persentase_bonus_sponsor(11);
    if($persentase_bonus_sponsor){
        echo $persentase_bonus_sponsor;
    } else {
        echo 'test';
    }
    // $type = 'posting';
    // $cm->restore_poin(15, $type);
    // $cm->restore_peringkat(15, $type);
    // $ckg->create(31, 30000, 15, 20, $created_at);