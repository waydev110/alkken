<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classUndianKupon.php';
    $obj = new classUndianKupon();

    
    $jenis_kupon = $_POST['jenis_kupon'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    $kupon_pending = $obj->get_kupon_undian($jenis_kupon, $start_date, $end_date);
    if($kupon_pending->num_rows > 0){
        $kupon = [];
        while ($row = $kupon_pending->fetch_object()) {
            $index = new stdClass; 
            $index->kupon = $row->kupon_id;
            $kupon[] = $index;
        }
        echo json_encode(['status' => true, 'kupon' => $kupon]);
    }else {
        echo json_encode(['status' => false, 'message' => 'Tidak ada '.$lang['member'].' yang memiliki Kupon.']);
    }