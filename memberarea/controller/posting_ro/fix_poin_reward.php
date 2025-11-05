<?php
    require_once '../../../helper/all_member.php';  
    require_once '../../../model/classMember.php';
    require_once '../../../model/classPaket.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusPasangan.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classUndianKupon.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSaldoPenarikan.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cp = new classPaket();
    $cka = new classKodeAktivasi();
    $cks= new classBonusSponsor();
    $cbp= new classBonusPasangan();
    $ckg= new classBonusGenerasi();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cbr= new classBonusReward();
    $cuk= new classUndianKupon();
    $cpl= new classPlan();
    $cswd= new classSaldoPenarikan();
    $cw= new classWallet();
    $sms  = new classSMS();
    
    $tgl_posting_ulang = date('Y-m-d H:i:s');
    $log_file = '../../../log/posting_ulang/log-'.$tgl_posting_ulang.'.txt';
    $log = '';
    // # CEK KODE AKTIVASI
    // $get_kodeaktivasi_ro_fix = $cka->get_kodeaktivasi_ro_fix(15);
    $get_kodeaktivasi_ro_reseller = $cka->get_kodeaktivasi_ro_reseller();
    $log .= "Jumlah PIN yang difixing : ".$get_kodeaktivasi_ro_reseller->num_rows."\n\n";
    // echo $get_kodeaktivasi_ro_reseller->num_rows;
    // return false;
    
    while ($pin = $get_kodeaktivasi_ro_reseller->fetch_object()) {
        $member_id = $pin->member_id;
        $id_kodeaktivasi = $pin->id;
        $kode_aktivasi = $pin->kode_aktivasi;
        $jumlah_hu = $pin->jumlah_hu;
        $poin_reward = $pin->poin_reward;
        $harga = $pin->harga;
        $bonus_sponsor = $pin->bonus_sponsor;   
        $bonus_generasi = $pin->bonus_generasi;
        $bonus_cashback = $pin->bonus_cashback;
        $bonus_sponsor_monoleg = $pin->bonus_sponsor_monoleg;   
        $bonus_poin_cashback = $pin->bonus_poin_cashback;    
        $pasangan = $pin->pasangan;   
        $parent_pasangan = $pin->parent_pasangan;   
        $reward = $pin->reward;   
        $reward_pribadi = $pin->reward_pribadi;   
        $reward_sponsor = $pin->reward_sponsor;   
        $parent_reward = $pin->parent_reward;   
        $parent_reward_sponsor = $pin->parent_reward_sponsor;  
        $fee_founder = $pin->fee_founder;  
        $tingkat = $pin->tingkat;
        $reposisi = $pin->reposisi;
        $founder = $pin->founder;
        $id_plan = $pin->jenis_aktivasi;
        $nama_plan = $pin->nama_plan;
        $wajib_posting = $pin->wajib_posting;
        $jenis_posting = 'posting_ro';
        $saldo_wd = $pin->saldo_wd; 
        $type_saldo_wd = 'posting';
        $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar '.rp($saldo_wd).' dari paket '.$nama_plan;
        $created_at = $pin->tgl_posting;
        
        $log .= "Member ID : ".$member_id."\n";
        $log .= "ID Kodeaktivasi : ".$id_kodeaktivasi."\n";
        $log .= "Nama Paket : ".$nama_plan."\n";
        $log .= "Harga Paket : ".rp($harga)."\n";
        $log .= "Poin Pasangan : ".$jumlah_hu."\n\n";
    
        // if($_binary == true && $poin_reward > 0){
        //     if($reward == '1' || $parent_reward > 0){
        //         $plan_reward = $id_plan;
        //         if($parent_reward > 0){
        //             $plan_reward = $parent_reward;
        //             $parent_plan = $cpl->show($plan_reward);
        //             $wajib_posting = $parent_plan->wajib_posting;
        //         }
        //         $create_poin_reward = $cbr->fix_poin_binary($member_id, $poin_reward, $id_kodeaktivasi, $plan_reward, $wajib_posting, $jenis_posting, $created_at);
        //     }
        // }  
    

        // if($_binary == true && $jumlah_hu > 0){
        //     if($pasangan == '1' || $parent_pasangan > 0){
        //         $plan_pasangan = $id_plan;
        //         if($parent_pasangan > 0){
        //             $plan_pasangan = $parent_pasangan;
        //         }
        //         $update_potensi = $cbp->create_poin($member_id, $jumlah_hu, $id_kodeaktivasi, $plan_pasangan, $jenis_posting, $created_at);
        //     }
        // }
    }
    $log .= "----------------- Selesai\n";
    // file_put_contents($log_file, $log, FILE_APPEND);
