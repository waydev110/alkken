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
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_deposit = addslashes(strip_tags($_POST['id_deposit']));
    $order = $cd->pending_bayar($id_deposit);
    if(!$order){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Deposit order tidak ditemukan.']);
        return false;
    }
    $status_order = addslashes(strip_tags($_POST['status_bayar']));
    $created_at = date('Y-m-d H:i:s');
    
    switch ($status_order) {
        case '1':
            $cd->set_status($status_order);
            $cd->set_id_admin($id_admin);
            $cd->set_updated_at($created_at);
            $update_status_bayar = $cd->update_status_bayar($id_deposit);
            if($update_status_bayar){
                echo json_encode(['status' => true, 'message' => 'Approve bayar berhasil.']);
                return true;
            }
            break;
        case '2':
            echo json_encode(['status' => true, 'message' => 'Approve Bayar gagal.']);
            return true;
            break;
    }
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;