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
    require_once '../../../model/classBonusUpline.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classBonusBalikModal.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSaldoPenarikan.php';
    require_once '../../../model/classPaket.php';
    require_once '../../../model/classSMS.php';
    
    $cm     = new classMember();
    $cmp    = new classMemberProspek();
    $cka    = new classKodeAktivasi();
    $cks    = new classBonusSponsor();
    $cksm   = new classBonusSponsorMonoleg();
    $cbp    = new classBonusPasangan();
    $cbpl   = new classBonusPasanganLevel();
    $ckg    = new classBonusGenerasi();
    $cku    = new classBonusUpline();
    $cbf    = new classBonusFounder();
    $cbc    = new classBonusCashback();
    $cbr    = new classBonusReward();
    $cw     = new classWallet();
    $cpl    = new classPlan();
    $cbbm = new classBonusBalikModal();
    $cswd   = new classSaldoPenarikan();
    $cp     = new classPaket();
    $sms    = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }

    $member = $cm->detail($session_member_id);
    if(!$member){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $member_id = $session_member_id;
    $id_member = $member->id_member;
    $sponsor_id = $member->sponsor;
    $nama_samaran = $member->nama_samaran;
    $user_member = $member->user_member;
    $current_plan = $member->id_plan;
    $current_tingkat = $member->tingkat;
    
    $id_plan = addslashes(strip_tags($_POST['id_upgrade']));
    $plan = $cpl->show($id_plan);
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    if(!isset($_POST['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. PIN tidak ditemukan']);
        return false;
    }
    $id_kodeaktivasi = number($_POST['id_kodeaktivasi']);
    $pin = $cka->get_kodeaktivasi($member_id, $id_kodeaktivasi, 0);
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. PIN tidak ditemukan.']);
        return false;
    }

    // $pin = $cka->cek_pin_upgrade($session_member_id, $id_plan);
    // if(!$pin){
    //     echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki '.$lang['pin'].' '.$plan->nama_plan]);
    //     return false;
    // }

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
    $fee_founder = $pin->fee_founder;  
    $tingkat = $pin->tingkat;
    $reposisi = $pin->reposisi;
    $founder = $pin->founder;
    $id_plan = $pin->jenis_aktivasi;
    $id_produk_jenis = $pin->jenis_produk;
    $nama_plan = $pin->nama_plan;
    $nama_plan_produk = $pin->nama_plan.' '.$pin->name;
    $reward_wajib_ro = $pin->reward_wajib_ro;
    $jenis_posting = 'posting';
    $id_paket = 1;
    $id_peringkat = 0;
    $saldo_wd = $pin->saldo_wd; 
    $nominal_balik_modal = $pin->nominal_balik_modal; 
    $type_saldo_wd = 'posting';
    $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar '.rp($saldo_wd).' dari paket '.$nama_plan;
    $created_at = date('Y-m-d H:i:s');

    try {   
        $update_aktivasi = $cka->update_aktivasi($id_kodeaktivasi, '1', $created_at);
        //Bonus Balik Modal
        if($id_plan == 16 || $id_plan == 17){
            if($harga > 0){
                $arr_plan = [
                    16 => 60,
                    17 => 40
                ];
                foreach ($arr_plan as $plan_member => $persentase) {
                    $get_member = $cbbm->get_member($plan_member);
                    $total_member = $get_member->num_rows;
                    if($total_member > 0){
                        $total_bonus = floor($nominal_balik_modal * $persentase / 100);
                        $nominal_bonus = floor($total_bonus / $total_member);
                        if($nominal_bonus > 0){
                            $create_rekap_bonus_balik_modal = $cbbm->create_rekap($plan_member, $nominal_balik_modal, $persentase, $total_bonus, $total_member, $nominal_bonus, $id_kodeaktivasi, $created_at);
                            $keterangan = 'Bonus Sharing Profit Reborn '.percent($persentase).' dari '.currency($nominal_balik_modal).' / '.$total_member.' member';
                            $create_bonus_balik_modal = $cbbm->create($get_member,$plan_member, $nominal_bonus, $keterangan, $id_kodeaktivasi, $created_at);
                        }
                    }
                }
            }
        }
        $create_history = $cka->create_history($id_kodeaktivasi, $member_id, $id_plan, $created_at);
        if(!$update_aktivasi){
            echo json_encode(['status' => false, 'message' => 'Gagal update '.$lang['pin'].'.']);
            return false;
        }

        if($bonus_sponsor > 0 && $sponsor_id <> 'master'){
            $keterangan = 'Bonus '.$lang['sponsor'].' dari ( ID: '.$id_member.' / '.$user_member.' ) paket '.$nama_plan_produk.' ('.rp($harga).')';
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

        if($bonus_sponsor_monoleg > 0){
            $sponsor_monoleg_id = $cksm->get_sponsor_monoleg($member_id);
            if($sponsor_monoleg_id > 0){
                $keterangan = 'Bonus '.$lang['sponsor'].' Monoleg dari ( ID: '.$id_member.' / '.$user_member.' ) paket '.$nama_plan_produk.' ('.rp($harga).')';
                $cksm->set_id_member($sponsor_monoleg_id);
                $cksm->set_nominal($bonus_sponsor_monoleg);
                $cksm->set_status_transfer('0');
                $cksm->set_dari_member($member_id);
                $cksm->set_id_kodeaktivasi($id_kodeaktivasi);
                $cksm->set_jenis_bonus($id_plan);
                $cksm->set_keterangan($keterangan);  
                $cksm->set_created_at($created_at);                
                $create_komisi_sponsor_monoleg = $cksm->create();
                if(!$create_komisi_sponsor_monoleg){
                    echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus '.$lang['sponsor'].' Monoleg.']);
                    return false;
                }
                $sms->smsBonusNew($sponsor_monoleg_id, $bonus_sponsor_monoleg, $keterangan, $created_at);
            }
        }
        
        if($bonus_cashback > 0){
            $keterangan = 'Bonus Cashback paket '.$nama_plan_produk.' ('.rp($harga).')';
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
        if($reward_sponsor == '1' || $parent_reward_sponsor > 0){
            $plan_reward_sponsor = $id_plan;
            if($parent_reward_sponsor > 0){
                $plan_reward_sponsor = $parent_reward_sponsor;
            }                    
            $create_poin_reward_sponsor = $cbr->create_poin_pribadi($sponsor_id, 1, $id_kodeaktivasi, $plan_reward_sponsor, $jenis_posting, $created_at);
        }

        if($_binary == true){
            $update_jumlah_kaki = $cm->update_jumlah_kaki($member_id, $tingkat);
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
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $cm->upgrade_plan($session_member_id, $id_plan, $current_plan, $id_kodeaktivasi, $reposisi, $created_at);
    $cm->upgrade_jumlah_kaki($session_member_id, $current_plan, $id_plan);
    $cm->upgrade_produk_jenis($session_member_id, $id_produk_jenis);
    $message = '<p class="text-center text-muted mb-2 size-18">Upgrade '.$nama_plan.' Berhasil.</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
