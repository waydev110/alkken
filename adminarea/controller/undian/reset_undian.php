<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classUndianKupon.php';
    $obj = new classUndianKupon();

    
    $jenis_kupon = $_POST['jenis_kupon'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $periode = $_POST['periode'];
    
    $update_kupon_undian = $obj->reset_kupon_undian($jenis_kupon, $start_date, $end_date);
    if($update_kupon_undian){
        $reset_pemenang = $obj->reset_pemenang_undian($jenis_kupon, $periode);
        echo json_encode(['status' => true, 'message' => 'Berhasil.']);
    }else {
        echo json_encode(['status' => false, 'message' => 'Tidak ada '.$lang['member'].' yang memiliki Kupon.']);
    }