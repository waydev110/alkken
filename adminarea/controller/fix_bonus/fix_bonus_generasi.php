<?php
    session_start();
    if(isset($_SESSION['id_login']) && isset($_POST['id_member']) && isset($_POST['id_kodeaktivasi']) && isset($_POST['jenis_bonus'])){

        require_once '../../../model/classMember.php';
        require_once '../../../model/classBonusGenerasi.php';
        require_once '../../../model/classKodeAktivasi.php';
        
        $cm = new classMember();
        $obj = new classBonusGenerasi();
        $cka = new classKodeAktivasi();
        
        
        $id_member = base64_decode($_POST['id_member']);
        $member = $cm->detail($id_member);
        $id_kodeaktivasi = base64_decode($_POST['id_kodeaktivasi']);
        $jenis_bonus = $_POST['jenis_bonus'];
        $nama_samaran = $member->nama_samaran; 
        $pin = $cka->show($id_kodeaktivasi);
        $nominal = $pin->bonus_generasi;    
        $max = $obj->max_generasi($pin->harga); 
        $created_at = $pin->updated_at;    

        if($nominal > 0){
            $create = $obj->create($id_member, $id_member, $nama_samaran, $nominal, $jenis_bonus, $id_kodeaktivasi, $max, $created_at);
            if($create){
                echo json_encode(['status' => true, 'message' => 'Fix Bonus Generasi Sukses.']);
                return false;
            }
        }
    } else {
        echo json_encode(['status' => false, 'session' => isset($_SESSION['id_login']), 'message' => 'Session atau parameter salah.']);
        return false;
    }
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
?>