<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $cka = new classKodeAktivasi();
    $cpl = new classPlan();
    $sms    = new classSMS();
    $created_at = date('Y-m-d H:i:s');

    if(!isset($_POST['id_member'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }

    $id_member = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$id_member){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Member tidak ditemukan.']);
        return false;
    }
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $jenis_produk = 0;
    if(isset($_POST['jenis_produk']) && $_POST['jenis_produk'] > 0){
        $jenis_produk = $_POST['jenis_produk'];
    }
    $plan = $cpl->show($id_plan);
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Paket tidak ditemukan.']);
        return false;
    }

    $qty_paket = 0;
    if(isset($_POST['qty_paket']) && $_POST['qty_paket'] > 0){
        $qty_paket = number($_POST['qty_paket']);
    }

    if($qty_paket <= 0){
        echo json_encode(['status' => false, 'message' => 'Qty Paket minimal 1.']);
        return false;
    }

    $jenis_plan = $plan->jenis_plan;    
    $jumlah_hu = $plan->jumlah_hu;   
    $poin_reward = $plan->poin_reward;
    $harga_paket = $plan->harga;
    $bonus_sponsor = $plan->bonus_sponsor;  
    $bonus_generasi = $plan->bonus_generasi;
    $bonus_cashback = $plan->bonus_cashback;
    $bonus_sponsor_monoleg = $plan->bonus_sponsor_monoleg;   
    $bonus_poin_cashback = $plan->bonus_poin_cashback; 
    $id_paket = 1;
    $created_at = date('Y-m-d H:i:s');
    $reposisi = number($_POST['reposisi']);
    $founder = number($_POST['founder']);   
    if($reposisi == 1){
        $jumlah_hu = 0;   
        $poin_reward = 0;
        $harga_paket = 0;
        $bonus_sponsor = 0;  
        $bonus_generasi = 0;
        $bonus_cashback = 0;
        $bonus_sponsor_monoleg = 0;   
        $bonus_poin_cashback = 0;         
    }
    
    for($i=1;$i<=$qty_paket;$i++) {
        $kode_aktivasi = $cka->generate_code(12);

        $cka->set_kode_aktivasi($kode_aktivasi);
        $cka->set_jumlah_hu($jumlah_hu);
        $cka->set_poin_reward($poin_reward);
        $cka->set_harga($harga_paket);   
        $cka->set_bonus_sponsor($bonus_sponsor);   
        $cka->set_bonus_cashback($bonus_cashback);   
        $cka->set_bonus_generasi($bonus_generasi);  
        $cka->set_bonus_sponsor_monoleg($bonus_sponsor_monoleg);
        $cka->set_bonus_poin_cashback($bonus_poin_cashback);
        $cka->set_jenis_aktivasi($id_plan);   
        $cka->set_jenis_produk($jenis_produk);   
        $cka->set_status_aktivasi(0);
        $cka->set_id_member($id_member);
        $cka->set_id_stokis(0);
        $cka->set_id_jual_pin(0);
        $cka->set_reposisi($reposisi);
        $cka->set_founder($founder);
        $cka->set_created_at($created_at);

        $create_kodeaktivasi = $cka->create();
    
        if(!$create_kodeaktivasi){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Gagal membuat Kode Aktivasi.']);
            return false;
        }
    }
    $message = 'Create '.$lang['kode_aktivasi'].' sebanyak '.$qty_paket.' berhasil.';
    echo json_encode(['status' => true, 'total_plan' => $qty_paket, 'message' => $message]);
    return true;