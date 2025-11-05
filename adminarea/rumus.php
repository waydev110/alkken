<?php 
    require_once("helper/all.php");
    require_once("../memberarea/model/classMember.php");
    $cm = new classMember();
    $tanggal_lahir = date('dmY', strtotime('1988-09-04'));
    $arr_element = array(
        [
            'unsur' => 'Logam',
            'warna' => 'Hitam'
        ],
        [
            'unsur' => 'Air Kecil',
            'warna' => 'Kuning'
        ],
        [
            'unsur' => 'Api Kecil',
            'warna' => 'Biru Muda'
        ],
        [
            'unsur' => 'Kayu Kecil',
            'warna' => 'Hijau'
        ],
        [
            'unsur' => 'Tanah',
            'warna' => 'Merah'
        ],
        [
            'unsur' => 'Logam Besar',
            'warna' => 'Hitam'
        ],
        [
            'unsur' => 'Air Besar',
            'warna' => 'Silver'
        ],
        [
            'unsur' => 'Api Besar',
            'warna' => 'Biru Tua'
        ],
        [
            'unsur' => 'Kayu Besar',
            'warna' => 'Coklat'
        ],
    );
    // echo $tanggal_lahir.'<br>';
    $hasil = $cm->sum_tanggal_lahir($tanggal_lahir);
    echo $hasil;

?>