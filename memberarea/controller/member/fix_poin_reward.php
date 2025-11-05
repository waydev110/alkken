<?php
    require_once '../../../helper/all_member.php'; 
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberProspek.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusSponsorMonoleg.php';
    require_once '../../../model/classBonusPasangan.php';
    require_once '../../../model/classBonusPasanganLevel.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classBonusRewardPaket.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka = new classKodeAktivasi();
    $cks= new classBonusSponsor();
    $cksm= new classBonusSponsorMonoleg();
    $cbp= new classBonusPasangan();
    $cbpl= new classBonusPasanganLevel();
    $ckg= new classBonusGenerasi();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cbr= new classBonusReward();
    $cbrs= new classBonusRewardPaket();
    $cw= new classWallet();
    $cpl= new classPlan();
    $sms  = new classSMS();
    
    
    $get_kodeaktivasi_fix = $cka->get_kodeaktivasi_fix();
    echo 'Jumlah PIN : '.$get_kodeaktivasi_fix->num_rows;
    if($get_kodeaktivasi_fix->num_rows == 0){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. PIN tidak ditemukan.']);
        return false;
    }
    
    while($pin = $get_kodeaktivasi_fix->fetch_object()){
        $member_id = $pin->member_id;

        $id_kodeaktivasi = $pin->id;
        $kode_aktivasi = $pin->kode_aktivasi;
        $current_kode_aktivasi = $kode_aktivasi;
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
        $pasangan_level = $pin->pasangan_level;   
        $parent_pasangan_level = $pin->parent_pasangan_level;   
        $reward = $pin->reward;   
        $reward_sponsor = $pin->reward_sponsor;   
        $parent_reward = $pin->parent_reward;   
        $parent_reward_sponsor = $pin->parent_reward_sponsor; 
        $id_produk_jenis = $pin->jenis_produk;
        $promo_reward_sponsor = $pin->promo_reward_sponsor;   
        $poin_reward_promo = $pin->poin_reward_promo;
        $fee_founder = $pin->fee_founder;  
        $tingkat = $pin->tingkat;
        $reposisi = $pin->reposisi;
        $founder = $pin->founder;
        $id_plan = $pin->jenis_aktivasi;
        $nama_plan = $pin->nama_plan;
        $nama_plan_produk = $pin->nama_plan.' '.$pin->name;
        $reward_wajib_ro = $pin->reward_wajib_ro;
        $jenis_posting = 'posting';
        $id_paket = 1;
        $id_peringkat = 0;
        $created_at = $pin->tgl_posting;
        
        echo '<br><br>';
        echo 'Binary : '.$_binary.'<br>';
        echo 'Reward : '.$reward.'<br>';
        echo 'Poin Reward : '.$poin_reward.'<br>';
        echo 'Jumlah HU : '.$jumlah_hu.'<br>';
        echo 'ID Plan : '.$id_plan.'<br>';
        echo 'Parent Reward : '.$parent_reward.'<br>';
        echo 'Parent Pasangan : '.$parent_pasangan.'<br>';
        
        if($_binary == true && $jumlah_hu > 0){
            if($pasangan == '1' || $parent_pasangan > 0){
                $plan_pasangan = $id_plan;
                if($parent_pasangan > 0){
                    $plan_pasangan = $parent_pasangan;
                }
                $create_potensi = $cbp->create_poin($member_id, $jumlah_hu, $id_kodeaktivasi, $plan_pasangan, $jenis_posting, $created_at);
            }
        }
        
        if($_binary == true && $reposisi == '0'){
            if($pasangan_level == '1' || $parent_pasangan_level > 0){
                $plan_pasangan_level = $id_plan;
                if($parent_pasangan_level > 0){
                    $plan_pasangan_level = $parent_pasangan_level;
                }
                $create_potensi = $cbpl->create_poin($member_id, 1, $id_kodeaktivasi, $plan_pasangan_level, $jenis_posting, $created_at);
            }
        }
        
        if($_binary == true && $poin_reward > 0){
            if($reward == '1' || $parent_reward > 0){
                $plan_reward = $id_plan;
                if($parent_reward > 0){
                    $plan_reward = $parent_reward;
                    $parent_plan = $cpl->show($plan_reward);
                    $reward_wajib_ro = $parent_plan->reward_wajib_ro;
                }
                $create_poin_reward = $cbr->create_poin_binary($member_id, $poin_reward, $id_kodeaktivasi, $plan_reward, $reward_wajib_ro, $jenis_posting, $created_at);
            }
        }
        if($poin_reward_promo > 0){             
            $create_poin_reward_sponsor = $cbrs->create_poin($sponsor_id, $poin_reward_promo, $id_kodeaktivasi, $id_produk_jenis, $jenis_posting, $created_at);
        }
        
        if($_binary == true){
            $update_jumlah_kaki = $cm->update_jumlah_kaki($member_id, $id_plan);
        }
            
        if($fee_founder > 0 && $harga > 0){
            $founder = $cbf->index();
            while ($row = $founder->fetch_object()) {
                $keterangan = 'Fee '.$row->name.' Paket '.$nama_plan_produk;
                $id_founder = $row->id;
                $nominal_bonus = floor($fee_founder * $row->persentase_bonus/100);
                $create_bonus_founder = $cbf->create_binary($member_id, $id_member, $user_member, $id_founder, $nominal_bonus, $id_plan, $keterangan, $id_kodeaktivasi, $created_at);	
            }
        }

        if($bonus_generasi > 0){
            $jenis_bonus = $id_plan;
            $max = $ckg->max_generasi($id_plan);
            $keterangan = 'Paket '.$nama_plan_produk.' ('.rp($harga).')';
            $create_bonus_generasi = $ckg->create($member_id, $id_member, $user_member, $bonus_generasi, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at);	
            if(!$create_bonus_generasi){
                return false;
            }
        }

        if($bonus_upline > 0){
            $jenis_bonus = $id_plan;
            $max = $cku->max_generasi($id_plan);
            $keterangan = 'Paket '.$nama_plan_produk.' ('.rp($harga).')';
            $create_bonus_upline = $cku->create($member_id, $id_member, $user_member, $bonus_upline, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at);	
        }

        if($saldo_wd > 0){     
            $jenis_saldo_wd = $id_plan == 200 ? 'cash' : 'saldo_wd';   
            $cswd->id_member = $member_id;
            $cswd->jenis_saldo = $jenis_saldo_wd;
            $cswd->nominal = $saldo_wd;
            $cswd->type = $type_saldo_wd;
            $cswd->keterangan = $keterangan_saldo_wd;
            $cswd->status = 'd';
            $cswd->id_kodeaktivasi = $id_kodeaktivasi;
            $cswd->created_at = $created_at;
    
            $create_saldo_wd = $cswd->create();
        }
    }
    echo 'Selesai';
