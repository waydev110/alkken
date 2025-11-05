<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    $id_paket_stokis = $_SESSION['session_paket_stokis'];
    require_once '../../../helper/string.php';
    require_once '../../../helper/date.php';
    require_once '../../../model/classStokisTransferCart.php';
    require_once '../../../model/classStokisTransfer.php';
    require_once '../../../model/classStokisTransferDetail.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classStokisMember.php';
    require_once '../../../model/classStokisWallet.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classStokisCashback.php';
    require_once '../../../model/classSMS.php';

    $ccart = new classStokisTransferCart();
    $obj = new classStokisTransfer();
    $cdd = new classStokisTransferDetail();
    $cps = new classStokisPaket();
    $csm = new classStokisMember();
    $csw = new classStokisWallet();
    $csp = new classStokisProduk();
    $csc = new classStokisCashback();
    $csms = new classSMS();

    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $created_at = date('Y-m-d H:i:s');
    $id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
    $subtotal  = $ccart->total_order($id_stokis, $id_stokis_tujuan);
    $diskon = $ccart->total_diskon($id_stokis, $id_stokis_tujuan);
    $total_bayar = $subtotal - $diskon;
    $total_cart = $ccart->total_cart($id_stokis, $id_stokis_tujuan);  
    $status = 1;
    $keterangan = 'Transfer Stok';

    if($subtotal == 0){
        echo json_encode(['status' => false, 'message' => 'Transfer Stok harus lebih dari 0.']);
        return false;
    }
    $obj->set_id_stokis($id_stokis);
    $obj->set_subtotal($subtotal);
    $obj->set_diskon($diskon);
    $obj->set_nominal($total_bayar);
    $obj->set_status($status);
    $obj->set_id_stokis_tujuan($id_stokis_tujuan);
    $obj->set_keterangan($keterangan);
    $obj->set_created_at($created_at);
    $create = $obj->create();

    if(!$create){
        echo json_encode(['status' => false, 'message' => 'Transfer Stok gagal.']);
        return false;
    }
    $produk_cart = $ccart->get_cart($id_stokis, $id_stokis_tujuan);
    if($produk_cart->num_rows == 0){
        echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk tidak ditemukan.']);
        return false;
    } 
    

    $produk_cart = $ccart->get_cart($id_stokis, $id_stokis_tujuan);  
    while($cart = $produk_cart->fetch_object()){
        $stok_produk = $csp->stok_produk($id_stokis, $cart->id_produk);
        if($cart->qty > $stok_produk){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk '.$cart->nama_produk.' kurang.']);
            return false;
        }
    }

    $produk_cart = $ccart->get_cart($id_stokis, $id_stokis_tujuan);  
    $total_fee = 0;
    $detail_produk = "Detail Produk :\n";
    $no = 0;
    while($produk = $produk_cart->fetch_object()){ 
        $cdd->set_id_transfer($create);
        $cdd->set_id_produk($produk->id_produk);
        $cdd->set_nama_produk($produk->nama_produk);
        $cdd->set_hpp($produk->hpp);
        $cdd->set_harga($produk->harga);
        $cdd->set_qty($produk->qty);
        $cdd->set_jumlah($produk->harga*$produk->qty);
        $cdd->set_fee_stokis(0);
        $cdd->set_created_at($created_at);

        $create_detail = $cdd->create();
        if(!$create_detail){
            // $obj->delete($create);
            echo json_encode(['status' => false, 'message' => 'Detail Transfer Stok gagal.']);
            return false;
        }
        $no++;
        $detail_produk .= $no." ".$produk->name." ".$produk->nama_produk." ".currency($produk->qty_produk)." ".$produk->satuan." ".rp($produk->harga)." x ".$produk->qty." = ".rp($produk->harga*$produk->qty)." \n";
    }
    // $create_detail = $cdd->create($id_stokis, $id_stokis_tujuan, $create, $persentase_fee, $created_at);

    // if($total_fee > 0){
    //     $csc->set_id_stokis($id_stokis);
    //     $csc->set_nominal($total_fee);
    //     $csc->set_status_transfer(0);
    //     $csc->set_id_transaksi($create);
    //     $csc->set_created_at($created_at);
    //     $stokis_cashback = $csc->create();
    // }

    $ccart->set_id_stokis($id_stokis);
    $ccart->set_id_stokis_tujuan($id_stokis_tujuan);
    $ccart->set_status(1);
    $update_status = $ccart->update_status();

    
    $jenis = 'saldo';
    $type = 'transfer';
    $status = 'k';
    $id_relasi = $create;
    $asal_tabel = 'mlm_stokis_transfer';
    $keterangan = 'Transfer Stok';

    
    $csw->set_id_stokis($id_stokis);
    $csw->set_jenis($jenis);
    $csw->set_type($type);
    $csw->set_status($status);
    $csw->set_nominal($subtotal);
    $csw->set_id_relasi($id_relasi);
    $csw->set_asal_tabel($asal_tabel);
    $csw->set_keterangan($keterangan);
    $csw->set_created_at($created_at);

    $create_wallet = $csw->create();
    if(!$create_wallet){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Transfer Stok tidak dapat diproses.']);
        return false;
    } else {                
        $update_stok = $csp->create_transfer($create, $status, $id_stokis, $created_at);
        if(!$update_stok){
            echo json_encode(['status' => false, 'message' => 'Transfer Stok gagal. Tidak dapat mengurangi stok.']);
            return false;
        }
    }
    $status = 'd';

    $csw->set_id_stokis($id_stokis_tujuan);
    $csw->set_jenis($jenis);
    $csw->set_type($type);
    $csw->set_status($status);
    $csw->set_nominal($subtotal);
    $csw->set_id_relasi($id_relasi);
    $csw->set_asal_tabel($asal_tabel);
    $csw->set_keterangan($keterangan);
    $csw->set_created_at($created_at);

    $create_wallet = $csw->create();
    if(!$create_wallet){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Transfer Stok tidak dapat diproses.']);
        return false;
    } else {                
        $update_stok = $csp->create_transfer($create, $status, $id_stokis_tujuan, $created_at);
        if(!$update_stok){
            echo json_encode(['status' => false, 'message' => 'Transfer Stok gagal. Tidak dapat menambahkan stok.']);
            return false;
        }
    }

    $csms->smsTransferStokPengirim($id_stokis, $id_stokis_tujuan, $subtotal, $detail_produk, $created_at);
    $csms->smsTransferStokPenerima($id_stokis, $id_stokis_tujuan, $subtotal, $detail_produk, $created_at);
    echo json_encode(['status' => true, 'id_transfer' => $create, 'nominal' => rp($subtotal)]);
    return true;