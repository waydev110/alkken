<?php
    session_start();
    require_once '../../../helper/all.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classKodeAktivasi.php';
    require_once '../../../model/classPlan.php';

    $cm = new classMember();
    $cka = new classKodeAktivasi();
    $cpl = new classPlan();

    // Validasi input
    if(!isset($_POST['member_id']) || !isset($_POST['id_upgrade']) || !isset($_POST['id_kodeaktivasi'])){
        echo json_encode(['status' => false, 'message' => 'Data tidak lengkap']);
        return false;
    }

    $member_id = number($_POST['member_id']);
    $id_upgrade = number($_POST['id_upgrade']);
    $id_kodeaktivasi = number($_POST['id_kodeaktivasi']);

    // Validasi member
    $member = $cm->detail($member_id);
    if(!$member){
        echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan']);
        return false;
    }

    // Validasi plan upgrade
    $plan = $cpl->show($id_upgrade);
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Paket upgrade tidak ditemukan']);
        return false;
    }

    // Cek apakah paket upgrade lebih tinggi dari paket saat ini
    if($id_upgrade <= $member->id_plan){
        echo json_encode(['status' => false, 'message' => 'Paket upgrade harus lebih tinggi dari paket saat ini']);
        return false;
    }

    // Validasi PIN
    $pin_owner = isset($_POST['pin_owner']) ? number($_POST['pin_owner']) : $member_id;
    $pin = $cka->get_kodeaktivasi($pin_owner, $id_kodeaktivasi, 0);
    
    if(!$pin){
        echo json_encode(['status' => false, 'message' => 'PIN tidak ditemukan atau sudah digunakan']);
        return false;
    }

    // Validasi jenis PIN harus sesuai dengan paket upgrade
    if($pin->jenis_aktivasi != $id_upgrade){
        echo json_encode(['status' => false, 'message' => 'Jenis PIN tidak sesuai dengan paket upgrade']);
        return false;
    }

    // Set session untuk memberarea controller
    $_SESSION['session_member_id'] = $member_id;
    $_SESSION['session_user_member'] = $member->user_member;
    $_SESSION['session_sponsor_id'] = $member->sponsor;

    // Include memberarea controller
    require_once '../../../memberarea/controller/posting/upgrade_member.php';
