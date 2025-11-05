<?php 
    require_once '../../../helper/all.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberOrder.php';
    require_once '../../../model/classMemberOrderDetail.php';
    require_once '../../../model/classStokisJualPin.php';
    require_once '../../../model/classStokisJualPinDetail.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classStokisWallet.php';
    require_once '../../../model/classProduk.php';
    require_once '../../../model/classStokisCashback.php';
    require_once '../../../model/classStokisMember.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classSMS.php';	

    $cm = new classMember();
    $co = new classMemberOrder();
    $cmod = new classMemberOrderDetail();
    $obj = new classStokisJualPin();
    $cjpd = new classStokisJualPinDetail();
    $csp = new classStokisProduk();
    $cka = new classKodeAktivasi();
    $cws = new classStokisWallet();
    $cp = new classProduk();
    $csc = new classStokisCashback();
    $csm = new classStokisMember();
    $cps = new classStokisPaket();
    $csms= new classSMS();	

    $id_order = addslashes(strip_tags($_POST['id']));
    $created_at = date('Y-m-d H:i:s');

    $id_stokis = $session_stokis_id;
    $stokis = $csm->show($id_stokis);
    if(!$stokis){
        echo json_encode(['status' => false, 'message' => $lang['stokis'].' tidak ditemukan.']);
        return false;
    }
    $id_paket_stokis = $stokis->id_paket;

    $order = $co->show($id_order, $session_stokis_id);
    $id_member = $order->id_member;
    $member = $cm->detail($id_member);
    if(!$member){
        echo json_encode(['status' => false, 'message' => $lang['member'].' tidak ditemukan.']);
        return false;
    }
    $nominal = $cmod->total_order($id_order);
    $status = 1;
    $keterangan = 'jual_pin';

    if($nominal == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi harus lebih dari 0.']);
        return false;
    }

    $detail_order = $cmod->get_order_detail($id_order);
    while($produk_order = $detail_order->fetch_object()){
        $stok_produk = $csp->stok_produk($id_stokis, $produk_order->id_produk);
        if($produk_order->qty > $stok_produk){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Stok Produk ada yang kurang.']);
            return false;
        }
    }

    $obj->set_id_member($id_member);
    $obj->set_nominal($nominal);
    $obj->set_status($status);
    $obj->set_id_stokis($id_stokis);
    $obj->set_keterangan($keterangan);
    $obj->set_created_at($created_at);
    $obj->set_updated_at($created_at);
    $create = $obj->create();

    if(!$create){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal.']);
        return false;
    }

    $detail_order = $cmod->get_order_detail($id_order);
    
    if($detail_order->num_rows == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk tidak ditemukan.']);
        return false;
    }  
    $total_pin = 0;
    $total_fee = 0;
    while($produk = $detail_order->fetch_object()){  
        $fee_stokis = $produk->fee_stokis*$produk->qty; 
        $total_fee += $fee_stokis;
        $cjpd->set_id_jual_pin($create);
        $cjpd->set_id_produk($produk->id_produk);
        $cjpd->set_nama_produk($produk->nama_produk);
        $cjpd->set_hpp($produk->hpp);
        $cjpd->set_harga($produk->harga);
        $cjpd->set_qty($produk->qty);
        $cjpd->set_jumlah($produk->harga*$produk->qty);
        $cjpd->set_fee_stokis($fee_stokis);
        $cjpd->set_created_at($created_at);
        $create_detail = $cjpd->create();

        if(!$create_detail){
            $obj->delete($create);
            $cjpd->delete($create);
            $cka->delete_jual_pin($create);
            echo json_encode(['status' => false, 'message' => 'Detail Transaksi gagal.']);
            return false;
        }

        for($i=1;$i<=$produk->qty;$i++){  
            $kode_aktivasi = $cka->generate_code(12);
            $harga = $produk->harga;
            $jumlah_hu = $produk->jumlah_hu;
            $bonus_sponsor = $produk->bonus_sponsor;
            $bonus_cashback = $produk->bonus_cashback;
            $bonus_generasi = $produk->bonus_generasi;

            $cka->set_kode_aktivasi($kode_aktivasi);
            $cka->set_jumlah_hu($jumlah_hu);
            $cka->set_harga($harga);   
            $cka->set_bonus_sponsor($bonus_sponsor);   
            $cka->set_bonus_cashback($bonus_cashback);   
            $cka->set_bonus_generasi($bonus_generasi);   
            $cka->set_status_aktivasi(0);
            $cka->set_id_member($id_member);
            $cka->set_id_stokis($id_stokis);
            $cka->set_id_jual_pin($create);
            $cka->set_created_at($created_at);

            $create_kodeaktivasi = $cka->create();

            if(!$create_kodeaktivasi){
                $obj->delete($create);
                $cjpd->delete($create);
                $cka->delete_jual_pin($create);
                echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Gagal membuat Kode Aktivasi.']);
                return false;
            }
        }
    }
    
    $jenis = 'saldo';
    $type = 'jual_pin';
    $status = 'k';
    $id_relasi = $create;
    $asal_tabel = 'mlm_stokis_jual_pin';
    $keterangan = 'Pesanan';

    $cws->set_id_stokis($id_stokis);
    $cws->set_type($type);
    $cws->set_status($status);
    $cws->set_nominal($nominal);
    $cws->set_id_relasi($id_relasi);
    $cws->set_asal_tabel($asal_tabel);
    $cws->set_keterangan($keterangan);
    $cws->set_created_at($created_at);

    $create_wallet = $cws->create();
    if(!$create_wallet){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Tidak dapat mengurangi saldo.']);
        return false;
    } else {                
        $update_stok = $csp->create($create, $id_stokis, $created_at);
        if(!$update_stok){
            $obj->delete($create);
            $cjpd->delete($create);
            $cka->delete_jual_pin($create);
            $cws->delete($create);
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Tidak dapat mengurangi stok.']);
            return false;
        }
    }

    $paket_stokis = $cps->show($id_paket_stokis);
    if($paket_stokis){
        $fee_stokis = floor($total_fee * $paket_stokis->persentase_fee/100);
        if($fee_stokis > 0){
            $csc->set_id_stokis($id_stokis);
            $csc->set_nominal($fee_stokis);
            $csc->set_status_transfer(0);
            $csc->set_id_transaksi($create);
            $csc->set_created_at($created_at);
            $stokis_cashback = $csc->create();
        }
    }
    $co->set_status('1');
    $co->set_updated_at($created_at);
    $co->set_tgl_proses($created_at);
    $update = $co->update_status($id_order, $id_stokis);
    if(!$update){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Tidak dapat mengupdate status.']);
        return false;
    }
    $csms->smsOrderProses($id_member, $nominal, $created_at);
    $message = '<h5>Pesanan berhasil diproses.</h5>
                <h1 class="jenis-title text-bold px-4" id="nominalTitle">'.rp($nominal).'</h1>';
    echo json_encode(['status' => true, 'total_pin' => $total_pin, 'id_jual_pin' => $create, 'message' => $message]);
    return true;
?>