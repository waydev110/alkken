<?php 
    require_once '../../../helper/all.php';
    require_once '../../../model/classBonusSupport.php';
    $obj = new classBonusSupport();

    $created_at = date('Y-m-d H:i:s');
    $rekap_bonus_support = $obj->rekap_bonus_support($created_at);
    echo json_encode(['status' => true, 
                        'message' => 'Rekap Selesai.']);
    return true;
?>