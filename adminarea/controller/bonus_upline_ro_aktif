<?php
    require_once '../../../helper/string.php';
    require_once '../../../model/classBonusSponsor.php';
    
    $cbs = new classBonusSponsor();
    
    $bulan = date('Y-m', strtotime('-1 month'));
    // $bulan = date('Y-m');
    $create_rekap = $cbs->create_rekap($bulan);
    if($create_rekap){
        echo 'Rekap Selesai';
    } else {
        echo 'Rekap Gagal';
    }