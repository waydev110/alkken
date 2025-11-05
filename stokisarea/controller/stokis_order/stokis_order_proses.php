<?php
    session_start();
    $id_stokis_tujuan = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../helper/date.php';
    require_once '../../../model/classStokisDeposit.php';
    require_once '../../../model/classStokisDepositDetail.php';
    require_once '../../../model/classStokisWallet.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classSMS.php';
    
    $cd = new classStokisDeposit();
    $cdd = new classStokisDepositDetail();
    $obj = new classStokisWallet();
    $csp = new classStokisProduk();
    $csms = new classSMS();

    if(!isset($_POST['id_deposit'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_deposit = addslashes(strip_tags($_POST['id_deposit']));
    $order = $cd->pending($id_deposit, $id_stokis_tujuan);
    if(!$order){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Deposit order tidak ditemukan.']);
        return false;
    }

    $produk_cart = $csp->produk_detail($id_deposit);  
    while($cart = $produk_cart->fetch_object()){
        $stok_produk = $csp->stok_produk($id_stokis_tujuan, $cart->id_produk);
        if($cart->qty > $stok_produk){
            echo json_encode(['status' => false, 'message' => 'Transaksi gagal. Produk '.$cart->nama_produk.' kurang.']);
            return false;
        }
    }

    $status_order = addslashes(strip_tags($_POST['status']));

    $id_stokis = $order->id_stokis;
    $nominal = $order->subtotal;
    $jenis = 'saldo';
    $type = 'order';
    $status = 'd';
    $id_relasi = $id_deposit;
    $asal_tabel = 'mlm_stokis_deposit';
    $keterangan = 'Saldo Order';
    $created_at = date('Y-m-d H:i:s');
    
    switch ($status_order) {
        case '1':
            $obj->set_id_stokis($id_stokis);
            $obj->set_jenis($jenis);
            $obj->set_type($type);
            $obj->set_status($status);
            $obj->set_nominal($nominal);
            $obj->set_id_relasi($id_relasi);
            $obj->set_asal_tabel($asal_tabel);
            $obj->set_keterangan($keterangan);
            $obj->set_created_at($created_at);

            $create1 = $obj->create();
            if(!$create1){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Stokis order tidak dapat diproses.']);
                return false;
            }
            $obj->set_id_stokis($id_stokis_tujuan);
            $obj->set_jenis($jenis);
            $obj->set_type($type);
            $obj->set_status('k');
            $obj->set_nominal($nominal);
            $obj->set_id_relasi($id_relasi);
            $obj->set_asal_tabel($asal_tabel);
            $obj->set_keterangan($keterangan);
            $obj->set_created_at($created_at);

            $create2 = $obj->create();
            if(!$create2){
                $obj->delete($create1);
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Stokis order tidak dapat diproses.']);
                return false;
            }
                          
            $tambah_stok = $csp->create_order($id_deposit, 'd', $id_stokis, $created_at);
            if(!$tambah_stok){
                $obj->delete($create1);
                $obj->delete($create2);
                $obj->delete($create);
                echo json_encode(['status' => false, 'message' => 'Stokis Order gagal. Tidak dapat menambahkan stok.']);
                return false;
            }

            $kurangi_stok = $csp->create_order($id_deposit, 'k', $id_stokis_tujuan, $created_at);
            if(!$kurangi_stok){
                $obj->delete($create1);
                $obj->delete($create2);
                $obj->delete($create);
                $csp->delete($id_deposit, $id_stokis, 'd');
                echo json_encode(['status' => false, 'message' => 'Stokis Order gagal. Tidak dapat menambahkan stok.']);
                return false;
            }

            $cd->set_status($status_order);
            $cd->set_id_admin($id_stokis_tujuan);
            $cd->set_updated_at($created_at);
            $update_status = $cd->update_status($id_deposit, $id_stokis, $id_stokis_tujuan);
            if(!$update_status){
                $obj->delete($create);
                $csp->delete($id_deposit, $id_stokis, 'd');
                $csp->delete($id_deposit, $id_stokis_tujuan, 'k');
                echo json_encode(['status' => false, 'message' => 'Stokis Order gagal. Tidak dapat menambahkan stok.']);
                return false;
            }
            $csms->smsDepositOrder($id_stokis, $nominal, $created_at);
            echo json_encode(['status' => true, 'message' => 'Stokis Order Berhasil disetujui.']);
            return true;
            break;
        case '2':
            $cd->set_status($status_order);
            $cd->set_id_admin($id_stokis_tujuan);
            $cd->set_updated_at($created_at);
            $update_status = $cd->update_status($id_deposit);
            $csms->smsDepositOrderReject($id_stokis, $nominal, $created_at);
            echo json_encode(['status' => true, 'message' => 'Stokis Order Berhasil ditolak.']);
            return true;
            break;
    }
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;