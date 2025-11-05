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
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Paket tidak ditemukan.']);
        return false;
    }


    $qty_paket = 0;
    if(isset($_POST['qty_paket']) && $_POST['qty_paket'] > 0){
        $qty_paket = number($_POST['qty_paket']);
    }
    if($qty_paket <= 0){
        echo json_encode(['status' => false, 'message' => 'Qty Paket minimal 1.']);
        return false;
    }

    //cek nilai produk plan
    $jenis_plan = $plan->jenis_plan;
    $nilai_produk = $plan->nilai_produk*$qty_paket;
    $total_nilai_produk = $obj->total_nilai_produk($id_member, $id_stokis, $id_plan);

    if($nilai_produk > $total_nilai_produk){
        $selisih = $nilai_produk - $total_nilai_produk;
        echo json_encode(['status' => false, 'nilai_produk' => $nilai_produk, 'total_nilai_produk' => $total_nilai_produk, 'message' => 'Produk Kurang. Minimal Qty '.currency($nilai_produk).'. Tambahkan '.currency($selisih).' lagi']);        
        return true;
    } else if($nilai_produk < $total_nilai_produk){
        $selisih = $total_nilai_produk - $nilai_produk;
        echo json_encode(['status' => false, 'nilai_produk' => $nilai_produk, 'total_nilai_produk' => $total_nilai_produk, 'message' => 'Produk Lebih. Maksimal Qty '.currency($nilai_produk).'. Kurangi '.currency($selisih).'.']);   
        return true;
    }
    echo json_encode(['status' => true]);
    return true;