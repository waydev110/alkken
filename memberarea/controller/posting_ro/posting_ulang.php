<?php
    require_once '../../../helper/all.php';  
    require_once '../../../model/classMember.php';
    require_once '../../../model/classPaket.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusPasangan.php';
    require_once '../../../model/classBonusPasanganLevel.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusUpline.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classBonusRewardPaket.php';
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
    $cbpl= new classBonusPasanganLevel();
    $ckg= new classBonusGenerasi();
    $cku= new classBonusUpline();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cbr= new classBonusReward();
    $cbrs= new classBonusRewardPaket();
    $cuk= new classUndianKupon();
    $cswd= new classSaldoPenarikan();
    $cpl= new classPlan();
    $cw= new classWallet();
    $sms  = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }
    
    # CEK PARAMETER POST
    if(!isset($_GET['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Kode Aktivasi tidak ditemukan.']);
        return false;
    }

    $id_kodeaktivasi = addslashes(strip_tags($_GET['id_kodeaktivasi']));
    
    # CEK KODE AKTIVASI
    $pin = $cka->get_kodeaktivasi_fixing($id_kodeaktivasi);
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Kode aktivasi tidak ditemukan.']);
        return false;
    }
    $member_id = $pin->member_id;
    
    $member = $cm->detail($member_id);
    $sponsor_id = $member->sponsor;
    $id_member = addslashes(strip_tags($member->id_member));
    $user_member = $member->user_member;
    $member_plan = $member->id_plan;
    $id_paket = $member->id_paket;
    $user_member = addslashes(strip_tags($member->user_member));
    
    $id_kodeaktivasi = $pin->id;
    $kode_aktivasi = $pin->kode_aktivasi;
    $current_kode_aktivasi = $kode_aktivasi;
    $jumlah_hu = $pin->jumlah_hu;
    $poin_reward = $pin->poin_reward;
    $harga = $pin->harga;
    $bonus_sponsor = $pin->bonus_sponsor;  
    $bonus_generasi = $pin->bonus_generasi;
    $bonus_upline = $pin->bonus_upline;
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
    // $fee_founder = $pin->fee_founder;  
    $tingkat = $pin->tingkat;
    $reposisi = $pin->reposisi;
    $founder = $pin->founder;
    $id_plan = $pin->jenis_aktivasi;
    $nama_plan = $pin->nama_plan;
    $nama_plan_produk = $pin->nama_plan.' '.$pin->name;
    $reward_wajib_ro = $pin->reward_wajib_ro;
    $jenis_posting = 'posting_ro';
    $saldo_wd = $pin->saldo_wd; 
    $type_saldo_wd = 'posting';
    $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar '.rp($saldo_wd).' dari paket '.$nama_plan;
    $created_at = date('Y-m-d H:i:s');


    $create_history = $cka->create_history($id_kodeaktivasi, $member_id, $id_plan, $created_at);    
    if($bonus_sponsor > 0 && $sponsor_id <> 'master'){
        $cek_bonus_sponsor = $cks->cek_bonus($sponsor_id, $id_kodeaktivasi, $id_plan);
        if($cek_bonus_sponsor == 0){
            if($id_plan == 14) {
                $status_transfer = -1;
            } else {
                $status_transfer = 0;
            }
            $keterangan = 'Bonus '.$lang['sponsor'].' dari ( ID: '.$id_member.' / '.$user_member.' ) paket '.$nama_plan_produk.' ('.rp($harga).')';
            $cks->set_id_member($sponsor_id);
            $cks->set_nominal($bonus_sponsor);
            $cks->set_status_transfer($status_transfer);
            $cks->set_dari_member($member_id);
            $cks->set_id_kodeaktivasi($id_kodeaktivasi);
            $cks->set_jenis_bonus($id_plan);
            $cks->set_keterangan($keterangan);  
            $cks->set_created_at($created_at);                
            $create_komisi_sponsor = $cks->create_ulang();
            if($create_komisi_sponsor){
                $sms->smsBonusNew($sponsor_id, $bonus_sponsor, $keterangan, $created_at);
            }
        }
    }
    
    if($bonus_cashback > 0){
        $cek_bonus_cashback = $cbc->cek_bonus($member_id, $id_kodeaktivasi, $id_plan);
        if($cek_bonus_cashback == 0){
            $keterangan = 'Bonus Cashback dari paket '.$nama_plan_produk.' ('.rp($harga).')';
            $cbc->set_id_member($member_id);
            $cbc->set_nominal($bonus_cashback);
            $cbc->set_status_transfer('0');
            $cbc->set_dari_member($member_id);
            $cbc->set_id_kodeaktivasi($id_kodeaktivasi);
            $cbc->set_jenis_bonus($id_plan);
            $cbc->set_keterangan($keterangan);  
            $cbc->set_created_at($created_at);                
            $create_bonus_cashback = $cbc->create();
            if($create_bonus_cashback){
                $sms->smsBonusNew($member_id, $bonus_cashback, $keterangan, $created_at);
            }
        }
    }

    // if($bonus_sponsor_monoleg > 0 && $sponsor_id <> 'master'){
    //     $keterangan = 'Reedem Poin '.$lang['sponsor'].' dari ( ID: '.$id_member.' / '.$user_member.' ) paket '.$nama_plan_produk.' ('.rp($harga).')';
    //     $cw->set_id_member($sponsor_id);
    //     $cw->set_jenis_saldo('reedem');
    //     $cw->set_nominal($bonus_sponsor_monoleg);
    //     $cw->set_type('bonus_sponsor');
    //     $cw->set_keterangan($keterangan);
    //     $cw->set_status('d');
    //     $cw->set_status_transfer('0');
    //     $cw->set_dari_member($member_id);
    //     $cw->set_id_kodeaktivasi($id_kodeaktivasi);
    //     $cw->set_dibaca('0');
    //     $cw->set_created_at($created_at);                                
    //     $create_komisi_sponsor = $cw->create();
    //     if(!$create_komisi_sponsor){
    //         echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus '.$lang['sponsor'].'.']);
    //         return false;
    //     }
    //     $sms->smsBonusPoinSponsor($sponsor_id, $bonus_sponsor, $keterangan, $created_at);
    // }
    
    // if($bonus_poin_cashback > 0){
    //     $keterangan = 'Reedem Poin Cashback dari paket '.$nama_plan_produk.' ('.rp($harga).')';
    //     $cw->set_id_member($member_id);
    //     $cw->set_jenis_saldo('reedem');
    //     $cw->set_nominal($bonus_poin_cashback);
    //     $cw->set_type('bonus_cashback');
    //     $cw->set_keterangan($keterangan);
    //     $cw->set_status('d');
    //     $cw->set_status_transfer('0');
    //     $cw->set_dari_member($member_id);
    //     $cw->set_id_kodeaktivasi($id_kodeaktivasi);
    //     $cw->set_dibaca('0');
    //     $cw->set_created_at($created_at);                 
    //     $create_bonus_cashback = $cw->create();
    //     if(!$create_bonus_cashback){
    //         echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus cashback.']);
    //         return false;
    //     }
    //     $sms->smsBonusCashbackPoin($member_id, $bonus_cashback, $keterangan, $created_at);
    // }

    if($_binary == true && $jumlah_hu > 0){
        if($pasangan == '1' || $parent_pasangan > 0){
            $plan_pasangan = $id_plan;
            if($parent_pasangan > 0){
                $plan_pasangan = $parent_pasangan;
            }
            $update_potensi = $cbp->create_poin($member_id, $jumlah_hu, $id_kodeaktivasi, $plan_pasangan, $jenis_posting, $created_at);
        }
    }
    // if($_binary == true && $jumlah_hu > 0){
    //     if($pasangan_level == '1' || $parent_pasangan_level > 0){
    //         $plan_pasangan_level = $id_plan;
    //         if($parent_pasangan_level > 0){
    //             $plan_pasangan_level = $parent_pasangan_level;
    //         }
    //         $create_potensi = $cbpl->create_poin($member_id, $jumlah_hu, $id_kodeaktivasi, $plan_pasangan_level, $jenis_posting, $created_at);
    //     }
    // }

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
    // if($reward_sponsor == '1' || $parent_reward_sponsor > 0){
    //     $plan_reward_sponsor = $id_plan;
    //     if($parent_reward_sponsor > 0){
    //         $plan_reward_sponsor = $parent_reward_sponsor;
    //     }                    
    //     $create_poin_reward_sponsor = $cbr->create_poin_pribadi($sponsor_id, 1, $id_kodeaktivasi, $plan_reward_sponsor, $jenis_posting, $created_at);
    // }
    if($poin_reward_promo > 0){             
        $create_poin_reward_sponsor = $cbrs->create_poin($sponsor_id, $poin_reward_promo, $id_kodeaktivasi, $id_produk_jenis, $jenis_posting, $created_at);
    }

    if($bonus_generasi > 0){
        $jenis_bonus = $id_plan;
        $max = $ckg->max_generasi($id_plan);
        $keterangan = 'Paket '.$nama_plan_produk.' ('.rp($harga).')';
        $create_bonus_generasi = $ckg->create($member_id, $id_member, $user_member, $bonus_generasi, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at);	
    }

    if($bonus_upline > 0){
        $jenis_bonus = $id_plan;
        $max = $cku->max_generasi($id_plan);
        $keterangan = 'Paket '.$nama_plan_produk.' ('.rp($harga).')';
        $create_bonus_upline = $cku->create($member_id, $id_member, $user_member, $bonus_upline, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at);	
    }

    if($saldo_wd > 0){
        $cek_saldo_wd = $cswd->cek_saldo_wd($member_id, $id_kodeaktivasi);
        if($cek_saldo_wd == 0){
            $cswd->id_member = $member_id;
            $cswd->jenis_saldo = 'saldo_wd';
            $cswd->nominal = $saldo_wd;
            $cswd->type = $type_saldo_wd;
            $cswd->keterangan = $keterangan_saldo_wd;
            $cswd->status = 'd';
            $cswd->id_kodeaktivasi = $id_kodeaktivasi;
            $cswd->created_at = $created_at;
    
            $create_saldo_wd = $cswd->create();
        }
    }
        
    // if($fee_founder > 0 && $harga > 0){
    //     $founder = $cbf->index();
    //     while ($row = $founder->fetch_object()) {
    //         $keterangan = 'Fee '.$row->name.' Paket '.$nama_plan_produk;
    //         $id_founder = $row->id;
    //         $nominal_bonus = floor($fee_founder * $row->persentase_bonus/100);
    //         $create_bonus_founder = $cbf->create_binary($member_id, $id_member, $user_member, $id_founder, $nominal_bonus, $id_plan, $keterangan, $id_kodeaktivasi, $created_at);	
    //     }
    // }

    // if(isset($plan_pasangan)){
    //     $cbp->hitung_bonus_pasangan($id_kodeaktivasi, $member_plan, $plan_pasangan, $created_at, $member_id, $id_paket);
    // }

    if($member->id_peringkat == 0 && $id_plan == 8) {
        $cm->cek_peringkat($member_id, $id_kodeaktivasi, $created_at);
    }
    $message = '<p class="text-center text-muted mb-2 size-18">Posting Ulang Berhasil</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
