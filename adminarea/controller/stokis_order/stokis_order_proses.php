<?php
    session_start();
    $id_admin = $_SESSION['id_login'];
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
        echo json_encode(['status' => false, 'message' => 'Kesalahan Parameter.']);
        return false;
    }
    $id_deposit = addslashes(strip_tags($_POST['id_deposit']));
    $order = $cd->pending_kirim($id_deposit);
    if(!$order){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Order tidak ditemukan.']);
        return false;
    }
    $status_order = addslashes(strip_tags($_POST['status']));

    $id_stokis = $order->id_stokis_tujuan;
    $nominal = $order->subtotal;
    $jenis = 'saldo';
    $type = 'send_order';
    $status = 'd';
    $id_relasi = $id_deposit;
    $asal_tabel = 'mlm_stokis_deposit';
    $keterangan = 'Kirim Saldo Order';
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

            $create = $obj->create();
            if(!$create){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Kirim produk tidak dapat diproses.']);
                return false;
            } else {                
                $update_stok = $csp->create($id_deposit, $id_stokis, $created_at);
                if($update_stok){
                    $cd->set_status($status_order);
                    $cd->set_id_admin($id_admin);
                    $cd->set_updated_at($created_at);
                    $update_status = $cd->update_status_kirim($id_deposit);
                    $csms->smsSendOrder($id_stokis, $nominal, $created_at);
                    echo json_encode(['status' => true, 'message' => 'Kirim produk berhasil.']);
                    return true;
                } else {
                    $obj->delete($create);
                    echo json_encode(['status' => false, 'message' => 'Kirim produk gagal. Tidak dapat menambahkan stok.']);
                    return false;
                }
            }
            break;
        case '2':
            $cd->set_status($status_order);
            $cd->set_id_admin($id_admin);
            $cd->set_updated_at($created_at);
            $update_status = $cd->update_status_kirim($id_deposit);
            echo json_encode(['status' => true, 'message' => 'Kirim produk ditolak.']);
            return true;
            break;
    }
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;