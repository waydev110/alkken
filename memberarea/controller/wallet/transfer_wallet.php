<?php
#---------------VALIDASI------------------------#
    # 1. CEK TOKEN EXPIRED = YES
    # 2. CEK PARAMETER POST = YES
    # 3. CEK MAKSIMAL PENARIKAN = YES
    # 4. CEK SALDO = YES
#-----------------------------------------------#

#---------------AKSI------------------------#
    # 1. CREATE TRANSFER WALLET = YES
#-----------------------------------------------#


    date_default_timezone_set("Asia/Jakarta");
    require_once '../../../helper/all_member.php';    
    if(!cek_token()){
        echo json_encode(['status' => false, 'message' => 'Token Expired.']);
        return false;
    }
    require_once '../../../model/classMember.php';
    
	require_once '../../../model/classWalletTransfer.php';
    
    $cm = new classMember();
    $cwt  = new classWalletTransfer();
    
    $id_member = $session_member_id;
    # CEK PARAMETER POST
    if(!isset($_POST['nominal_transfer']) || !isset($_POST['wallet_asal']) || !isset($_POST['wallet_tujuan'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    $nominal_transfer = number($_POST['nominal_transfer']);
    # CEK PARAMETER POST
    if($nominal_transfer <= 0){
        echo json_encode(['status' => false, 'message' => 'Transfer wallet gagal. nominal transfer 0']);
        return false;
    }

    $wallet_asal = $_POST['wallet_asal'];
    if($wallet_asal == ''){
        echo json_encode(['status' => false, 'message' => 'Transfer wallet gagal. Wallet asal tidak dipilih.']);
        return false;
    }
    $wallet_tujuan = $_POST['wallet_tujuan'];
    if($wallet_tujuan == ''){
        echo json_encode(['status' => false, 'message' => 'Transfer wallet gagal. Wallet tujuan tidak dipilih.']);
        return false;
    }
    
    if($wallet_asal == 'cash'){
        $type = $_POST['saldo_bonus'];
        $sisa_saldo = $cw->saldo_bonus($id_member, $wallet_asal, $type);
        // $max_transfer = 1750000;
        // if($type == 'bonus_pasangan'){
        //     $cek_last_ro = $cwt->cek_last_ro($id_member);
        //     if($cek_last_ro->num_rows > 0){
        //         $last_ro = $cek_last_ro->fetch_object()->updated_at;
        //         $cek_transfer = $cwt->jumlah_transfer_from_date($id_member, $wallet_asal, $type, $last_ro);
        //     } else {
        //         $cek_transfer = $cwt->jumlah_transfer($id_member, $wallet_asal, $type);
        //     }
        //     echo json_encode(['status' => false, 'message' => 'Anda sudah melakukan Transfer sejumlah '.rp($cek_transfer).'.Maksimal Transfer Saldo Bonus Pasangan : '.rp($max_transfer).' Lakukan Repeat Order terlebih dahulu.']);
        //     return false;
        //     $total_transfer = $cek_transfer + $nominal_transfer;

        //     if($cek_transfer >= $max_transfer ){
        //         echo json_encode(['status' => false, 'message' => 'Anda sudah melakukan Transfer sejumlah '.rp($cek_transfer).'.Maksimal Total Transfer Saldo Bonus Pasangan : '.rp($max_transfer).' Lakukan Repeat Order terlebih dahulu.']);
        //         return false;
        //     }
        //     $allow_transfer = $max_transfer - $cek_transfer;
        //     if($total_transfer > $max_transfer ){
        //         echo json_encode(['status' => false, 'message' => 'Maksimal Transfer Saldo Bonus Pasangan : '.rp($allow_transfer)]);
        //         return false;
        //     }
        // }
    } else {
        $type = NULL;
        $sisa_saldo = $cw->saldo($id_member, $wallet_asal);
    }
    if($nominal_transfer > $sisa_saldo ){
        echo json_encode(['status' => false, 'message' => 'Saldo tidak cukup. Maksimal Transfer : '.rp($sisa_saldo)]);
        return false;
    }

    try {
        $created_at = date("Y-m-d H:i:s");
        # CREATE PENARIKAN
        $cwt->set_id_member($id_member);
        $cwt->set_jenis_saldo_asal($wallet_asal);  
        $cwt->set_jenis_saldo_tujuan($wallet_tujuan);  
        $cwt->set_type($type);  
        $cwt->set_jumlah($nominal_transfer);  
        $cwt->set_created_at($created_at);

        $create_transfer_wallet = $cwt->create();

        if($create_transfer_wallet){
            $cw->set_id_member($id_member);     
            $cw->set_jenis_saldo($wallet_asal);  
            $cw->set_nominal($nominal_transfer);
            $cw->set_type($type);
            $cw->set_status('k');
            $cw->set_dari_member($create_transfer_wallet);
            $cw->set_keterangan('Transfer Saldo Wallet');
            $cw->set_created_at($created_at);
    
            $create_wallet = $cw->create();

            $cw->set_id_member($id_member);     
            $cw->set_jenis_saldo($wallet_tujuan);  
            $cw->set_nominal($nominal_transfer);
            $cw->set_type('transfer_saldo');
            $cw->set_status('d');
            $cw->set_dari_member($create_transfer_wallet);
            $cw->set_keterangan('Transfer Saldo Wallet');
            $cw->set_created_at($created_at);
    
            $create_wallet = $cw->create();
        } else {
            echo json_encode(['status' => false, 'message' => 'Transfer Wallet Gagal.']);
            return false;
        }
    } catch (\Exception $e) {
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $message = '<p class="text-center mb-2 size-18 text-success fw-bold">Transfer Wallet Berhasil</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
