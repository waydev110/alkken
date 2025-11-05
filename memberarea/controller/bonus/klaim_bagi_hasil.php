<?php
    require_once '../../../helper/all_member.php';    
    include ("../../model/classMember.php");
    $cm = new classMember();
    include ("../../model/classBonus.php");
    $obj = new classBonus();
    require_once '../../../model/classBonusCashback.php';
    $cbc = new classBonusCashback();
    require_once '../../../model/classSMS.php';
    $sms = new classSMS();

    $session_member_id;
    $id = addslashes(strip_tags($_POST['id']));
    $tanggal = addslashes(strip_tags($_POST['tanggal']));
    $tanggal = date("Y-m-d", strtotime($tanggal));
    if (strtotime($tanggal) > strtotime(date('Y-m-d'))){
        echo json_encode(['status' => false, 'message' => 'Belum saatnya klaim.']);
        return false;
    }
    $bonus_ke = addslashes(strip_tags($_POST['bonus_ke']));

    $cek_bagi_hasil = $obj->cek_bagi_hasil($session_member_id, $id, $tanggal);
    if($cek_bagi_hasil){
        echo json_encode(['status' => false, 'message' => 'Bonus Bagi Hasil sudah di klaim.']);
        return false;
    }

    $pin = $obj->riwayat_investasi_show($session_member_id, $id);
    $bonus_cashback = $pin->bonus_cashback;
    $nama_produk = $pin->nama_produk;
    $harga = $pin->harga;
    $id_plan = $pin->id_plan;
    $updated_at = $pin->updated_at;
    
    if($bonus_cashback > 0){
        $persentase_bonus_cashback = $cbc->persentase_bonus_cashback($session_member_id);
        $bonus_cashback = floor($bonus_cashback * $persentase_bonus_cashback/100);
        $percent_bonus = percent_bonus($persentase_bonus_cashback);
        $keterangan = 'Bonus Bagi Hasil ke-'.$bonus_ke.' dari '.$nama_produk.' ('.rp($harga).')';
        $cbc->set_id_member($session_member_id);
        $cbc->set_nominal($bonus_cashback);
        $cbc->set_status_transfer('0');
        $cbc->set_dari_member($session_member_id);
        $cbc->set_id_kodeaktivasi($id);
        $cbc->set_jenis_bonus($id_plan);
        $cbc->set_keterangan($keterangan);  
        $cbc->set_created_at($tanggal);                
        $create_bonus_cashback = $cbc->create();
        if(!$create_bonus_cashback){
            echo json_encode(['status' => false, 'message' => 'Gagal membuat bonus bagi hasil.']);
            return false;
        }
        $sms->smsBonusNew($session_member_id, $bonus_cashback, $keterangan, $tanggal);
    }

    echo json_encode(['status' => true, 'message' => 'Klaim bonus bagi hasil berhasil.']);
    return true;