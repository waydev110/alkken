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
    require_once '../../../model/classBonusRewardPaket.php';
    require_once '../../../model/classBonusBalikModal.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSaldoPenarikan.php';
    require_once '../../../model/classSMS.php';
    
    $cm = new classMember();
    $cmp = new classMemberProspek();
    $cka = new classKodeAktivasi();
    $cks= new classBonusSponsor();
    $cksm= new classBonusSponsorMonoleg();
    $cbp= new classBonusPasangan();
    $cbpl= new classBonusPasanganLevel();
    $ckg= new classBonusGenerasi();
    $cku= new classBonusUpline();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cbr= new classBonusReward();
    $cbrs= new classBonusRewardPaket();
    $cbbm = new classBonusBalikModal();
    $cw= new classWallet();
    $cpl= new classPlan();
    $cswd= new classSaldoPenarikan();
    $sms  = new classSMS();
    
    if($_maintenance == true){
        echo json_encode(['status' => false, 'message' => 'Mohon maaf. Sistem sedang Maintenace. Silahkan dicoba beberapa saat lagi.']);
        return false;
    }

    $sponsor = $session_member_id;
    $sponsor_id = $session_member_id;
    if($_sponsor_static == false) {
        # CEK PARAMETER POST
        if(!isset($_POST['sponsor'])){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Sponsor tidak ditemukan.']);
            return false;
        }
        $data_sponsor = $cm->data_sponsor($session_member_id, $_POST['sponsor'], base64_decode($_POST['id_upline']));
        if(!$data_sponsor){
            echo json_encode(['status' => false, 'message' => 'Sponsor tidak ada dijaringan anda.']);
            return false;
        }
        $sponsor_id = $data_sponsor->id;
    }
    # CEK PARAMETER POST
    if(!isset($_POST['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }

    $tipe_akun = $_POST['tipe_akun'];
    // $tipe_akun = 0;
    // $current_kode_aktivasi = $_POST['kode_aktivasi'];
    $id_kodeaktivasi = number($_POST['id_kodeaktivasi']);
    
    // $plan = $cpl->show($id_plan);
    // if(!$plan){
    //     echo json_encode(['status' => false, 'message' => 'Paket join tidak valid.']);
    //     return false;
    // }
    // $tingkat = $plan->tingkat;
    // for($i = 1; $i <= $tingkat; $i++){
    //     $plan = $cpl->show_by_tingkat($i);
    //     if ($i < $tingkat){
    //         $current_plan = '';
    //     } else {
    //         $current_plan = $master_plan;
    //     }
    $pin = $cka->get_kodeaktivasi($sponsor, $id_kodeaktivasi, 0);
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Kode Aktivasi tidak ditemukan.']);
        return false;
    }
    # CEK KODE AKTIVASI
    $cek_duplikat = $cka->cek_duplikat($sponsor, $pin->kode_aktivasi);
    if($cek_duplikat > 0){
        echo json_encode(['status' => false, 'message' => $lang['pin'].' sudah digunakan.']);
        return false;
    }
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
    $saldo_wd = $pin->saldo_wd; 
    $nominal_balik_modal = $pin->nominal_balik_modal; 
    $type_saldo_wd = 'posting';
    $keterangan_saldo_wd = 'Penambahan Saldo Transfer Bonus sebesar '.rp($saldo_wd).' dari paket '.$nama_plan;
    $created_at = date('Y-m-d H:i:s');
    try {
        $upline = NULL;
        $posisi = addslashes(strip_tags($_POST['posisi']));
        if($_binary == true){
            $id_upline = base64_decode($_POST['id_upline']);
            $data_upline = $cm->show($id_upline);
            if(!$data_upline){
                echo json_encode(['status' => false, 'message' => 'Data upline tidak ditemukan.']);
                return false;
            }
            $upline = $id_upline;
            $level = $data_upline->level + 1;
            $cek_posisi = $cm->cek_posisi_kaki($id_upline, $posisi);
            if(!$cek_posisi){
                echo json_encode(['status' => false, 'message' => 'Posisi kaki penuh.']);
                return false;
            }
        } else {        
            $level = $data_sponsor->level + 1;
        }

        if($tipe_akun == '0'){
            $id_member = $cm->generate_id_member(5,'A99');
            $group_akun = $id_member;
            $pass_member = generatePassword();
            $pin_member = generatePIN();
            $nama_member = isset($_POST['nama_member']) ? addslashes(strip_tags($_POST['nama_member'])) : NULL;
            $hp_member = number($_POST['hp_member']);

            // $nama_samaran = addslashes(strip_tags($_POST['nama_samaran']));
            $user_member = addslashes(strip_tags($_POST['username']));
            $nama_samaran = $user_member;
            $tgl_lahir_member = NULL;
            $tempat_lahir_member = NULL;
            $alamat_member = NULL;
            $jns_kel_member = NULL;
            $no_ktp_member = NULL;
            $telp_member = NULL;
            $kodepos_member = NULL;
            $email_member = isset($_POST['email_member']) ? addslashes(strip_tags($_POST['email_member'])) : NULL;
            $no_rekening = isset($_POST['no_rekening']) ? addslashes(strip_tags($_POST['no_rekening'])) : NULL;
            // $atas_nama_rekening = $_POST['atas_nama_rekening'];
            $atas_nama_rekening = isset($_POST['nama_member']) ? addslashes(strip_tags($_POST['nama_member'])) : NULL;
            $cabang_rekening = isset($_POST['cabang_rekening']) ? addslashes(strip_tags($_POST['cabang_rekening'])) : NULL;
            $id_bank = isset($_POST['id_bank']) ? addslashes(strip_tags($_POST['id_bank'])) : NULL;
            $id_provinsi = NULL;
            $id_kota = NULL;
            $id_kecamatan = NULL;
            $id_kelurahan = NULL;
            $profile_updated = '1';

        } else if($tipe_akun == '1'){
            $cloning = $cm->detail($sponsor_id);
            if(!$cloning){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Data Cloning ID tidak ditemukan.']);
                return false;
            }
            
            if($cloning->group_akun == ''){
                $group_akun = $cloning->id_member;
            } else {
                $group_akun = $cloning->group_akun;
            }
            $jumlah_akun = $cm->jumlah_akun($group_akun);
            // $akronim = strtoupper($cm->admin_config("akronim_member"));
            // $count_akronim = strlen($akronim);
            // $potongan = substr($group_akun, $count_akronim)+$jumlah_akun;
            $id_member = $cm->generate_id_member(6,'00');
            // $id_member = $akronim.$potongan;

            // $group_akun = $cm->generate_group_akun($data_sponsor->id_member, 4);
            if($group_akun == ''){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Akun tidak dapat di cloning. Silahkan Hubungi administrator.']);
                return false; 
            }
            $pass_member = $cloning->pass_member;
            $pin_member = $cloning->pin_member;
            $nama_member = addslashes(strip_tags($cloning->nama_member));
            $hp_member = $cloning->hp_member;

            $nama_samaran = addslashes(strip_tags($cloning->nama_samaran));
            $user_member = $cloning->user_member.$jumlah_akun;
            $tgl_lahir_member = $cloning->tgl_lahir_member;
            $tempat_lahir_member = $cloning->tempat_lahir_member;
            $alamat_member = $cloning->alamat_member;
            $jns_kel_member = $cloning->jns_kel_member;
            $no_ktp_member = $cloning->no_ktp_member;
            $telp_member = $cloning->telp_member;
            $kodepos_member = $cloning->kodepos_member;
            $email_member = $cloning->email_member;
            $no_rekening = $cloning->no_rekening;
            $atas_nama_rekening = $cloning->atas_nama_rekening;
            $cabang_rekening = $cloning->cabang_rekening;
            $id_bank = $cloning->id_bank;
            $id_kota = $cloning->id_kota;
            $id_provinsi = $cloning->id_provinsi;
            $id_kecamatan = $cloning->id_kecamatan;
            $id_kelurahan = $cloning->id_kelurahan;
            $profile_updated = '1';
        } else if($tipe_akun == '2'){

            $id_member_prospek = $_POST['member_prospek'];
            $member_prospek = $_POST['member_prospek'];
            // $member_prospek = $cmp->show($sponsor, $member_prospek);
            $_data_sponsor = $cm->detail($sponsor_id);
            $_sponsor = $_data_sponsor->user_member;
            $member_prospek = $cmp->show($id_member_prospek, $sponsor_id);
            if(!$member_prospek){
                echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki '.$lang['member'].' prospek.']);
                return false;
            }

            $id_member = $cm->generate_id_member(6,'00');
            $no_rekening = $member_prospek->no_rekening;
            $group_akun = $cm->cek_nomor_rekening($no_rekening);
            if(!$group_akun){
                $group_akun = $id_member;
            } else {                
                // $jumlah_akun = $cm->jumlah_akun($group_akun);
                // $akronim = strtoupper($cm->admin_config("akronim_member"));
                // $count_akronim = strlen($akronim);
                // $potongan = substr($group_akun, $count_akronim)+$jumlah_akun;
                // $id_member = $akronim.$potongan;
                $id_member = $cm->generate_id_member(6,'00');
            }
            $pass_member = generatePassword();
            $pin_member = generatePIN();
            $nama_member = addslashes(strip_tags($member_prospek->nama_member));
            $hp_member = $member_prospek->hp_member;

            $nama_samaran = addslashes(strip_tags($member_prospek->nama_member));
            $user_member = addslashes(strip_tags($member_prospek->nama_samaran));
            $tgl_lahir_member = NULL;
            $tempat_lahir_member = NULL;
            $alamat_member = NULL;
            $jns_kel_member = NULL;
            $no_ktp_member = NULL;
            $telp_member = NULL;
            $kodepos_member = NULL;
            $email_member = addslashes(strip_tags($member_prospek->email));
            $no_rekening = addslashes(strip_tags($member_prospek->no_rekening));
            $atas_nama_rekening = addslashes(strip_tags($member_prospek->nama_member));
            $cabang_rekening = addslashes(strip_tags($member_prospek->cabang_rekening));
            $id_bank = addslashes(strip_tags($member_prospek->id_bank));
            $id_provinsi = NULL;
            $id_kota = NULL;
            $id_kecamatan = NULL;
            $id_kelurahan = NULL;
            $profile_updated = '0';
        } else {
            echo json_encode(['status' => false, 'message' => 'Tipe akun tidak valid.']);
            return false;
        }
        
    	$cm->set_id_member($id_member);
    	$cm->set_nama_member($nama_member);
    	$cm->set_hp_member($hp_member);
    	$cm->set_kode_aktivasi($kode_aktivasi);
    	$cm->set_id_plan($id_plan);
    	$cm->set_id_paket($id_paket);
        $cm->set_id_peringkat($id_peringkat);
        $cm->set_id_produk_jenis($id_produk_jenis);
    	$cm->set_sponsor($sponsor_id);
    	$cm->set_upline($upline);
    	$cm->set_posisi($posisi);
    	$cm->set_level($level);
    	$cm->set_group_akun($group_akun);
    	$cm->set_status_member('1');

        
        $cm->set_nama_samaran($nama_samaran);
        $cm->set_user_member($user_member);
        $cm->set_pass_member($pass_member);	
        $cm->set_pin_member($pin_member);	
        $cm->set_tgl_lahir_member($tgl_lahir_member);
        $cm->set_tempat_lahir_member($tempat_lahir_member);
        $cm->set_alamat_member($alamat_member);
        $cm->set_jns_kel_member($jns_kel_member);
        $cm->set_no_ktp_member($no_ktp_member);
        $cm->set_telp_member($telp_member);
        $cm->set_kodepos_member($kodepos_member);
        $cm->set_email_member($email_member);
        $cm->set_no_rekening($no_rekening);
        $cm->set_atas_nama_rekening($atas_nama_rekening);
        $cm->set_cabang_rekening($cabang_rekening);
        $cm->set_id_bank($id_bank);
        $cm->set_id_provinsi($id_provinsi);
        $cm->set_id_kota($id_kota);
        $cm->set_id_kecamatan($id_kecamatan);
        $cm->set_id_kelurahan($id_kelurahan);
        $cm->set_reposisi($reposisi);
        $cm->set_founder($founder);
        $cm->set_profile_updated($profile_updated);
        $cm->set_created_at($created_at);

        $member_id = $cm->create();
        if($member_id > 0){            
            if($_binary == true){
                $update_kaki_upline = $cm->update_kaki($id_upline, $member_id, $posisi);
            }
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
                                $create_bonus_balik_modal = $cbbm->create($get_member, $plan_member, $nominal_bonus, $keterangan, $id_kodeaktivasi, $created_at);
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

            if($bonus_sponsor > 0){
                if($id_plan == 200){
                    $keterangan = 'Bonus '.$lang['sponsor'].' dari ( ID: '.$id_member.' / '.$nama_samaran.' / '.$user_member.' ) paket '.$nama_plan.' ('.rp($harga).')';    
                    $cw->set_id_member($sponsor_id);
                    $cw->set_jenis_saldo('reward');
                    $cw->set_nominal($bonus_sponsor);
                    $cw->set_type('bonus_sponsor');
                    $cw->set_keterangan($keterangan);
                    $cw->set_status('d');
                    $cw->set_status_transfer('0');
                    $cw->set_dari_member($member_id);
                    $cw->set_id_kodeaktivasi($id_kodeaktivasi);
                    $cw->set_dibaca('0');
                    $cw->set_created_at($created_at);                 
                    $create = $cw->create();
                } else {
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

            $sms->smsPendaftaran($member_id);
            $sms->smsPendaftaranSponsor($member_id, $sponsor_id);
            if($tipe_akun == '2'){
                $cmp->update($sponsor, $member_prospek->id);
            }

        } else {
            echo json_encode(['status' => false, 'message' => 'Aktifasi gagal. Silahkan hubungi administrator untuk pemecahan masalah.']);
            return false;
        }
        if($tipe_akun == '2'){
            $cmp->update($_sponsor, $id_member_prospek);
        }
        
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $message = '<p class="text-center text-muted mb-2 size-18">Pendaftaran Berhasil</p>
                <p class="text-center text-muted mb-2 size-14">Berikut data '.$lang['member'].' anda : </p>
                <p>Nama Member : '.$nama_member.'</p>
                <p>ID '.$lang['member'].' : '.$id_member.'</p>
                <p>Username : '.$user_member.'</p>
                <p>Password : '.base64_decode($pass_member).'</p>
                <p>PIN : '.base64_decode($pin_member).'</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
