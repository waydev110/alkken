<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classStokisJualPinCart.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classPlan.php';

    $cm = new classMember();
    $obj = new classStokisJualPinCart();
    $csp = new classStokisProduk();
    $cpl = new classPlan();

    if(!isset($_POST['id_member'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_member = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$id_member){
        echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan.']);
        return false;
    }
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $plan = $cpl->show($id_plan);
    $html = '';
    $diskon = 0;
    $subtotal = 0;
    $total = 0;
    if($plan){    
        $get_cart = $obj->get_cart($id_member, $id_stokis, $id_plan);
        include 'card.php';
        $total = $subtotal-$diskon;
    }
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => currency($diskon), 'total_nilai_produk' => decimal($total_nilai_produk), 'total' => rp($total)]);
    return true;