<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    $id_paket_stokis = $_SESSION['session_paket_stokis'];
    require_once '../../../helper/all.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classStokisJualPinCart.php';
    require_once '../../../model/classStokisJualPin.php';
    require_once '../../../model/classStokisJualPinDetail.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classStokisWallet.php';
    require_once '../../../model/classProduk.php';
    require_once '../../../model/classStokisCashback.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classPlan.php';
    require_once '../../../model/classWallet.php';
    require_once '../../../model/classBonusCashback.php';
    require_once '../../../model/classSMS.php';

    $cm = new classMember();
    $ccart = new classStokisJualPinCart();
    $obj = new classStokisJualPin();
    $cjpd = new classStokisJualPinDetail();
    $csp = new classStokisProduk();
    $cka = new classKodeAktivasi();
    $cws = new classStokisWallet();
    $cp = new classProduk();
    $csc = new classStokisCashback();
    $cps = new classStokisPaket();
    $cpl = new classPlan();
    $cw = new classWallet();
    $cbc = new classBonusCashback();
    $csms    = new classSMS();
    $created_at = date('Y-m-d H:i:s');

    if(!isset($_POST['id_member'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }

    $member_id = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$member_id){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Member tidak ditemukan.']);
        return false;
    }
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
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
    // $id_produk_wajib = 8;
    // $produk_wajib = $ccart->cek_produk_wajib($member_id, $id_stokis, $id_produk_wajib);
    // $show_produk = $cp->show($id_produk_wajib);

    // if(!$produk_wajib && $produk_wajib->total !== $qty_paket && $nilai_produk > 1){        
    //     echo json_encode(['status' => false, 'message' => 'Qty Produk '.$show_produk->nama_produk.' harus sama dengan : '.currency($qty_paket).'pcs.']);        
    //     return true;
    // }

    $jumlah_jenis_produk = $ccart->jumlah_jenis_produk($member_id, $id_stokis);
    if($jumlah_jenis_produk->num_rows > 1){
        echo json_encode(['status' => false, 'message' => 'Tidak boleh ada jenis produk berbeda dalam satu transaksi. ']);
        return false;
    }
    $jenis_produk = $jumlah_jenis_produk->fetch_object()->id_produk_jenis;
    $nilai_produk = $plan->nilai_produk*$qty_paket;
    $total_nilai_produk = $ccart->total_nilai_produk($member_id, $id_stokis, $id_plan);

    if($nilai_produk > $total_nilai_produk){
        $selisih = $nilai_produk - $total_nilai_produk;
        echo json_encode(['status' => false, 'nilai_produk' => $nilai_produk, 'total_nilai_produk' => $total_nilai_produk, 'message' => 'Produk Kurang. Minimal Nilai Produk '.decimal($nilai_produk)]);        
        return true;
    } else if($nilai_produk < $total_nilai_produk){
        $selisih = $total_nilai_produk - $nilai_produk;
        echo json_encode(['status' => false, 'nilai_produk' => $nilai_produk, 'total_nilai_produk' => $total_nilai_produk, 'message' => 'Produk Lebih. Maksimal Nilai Produk '.decimal($nilai_produk)]);   
        return true;
    }

    $total_qty = $ccart->total_qty($member_id, $id_stokis, $id_plan);
    $nominal = $ccart->total_order($member_id, $id_stokis, $id_plan);
    $status = 1;
    $keterangan = 'jual_pin';

    if($total_qty == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi harus lebih dari 0.']);
        return false;
    }

    $produk_cart = $ccart->get_cart($member_id, $id_stokis, $id_plan);  
    while($cart = $produk_cart->fetch_object()){
        $stok_produk = $csp->stok_produk($id_stokis, $cart->id_produk);
        if($cart->qty > $stok_produk){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk '.$cart->nama_produk.' kurang.']);
            return false;
        }
    }

    $harga_paket = floor($nominal/$qty_paket);
    $obj->set_id_member($member_id);
    $obj->set_id_plan($id_plan);
    $obj->set_harga($harga_paket);
    $obj->set_qty($qty_paket);
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

    $produk_cart = $ccart->get_cart($member_id, $id_stokis, $id_plan);    
    if($produk_cart->num_rows == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk tidak ditemukan.']);
        return false;
    } 
    
    $no = 0;
    $harga_paket = 0;
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
    while($produk = $produk_cart->fetch_object()){  
        $produk_diskon = $ccart->produk_diskon($produk->id_produk, $produk->qty);

        $diskon = 0;
        if($produk_diskon){
            if($produk_diskon->diskon == 'nominal'){
                $diskon += $produk_diskon->nominal * $produk->qty;
            } else {
                $diskon += $produk->harga*($produk_diskon->persetase/100) * $produk->qty;
            }
        }            
        // if($diskon > 0){
        //     $persentase_bonus_cashback = $cbc->persentase_bonus_cashback($member_id);
        //     $nominal_cashback = floor($diskon * $persentase_bonus_cashback/100);
        //     $keterangan = 'Saldo Autosave Cashback dari Pembelian Produk '.$produk->nama_produk.' sebanyak '.currency($produk->qty);
        //     $cw->set_id_member($member_id);
        //     $cw->set_jenis_saldo('poin');
        //     $cw->set_nominal($nominal_cashback);
        //     $cw->set_type('bonus_cashback');
        //     $cw->set_keterangan($keterangan);
        //     $cw->set_status('d');
        //     $cw->set_status_transfer('0');
        //     $cw->set_dari_member($member_id);
        //     $cw->set_id_kodeaktivasi($create);
        //     $cw->set_dibaca('0');
        //     $cw->set_created_at($created_at);                 
        //     $cw->create();
        //     $csms->smsBonusCashbackPoin($member_id, $nominal_cashback, $keterangan, $created_at);
        // }
        $cjpd->set_id_jual_pin($create);
        $cjpd->set_id_produk($produk->id_produk);
        $cjpd->set_nama_produk($produk->nama_produk);
        $cjpd->set_hpp($produk->hpp);
        $cjpd->set_harga($produk->harga);
        $cjpd->set_qty($produk->qty);
        $cjpd->set_jumlah($produk->harga*$produk->qty);
        $cjpd->set_fee_stokis(0);
        $cjpd->set_created_at($created_at);
        $create_detail = $cjpd->create();

        if(!$create_detail){
            $obj->delete($create);
            $cjpd->delete($create);
            $cka->delete_jual_pin($create);
            echo json_encode(['status' => false, 'message' => 'Detail Transaksi gagal.']);
            return false;
        }
        
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
    $jumlah_hu = floor($jumlah_hu/$qty_paket);
    $poin_reward = floor($poin_reward/$qty_paket);
    $harga_pin = floor($nominal/$qty_paket);
    $bonus_sponsor = floor($bonus_sponsor/$qty_paket);
    $bonus_cashback = floor($bonus_cashback/$qty_paket);
    $bonus_generasi = floor($bonus_generasi/$qty_paket);
    $bonus_upline = floor($bonus_upline/$qty_paket);
    $bonus_sponsor_monoleg = floor($bonus_sponsor_monoleg/$qty_paket);
    
    for($i=1;$i<=$qty_paket;$i++) {


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
    
    $jenis = 'saldo';
    $type = 'jual_pin';
    $status = 'k';
    $id_relasi = $create;
    $asal_tabel = 'mlm_stokis_jual_pin';
    $keterangan = 'Penjualan';

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

    if($total_fee > 0){
        $csc->set_id_stokis($id_stokis);
        $csc->set_nominal($total_fee);
        $csc->set_status_transfer(0);
        $csc->set_id_transaksi($create);
        $csc->set_created_at($created_at);
        $stokis_cashback = $csc->create();
    }
    
    $ccart->set_id_member($member_id);
    $ccart->set_id_stokis($id_stokis);
    $ccart->set_status(1);
    $update_status = $ccart->update_status();

    $nama_plan = $plan->nama_plan;
    $csms->smsJualPinStokis($id_stokis, $member_id, $nama_plan, $qty_paket, $nominal, $detail_produk, $created_at);
    $csms->smsJualPinMember($id_stokis, $member_id, $nama_plan, $qty_paket, $nominal, $detail_produk, $created_at);
    $message = '<h5>Transaksi berhasil</h5>
                <h3 class="jenis-title text-bold px-4">'.currency($qty_paket).' Paket '.$nama_plan.'</h3>
                <h1 class="jenis-title text-bold px-4" id="nominalTitle">'.rp($nominal).'</h1>';
    echo json_encode(['status' => true, 'total_pin' => $qty_paket, 'id_jual_pin' => $create, 'message' => $message]);
    return true;