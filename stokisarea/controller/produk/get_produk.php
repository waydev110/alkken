<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classProduk.php';

    $obj = new classProduk();

    $keyword = '';
    if(isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }
    $jenis_produk = '';
    if(isset($_POST['jenis_produk'])){
        $jenis_produk = $_POST['jenis_produk'];
    }
    $get_produk = $obj->get_produk($jenis_produk, $keyword);
    include 'card_produk.php';
    echo json_encode(['status' => true, 'html' => $html]);
    return true;