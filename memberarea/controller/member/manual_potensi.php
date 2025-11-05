<?php
    date_default_timezone_set("Asia/Jakarta");
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();
    
    if(isset($_GET['token'])){
        echo 'Masuk..';
        // $cm->update_jumlah_potensi(8699, 2, '9nbT6075gpzb', date('Y-m-d H:i:s', '2023-06-05 13:31:00'));
    } else {
        echo 'Ups..';
    }