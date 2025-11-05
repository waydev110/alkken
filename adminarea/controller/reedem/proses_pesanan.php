<?php 
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberReedem.php';
    require_once '../../../model/classMemberReedemDetail.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classSMS.php';	
    require_once '../../../model/classBonusSponsor.php';
    require_once '../../../model/classBonusGenerasi.php';
    require_once '../../../model/classWallet.php';

    $cm = new classMember();
    $obj = new classMemberReedem();
    $cmod = new classMemberReedemDetail();
    $cka = new classKodeAktivasi();
    $csms= new classSMS();	
    $cks= new classBonusSponsor();
    $ckg= new classBonusGenerasi();
    $cw= new classWallet();

    $id_order = addslashes(strip_tags($_POST['id']));
    $created_at = date('Y-m-d H:i:s');
    $obj->set_status('1');
    $obj->set_updated_at($created_at);
    $obj->set_tgl_proses($created_at);
    $update = $obj->update_status($id_order);
    if($update){        
        $order = $obj->show($id_order);
        $id_member = $order->id_member;
        $id_stokis = $order->id_stokis;
        $detail_order = $cmod->get_order_detail($id_order);
        
        if($detail_order->num_rows == 0){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk tidak ditemukan.']);
            return false;
        }  
        // $total_pin = 0;
        // while($produk = $detail_order->fetch_object()){  
        //     for($i=1;$i<=$produk->qty;$i++){  
        //         $total_pin += 1;
        //         $kode_aktivasi = $cka->generate_code(12);
        //         $harga = $produk->harga;
        //         $jumlah_hu = $produk->jumlah_hu;
        //         $poin_reward = $produk->poin_reward;
        //         $bonus_sponsor = $produk->bonus_sponsor;
        //         $bonus_cashback = $produk->bonus_cashback;
        //         $bonus_generasi = $produk->bonus_generasi;
        //         $bonus_sponsor_monoleg = $produk->bonus_sponsor_monoleg;
        //         $bonus_poin_cashback = $produk->bonus_poin_cashback;


        //         $cka->set_kode_aktivasi($kode_aktivasi);
        //         $cka->set_jumlah_hu($jumlah_hu);
        //         $cka->set_harga($harga);   
        //         $cka->set_bonus_sponsor($bonus_sponsor);   
        //         $cka->set_bonus_cashback($bonus_cashback);   
        //         $cka->set_bonus_generasi($bonus_generasi);    
        //         $cka->set_poin_reward($poin_reward);   
        //         $cka->set_bonus_sponsor_monoleg($bonus_sponsor_monoleg);
        //         $cka->set_bonus_poin_cashback($bonus_poin_cashback);
        //         $cka->set_status_aktivasi(0);
        //         $cka->set_id_member($id_member);
        //         $cka->set_id_stokis($id_stokis);
        //         $cka->set_id_jual_pin(0);
        //         $cka->set_created_at($created_at);

        //         $create_kodeaktivasi = $cka->create();

        //         if(!$create_kodeaktivasi){
        //             echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Gagal membuat Kode Aktivasi.']);
        //             return false;
        //         }
        //     }
        // }
        echo json_encode(['status' => true, 'message' => 'Transaksi berhasil diproses.']);
    }else{
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk tidak ditemukan.']);
    }
?>