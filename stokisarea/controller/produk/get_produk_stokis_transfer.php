<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisProduk.php';

    $obj = new classStokisProduk();

    $keyword = '';
    if(isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }

    $get_produk = $obj->index_transfer($id_stokis, $keyword);
    include 'card_produk.php';
    echo json_encode(['status' => true, 'html' => $html]);
    return true;