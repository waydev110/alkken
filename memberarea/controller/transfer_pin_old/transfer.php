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

    require_once '../../../helper/all_member.php';    
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

    $id_member_lama = $session_member_id;
    
    # CEK PARAMETER POST
    if(!isset($_POST['kode_aktivasi']) || !isset($_POST['id'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    
    # CEK KODE AKTIVASI
    $id_member_baru = base64_decode($_POST['id']);
    $arr_kodeaktivasi = $_POST['kode_aktivasi'];

    $filter = [];
    foreach ($arr_kodeaktivasi as $key => $kode_aktivasi) {
        $filter[] = "k.kode_aktivasi = '$kode_aktivasi'";
    }
    $filter_kode_aktivasi = implode(' OR ', $filter);

    $result = $cka->cek_transfer($filter_kode_aktivasi, $id_member_lama);

    if($result){
        $now = date('Y-m-d H:i:s', time());
        while($row = $result->fetch_object()){
            $ct->set_id_member_lama($id_member_lama);
            $ct->set_id_member_baru($id_member_baru);
            $ct->set_id_kodeaktivasi($row->id);
            $ct->set_created_at($now);

            $insert = $ct->create();
            if($insert){
                $cka->set_id_member($id_member_baru);

                $update = $cka->update_transfer($row->id);
                if(!$update){
                    $ct->destroy($insert);
                }
            }
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Transfer '.$lang['kode_aktivasi'].' Gagal.']);
        return false;
    }

    $message = '<p class="text-center mb-2 size-18 text-success fw-bold">Transfer '.$lang['kode_aktivasi'].' Berhasil</p>
                <p class="text-center text-muted mb-2 size-12">Silahkan cek di riwayat transfer '.$lang['kode_aktivasi'].'.</p>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
