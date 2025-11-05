<?php   
    session_start();
    require_once '../../../helper/all_member.php'; 
    require_once '../../../model/classMemberOrder.php';
    require_once '../../../model/classMemberOrderDetail.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classStokisWallet.php';
    require_once '../../../model/classStokisCashback.php';

    require_once '../../../model/classMember.php';
    require_once '../../../model/classPaket.php';
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusPasangan.php';
    require_once '../../../model/classBonusPasanganLevel.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classBonusUpline.php';
    require_once '../../../model/classBonusFounder.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classBonusReward.php';
    require_once '../../../model/classUndianKupon.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSaldoPenarikan.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classSMS.php';

    $obj = new classMemberOrder();
    $cmod = new classMemberOrderDetail();
    $csp = new classStokisProduk();
    $cka = new classKodeAktivasi();
    $cws = new classStokisWallet();
    $csc = new classStokisCashback();
    
    $cm = new classMember();
    $cp = new classPaket();
    $cks= new classBonusSponsor();
    $cbp= new classBonusPasangan();
    $cbpl= new classBonusPasanganLevel();
    $ckg= new classBonusGenerasi();
    $cku= new classBonusUpline();
    $cbf= new classBonusFounder();
    $cbc= new classBonusCashback();
    $cbr= new classBonusReward();
    $cuk= new classUndianKupon();
    $cswd= new classSaldoPenarikan();
    $cpl= new classPlan();
    $cw= new classWallet();
    $sms  = new classSMS();

    if(!isset($_POST['id'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $member_id = $session_member_id;
    $id = base64_decode($_POST['id']);

    $order = $obj->show($id, $member_id);
    if(empty($order)){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Pesanan tidak ditemukan.']);
        return false;
    }
    $updated_at = date('Y-m-d H:i:s');
    $obj->set_id($id);
    $obj->set_id_member($member_id);
    $obj->set_status('3');
    $obj->set_updated_at($updated_at);
    $update_status = $obj->konfirmasi_pesanan();  
    if(!$update_status){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Pesanan gagal diselesaikan.']);
        return false;
    }
    $id_stokis = $order->id_stokis;
    $id_plan = 201;    
    $jenis_produk = 201;

    $produk_order = $cmod->show_order($id, $member_id);    
    if($produk_order->num_rows == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Pesanan tidak ditemukan.']);
        return false;
    } 
    
    $no = 0;
    $harga_pin = 0;
    $jumlah_hu = 0;
    $poin_reward = 0;
    $bonus_sponsor = 0;
    $bonus_cashback = 0;
    $bonus_generasi = 0;
    $bonus_upline = 0;
    $bonus_sponsor_monoleg = 0;
    $total_fee = 0;
    $fee_founder = 0;
    $fee_stokis = 0;
    $detail_produk = 'Detail Produk : \n';
    while($produk = $produk_order->fetch_object()){              
        $harga_pin              += $produk->jumlah; 
        $jumlah_hu              += $produk->poin_pasangan*$produk->qty; 
        $poin_reward            += $produk->poin_reward*$produk->qty; 
        $bonus_sponsor          += $produk->bonus_sponsor*$produk->qty; 
        $bonus_cashback         += $produk->bonus_cashback*$produk->qty; 
        $bonus_generasi         += $produk->bonus_generasi*$produk->qty; 
        $bonus_upline         += $produk->bonus_upline*$produk->qty; 
        $bonus_sponsor_monoleg  += $produk->bonus_sponsor_monoleg*$produk->qty; 
        $fee_stokis             += $produk->fee_stokis*$produk->qty;
        $fee_founder             += $produk->fee_founder*$produk->qty; 
        $total_fee += $fee_stokis;    
        $no++;
        $detail_produk .= $no.". ".$produk->nama_produk_detail ."\n";
        $detail_produk .= " ".rp($produk->harga)." x ".$produk->qty." = ".rp($produk->harga*$produk->qty)." \n";
    }

    $kode_aktivasi = $cka->generate_code(12);

    $cka->set_kode_aktivasi($kode_aktivasi);
    $cka->set_jumlah_hu($jumlah_hu);
    $cka->set_poin_reward($poin_reward);
    $cka->set_harga($harga_pin);   
    $cka->set_bonus_sponsor($bonus_sponsor);   
    $cka->set_bonus_cashback($bonus_cashback);   
    $cka->set_bonus_generasi($bonus_generasi);  
    $cka->set_bonus_upline($bonus_upline);  
    $cka->set_bonus_sponsor_monoleg($bonus_sponsor_monoleg);
    $cka->set_jenis_aktivasi($id_plan);   
    $cka->set_jenis_produk($jenis_produk);   
    $cka->set_status_aktivasi(0);
    $cka->set_id_member($member_id);
    $cka->set_id_stokis($id_stokis);
    $cka->set_id_jual_pin($id);
    $cka->set_created_at($updated_at);

    $create_kodeaktivasi = $cka->create();

    if(!$create_kodeaktivasi){
        echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan. Silahkan hUbungi administrator']);
        return false;
    }

    $jenis = 'saldo';
    $type = 'member_order';
    $status = 'k';
    $id_relasi = $id;
    $asal_tabel = 'mlm_member_order';
    $keterangan = 'Pembayaran Pesanan ID : '.$id;

    $cws->set_id_stokis($id_stokis);
    $cws->set_type($type);
    $cws->set_status($status);
    $cws->set_nominal($harga_pin);
    $cws->set_id_relasi($id_relasi);
    $cws->set_asal_tabel($asal_tabel);
    $cws->set_keterangan($keterangan);
    $cws->set_created_at($updated_at);

    $create_wallet = $cws->create();
    if(!$create_wallet){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Tidak dapat mengurangi saldo.']);
        return false;
    } else {                
        $update_stok = $csp->create_member_order($id, 'k', $id_stokis, $updated_at);
    }

    if($total_fee > 0){
        $csc->set_id_stokis($id_stokis);
        $csc->set_nominal($total_fee);
        $csc->set_status_transfer(0);
        $csc->set_id_transaksi($id);
        $csc->set_created_at($updated_at);
        $stokis_cashback = $csc->create();
    }

    $member = $cm->detail($member_id);
    $sponsor_id = $member->sponsor;
    $id_member = $member->id_member;
    $user_member = addslashes(strip_tags($member->user_member));
    $member_plan = $member->id_plan;
    $id_paket = $member->id_paket;
    $nama_samaran = addslashes(strip_tags($member->nama_samaran));

    # CEK KODE AKTIVASI
    $pin = $cka->get_kodeaktivasi_reseller($member_id, $create_kodeaktivasi, 2);
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'Anda tidak memiliki '.$lang['pin_ro']]);
        return false;
    }
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

    try {
        $update_aktivasi = $cka->update_aktivasi($id_kodeaktivasi, '1', $created_at);
        $create_history = $cka->create_history($id_kodeaktivasi, $member_id, $id_plan, $created_at);
        if($update_aktivasi){    
            if($bonus_sponsor > 0 && $sponsor_id <> 'master'){
                $keterangan = 'Bonus '.$lang['sponsor'].' dari ( ID: '.$id_member.' / '.$nama_samaran.' / '.$user_member.' ) paket '.$nama_plan.' ('.rp($harga).')';    
                $cw->set_id_member($sponsor_id);
                $cw->set_jenis_saldo('cash');
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
            }
            if($bonus_cashback > 0){
                $keterangan = 'Bonus Cashback dari paket '.$nama_plan.' ('.rp($harga).')';    
                $cw->set_id_member($member_id);
                $cw->set_jenis_saldo('reward');
                $cw->set_nominal($bonus_cashback);
                $cw->set_type('bonus_cashback');
                $cw->set_keterangan($keterangan);
                $cw->set_status('d');
                $cw->set_status_transfer('0');
                $cw->set_dari_member($member_id);
                $cw->set_id_kodeaktivasi($id_kodeaktivasi);
                $cw->set_dibaca('0');
                $cw->set_created_at($created_at);                 
                $create = $cw->create();
                $keterangan = 'Bonus Cashback dari ( ID: '.$id_member.' / '.$nama_samaran.' / '.$user_member.' ) paket '.$nama_plan.' ('.rp($harga).')';    
                $max = 5;
                $cbc->create_wallet($member_id, $bonus_cashback, $keterangan, $id_kodeaktivasi, $max, $created_at);
            }

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
                    if($id_plan != 14){ //Efective pertanggal 01 Juni 2025
                        $create_poin_reward = $cbr->create_poin_binary($member_id, $poin_reward, $id_kodeaktivasi, $plan_reward, $reward_wajib_ro, $jenis_posting, $created_at);
                    }
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
        }
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }

    echo json_encode(['status' => true, 'message' => 'Pesanan berhasil diselesaikan.']);
    return true;

?>