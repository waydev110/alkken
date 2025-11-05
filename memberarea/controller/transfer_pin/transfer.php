<?php
#---------------VALIDASI------------------------#
    # 1. CEK TOKEN EXPIRED = YES
    # 2. CEK PARAMETER POST = YES
    # 3. CEK KODE AKTIVASI = YES
#-----------------------------------------------#

#---------------AKSI------------------------#
    # 1. CREATE HISTORY TRANSFER = YES
    # 2. UPDATE KODE AKTIVASI = YES
#-----------------------------------------------#

    include('../../../helper/all_member.php');    
    if(!cek_token()){
        echo json_encode(['status' => false, 'message' => 'Token Expired.']);
        return false;
    }

    require_once '../../../model/classMember.php';
    $cm = new classMember();
    
    require_once '../../../model/classKodeAktivasi.php';
    $cka  = new classKodeAktivasi();

    require_once '../../../model/classTransferKodeAktivasi.php';
    $ct  = new classTransferKodeAktivasi();

    require_once '../../../model/classPlan.php';
    $cpl  = new classPlan();

    require_once '../../../model/classSMS.php';
    $csms  = new classSMS();

    $member_id = $session_member_id;
    
    # CEK PARAMETER POST
    if(!isset($_POST['arr_plan']) || !isset($_POST['id'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    
    # CEK KODE AKTIVASI
    $member_id_tujuan = base64_decode($_POST['id']);
    $arr_plan = $_POST['arr_plan'];
    $arr_jenis = $_POST['arr_jenis'];
    $arr_reposisi = $_POST['arr_reposisi'];
    $arr_founder = $_POST['arr_founder'];
    $arr_qty = $_POST['qty'];
    $created_at = date('Y-m-d H:i:s');

    $total_pin = 0;
    $detail_pin = '';
    $total_harga = 0;
    foreach ($arr_plan as $key => $id_plan) {
        $jenis_produk = $arr_jenis[$key];
        $reposisi = $arr_reposisi[$key];
        $founder = $arr_founder[$key];

        $qty = $arr_qty[$key];
        $total_pin += $qty;
        $result = $cka->index_group_transfer($member_id, $id_plan, $jenis_produk, $reposisi, $founder, $qty);
        if(!$result){
            echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
            return false;
        }
        while($row = $result->fetch_object()){
            $ct->set_id_member_lama($member_id);
            $ct->set_id_member_baru($member_id_tujuan);
            $ct->set_id_kodeaktivasi($row->id);
            $ct->set_created_at($created_at);

            $insert = $ct->create();
            if($insert){
                $cka->set_id_member($member_id_tujuan);

                $update = $cka->update_transfer($row->id);
                if(!$update){
                    $ct->destroy($insert);
                }
            }
            $total_harga += $row->harga;            
            $reposisi_label = $row->reposisi == '1' ? 'Reposisi' : '';
            $founder_label = $row->founder == '1' ? 'Founder' : '';
            $pin_label = $row->nama_plan.' '.$row->name.' '.$reposisi_lavel.' '.$founder_label;
        }
        if($qty > 0){
            $detail_pin .= "-".$qty." ".$pin_label."\n";
        }
    }
    if($detail_pin<>''){
        $csms->smsTransferPINPengirim($member_id, $member_id_tujuan, $total_harga, $total_pin, $detail_pin, $created_at);
        $csms->smsTransferPINPenerima($member_id, $member_id_tujuan, $total_harga, $total_pin, $detail_pin, $created_at);
    }

    $message = '<p class="text-center mb-2 size-18 text-success fw-bold">Transfer '.$lang['kode_aktivasi'].' Berhasil</p>
                <p class="text-center text-muted mb-2 size-12">Silahkan cek di riwayat transfer '.$lang['kode_aktivasi'].'.</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
