<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisTransferCart.php';

    $obj = new classStokisTransferCart();

    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
    
    $get_cart = $obj->get_cart($id_stokis, $id_stokis_tujuan);
    include 'card.php';
    $total = $subtotal - $fee_stokis;
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => rp($fee_stokis), 'total' => rp($total)]);
    return true;