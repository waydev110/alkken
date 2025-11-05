<?php
    session_start();
    
    
    $id_member = $session_member_id;

    # CEK PARAMETER POST
    if(!isset($_POST['jenis_saldo'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Silahkan coba lagi.']);
        return false;
    }
    $jenis_saldo = $_POST['jenis_saldo'];
    
    if($jenis_saldo == 'cash'){
        $saldo_bonus = $_POST['saldo_bonus'];
        $sisa_saldo = $cw->saldo_bonus($id_member, $jenis_saldo, $saldo_bonus);
    } else {
        $sisa_saldo = $cw->saldo($id_member, $jenis_saldo);
    }

    echo $sisa_saldo;
