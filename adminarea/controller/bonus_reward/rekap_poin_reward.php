<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusReward.php';
    
    $cka = new classKodeAktivasi();
    $cbr = new classBonusReward();
    
    $bulan = date('Y-m', strtotime('-1 month'));
    // $bulan = date('Y-m');
    $id_plan = 14;
    $plan_reward = 4;
    $kode_aktivasi = $cka->get_aktivasi_ro_aktif_reward($bulan, $id_plan);
    $reward_wajib_ro = 1;
    $jenis_posting = 'rekap_bulanan';
    $created_at = date('Y-m-01');
    while($row = $kode_aktivasi->fetch_object()){
        $id_kodeaktivasi = $row->id;
        $member_id = $row->member_id;
        $poin_reward = $row->poin_reward;
        $reward = $row->reward;
        $parent_reward = $row->parent_reward;
        echo 'ID Kodeaktivasi : '.$id_kodekativasi;
        echo '<br>';
        echo 'Member ID : '.$member_id;
        echo '<br>';
        echo 'Poin Reward : '.$poin_reward;
        echo '<br>';
        // echo 'Reward : '.$row->reward;
        // echo '<br>';
        // echo 'Parent Reward : '.$row->parent_reward;
        // echo '<br>';
        // echo '<br>';
        $cbr->rekap_reward_ro_aktif($member_id, $poin_reward, $id_kodeaktivasi, $id_plan, $plan_reward, $reward_wajib_ro, $jenis_posting, $bulan, $created_at);
    }
    echo 'Rekap Selesai';