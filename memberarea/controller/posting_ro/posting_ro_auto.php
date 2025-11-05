<?php
    require_once '../../../helper/config.php';
    require_once '../../../helper/string.php';
    require_once '../../../helper/date.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSaldoPenarikan.php';
    require_once '../../../model/classUndianKupon.php';
    
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cka = new classKodeAktivasi();
    $cks= new classBonusSponsor();
    $ckg= new classBonusGenerasi();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cuk= new classUndianKupon();
    $cbr= new classBonusReward();
    $cswd= new classSaldoPenarikan();
    $cpl= new classPlan();
    $sms  = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }
    
    $get_kodeaktivasi_auto = $cka->get_kodeaktivasi_auto();
    if($get_kodeaktivasi_auto->num_rows == 0){
        // echo 'Tidak PIN Pending.';
        return true;
    }
    // echo 'Jumlah Kode Aktivasi = '.$get_kodeaktivasi_auto->num_rows.'<br>';

    while($pin = $get_kodeaktivasi_auto->fetch_object()){
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
        $parent_reward = $pin->parent_reward;  
        // $parent_reward_pribadi = $pin->parent_reward_pribadi;  
        $fee_founder = $pin->fee_founder;  
        $id_plan = $pin->id_plan;
        $nama_plan = $pin->nama_plan;
        $wajib_posting = $pin->wajib_posting;
        $jenis_posting = 'posting_auto';

        $member_id = $pin->id_member;
        $member = $cm->detail($member_id);
        $member_plan = $member->id_plan;
        $id_member = $member->id_member;
        $nama_samaran = $member->nama_samaran;
        $sponsor_id = $member->sponsor;
        $saldo_wd = $pin->saldo_wd; 
        $type_saldo_wd = 'posting';
        $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar '.rp($saldo_wd).' dari paket '.$nama_plan;
        $created_at = date('Y-m-d H:i:s');
        // echo 'Member Plan = '.$member_plan.'<br>';
        if($member_plan > 1){      
            $update_aktivasi = $cka->update_aktivasi($id_kodeaktivasi, '1', $created_at);
            $create_history = $cka->create_history($id_kodeaktivasi, $member_id, $id_plan, $created_at);
            if($update_aktivasi){   
                if($bonus_sponsor > 0){
                    // $persentase_bonus_sponsor = $cks->persentase_bonus_sponsor($sponsor_id);
                    // $bonus_sponsor = floor($bonus_sponsor * $persentase_bonus_sponsor/100);
                    // $percent_bonus = percent_bonus($persentase_bonus_sponsor);
                    $keterangan = 'Bonus '.$lang['sponsor'].' dari '.$nama_samaran.' ('.$id_member.') dari produk '.$nama_produk.' ('.rp($harga).')';
                    $cks->set_id_member($sponsor_id);
                    $cks->set_nominal($bonus_sponsor);
                    $cks->set_status_transfer('0');
                    $cks->set_dari_member($member_id);
                    $cks->set_id_kodeaktivasi($id_kodeaktivasi);
                    $cks->set_jenis_bonus($id_plan);
                    $cks->set_keterangan($keterangan);  
                    $cks->set_created_at($created_at);                
                    $create_komisi_sponsor = $cks->create();
                    if(!$create_komisi_sponsor){
                        echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus '.$lang['sponsor'].'.']);
                        return false;
                    }
                    $sms->smsBonusNew($sponsor_id, $bonus_sponsor, $keterangan, $created_at);
                }
                
                if($bonus_cashback > 0){
                    // $persentase_bonus_cashback = $cbc->persentase_bonus_cashback($member_id);
                    // $bonus_cashback = floor($bonus_cashback * $persentase_bonus_cashback/100);
                    // $percent_bonus = percent_bonus($persentase_bonus_cashback);
                    $keterangan = 'Bonus Cashback dari produk '.$nama_produk.' ('.rp($harga).')';
                    $cbc->set_id_member($member_id);
                    $cbc->set_nominal($bonus_cashback);
                    $cbc->set_status_transfer('0');
                    $cbc->set_dari_member($member_id);
                    $cbc->set_id_kodeaktivasi($id_kodeaktivasi);
                    $cbc->set_jenis_bonus($id_plan);
                    $cbc->set_keterangan($keterangan);  
                    $cbc->set_created_at($created_at);                
                    $create_bonus_cashback = $cbc->create();
                    if(!$create_bonus_cashback){
                        echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus cashback.']);
                        return false;
                    }
                    $sms->smsBonusNew($member_id, $bonus_cashback, $keterangan, $created_at);
                }
    
                if($bonus_sponsor_monoleg > 0){
                    // $persentase_bonus_sponsor = $cks->persentase_bonus_sponsor($sponsor_id);
                    // $bonus_sponsor = floor($bonus_sponsor_monoleg * $persentase_bonus_sponsor/100);
                    // $percent_bonus = percent_bonus($persentase_bonus_sponsor);
                    $keterangan = 'Autosave dari '.$nama_samaran.' ('.$id_member.').';
                    $cw->set_id_member($sponsor_id);
                    $cw->set_jenis_saldo('poin');
                    $cw->set_nominal($bonus_sponsor_monoleg);
                    $cw->set_type('bonus_sponsor');
                    $cw->set_keterangan($keterangan);
                    $cw->set_status('d');
                    $cw->set_status_transfer('0');
                    $cw->set_dari_member($member_id);
                    $cw->set_id_kodeaktivasi($id_kodeaktivasi);
                    $cw->set_dibaca('0');
                    $cw->set_created_at($created_at);                                
                    $create_komisi_sponsor = $cw->create();
                    if(!$create_komisi_sponsor){
                        echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus '.$lang['sponsor'].'.']);
                        return false;
                    }
                    $sms->smsBonusPoinSponsor($sponsor_id, $bonus_sponsor, $keterangan, $created_at);
                }
                
                if($bonus_poin_cashback > 0){
                    // $persentase_bonus_cashback = $cbc->persentase_bonus_cashback($member_id);
                    // $bonus_cashback = floor($bonus_poin_cashback * $persentase_bonus_cashback/100);
                    // $percent_bonus = percent_bonus($persentase_bonus_cashback);
                    $keterangan = 'Autosave';
                    $cw->set_id_member($member_id);
                    $cw->set_jenis_saldo('poin');
                    $cw->set_nominal($bonus_poin_cashback);
                    $cw->set_type('bonus_cashback');
                    $cw->set_keterangan($keterangan);
                    $cw->set_status('d');
                    $cw->set_status_transfer('0');
                    $cw->set_dari_member($member_id);
                    $cw->set_id_kodeaktivasi($id_kodeaktivasi);
                    $cw->set_dibaca('0');
                    $cw->set_created_at($created_at);                 
                    $create_bonus_cashback = $cw->create();
                    if(!$create_bonus_cashback){
                        echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus cashback.']);
                        return false;
                    }
                    $sms->smsBonusCashbackPoin($member_id, $bonus_cashback, $keterangan, $created_at);
                }
                if($_binary == true && $jumlah_hu > 0){
                    if($pasangan == '1' || $parent_pasangan > 0){
                        $plan_pasangan = $id_plan;
                        if($parent_pasangan > 0){
                            $id_plan = $parent_pasangan;
                        }
                        $update_potensi = $cbp->create_poin($member_id, $jumlah_hu, $id_kodeaktivasi, $plan_pasangan, $jenis_posting, $created_at);
                    }
                }

                if($_binary == true && $poin_reward > 0){
                    if($reward == '1' || $parent_reward > 0){
                        $plan_reward = $id_plan;
                        if($parent_reward > 0){
                            $plan_reward = $parent_reward;
                            $parent_plan = $cpl->show($plan_reward);
                            $wajib_posting = $parent_plan->wajib_posting;
                        }
                        $create_poin_reward = $cbr->create_poin_binary($member_id, $poin_reward, $id_kodeaktivasi, $plan_reward, $wajib_posting, $jenis_posting, $created_at);
                    }
                }  
                
                // if($reward_pribadi == '1' || $parent_reward_pribadi > 0){
                if($reward_pribadi == '1'){
                    $plan_reward = $id_plan;
                    // if($parent_reward_pribadi > 0){
                    //     $plan_reward = $parent_reward_pribadi;
                    // }                    
                    $create_poin_reward_pribadi = $cbr->create_poin_pribadi($member_id, $poin_reward, $id_kodeaktivasi, $plan_reward, $jenis_posting, $created_at);
                }
                
                // if($bonus_generasi > 0){
                //     $jenis_bonus = $id_plan;
                //     $max = $ckg->max_generasi($id_plan);
                //     $keterangan = '';
                //     $create_bonus_generasi = $ckg->create($member_id, $id_member, $nama_samaran, $bonus_generasi, $jenis_bonus, $keterangan, $id_kodeaktivasi, $max, $created_at);	
                // }
                
                if($fee_founder > 0 && $harga > 0){
                    $founder = $cbf->index();
                    while ($row = $founder->fetch_object()) {
                        $keterangan = 'Fee '.$row->name.' Paket '.$nama_plan;
                        $id_founder = $row->id;
                        $nominal_bonus = floor($fee_founder * $row->persentase_bonus/100);
                        $create_bonus_founder = $cbf->create_binary($member_id, $id_member, $nama_samaran, $id_founder, $nominal_bonus, $id_plan, $keterangan, $id_kodeaktivasi, $created_at);	
                    }
                }

                if($saldo_wd > 0){        
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
                
                // $undian = $cuk->jenis_undian();
                // if($undian->num_rows > 0) {
                //     // echo 'Jumlah Undian = '.$undian->num_rows.'<br>';
                //     while($row = $undian->fetch_object()){                        
                //         $total_pin = $cuk->cek_pin_kupon($member_id);  
                //         // echo 'Total PIN = '.$total_pin.'<br>';
                //         $total_kupon = floor($total_pin/$row->poin);
                //         $jumlah_kupon = $cuk->cek_undian_kupon($member_id, $row->id); 
                //         // echo 'Jumlah Kupon = '.$jumlah_kupon.'<br>';
                //         if($total_kupon > $jumlah_kupon){
                //             $kupon = $total_kupon - $jumlah_kupon;
                //             // echo 'Kupon Baru = '.$kupon.'<br><br>';
                //             for($i=1;$i<=$kupon;$i++){    
                //                 $kupon_id = $cuk->generateKupon();       
                //                 $jenis_kupon = $row->id;
                //                 $cuk->set_kupon_id($kupon_id);
                //                 $cuk->set_id_member($member_id);
                //                 $cuk->set_jenis_kupon($jenis_kupon);
                //                 $cuk->set_status('0');
                //                 $cuk->set_created_at($created_at);       
                //                 $create_kupon = $cuk->create();
    
                //             }
                //         }
                //     }
                // }
            }
        }
    }
    echo 'true';
    return true;
