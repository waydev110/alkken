<?php
    session_start();
    $id_stokis = $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classMember.php';
    require_once '../../../model/classStokisJualPinCart.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classProduk.php';
    require_once '../../../model/classPlan.php';

    $cm = new classMember();
    $obj = new classStokisJualPinCart();
    $csp = new classStokisProduk();
    $cp = new classProduk();
    $cpl = new classPlan();

    if(!isset($_POST['id_produk'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_produk = addslashes(strip_tags($_POST['id_produk']));
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $plan = $cpl->show($id_plan);
    if(!$plan){
        echo json_encode(['status' => false, 'message' => 'Silahkan memilih paket terlebih dahulu.']);
        return false;
    }
    $member_id = $cm->show_id(addslashes(strip_tags($_POST['id_member'])));
    if(!$member_id){
        echo json_encode(['status' => false, 'message' => 'Member tidak ditemukan.']);
        return false;
    }
    // $jenis_produk = $cp->detail($id_produk);
    // $cek_jenis_produk = $obj->cek_jenis_produk($member_id, $jenis_produk->id_produk_jenis);
    // if($cek_jenis_produk > 0){
    //     echo json_encode(['status' => false, 'message' => 'Tambahkan hanya jenis produk yang sama. Tidak boleh menambahkan jenis produk berbeda. ']);
    //     return false;
    // }
    $qty = number($_POST['qty']);
    $created_at = date('Y-m-d H:i:s');

    $keranjang = $obj->keranjang($member_id, $id_produk);
    $stok_produk = $csp->stok_produk($id_stokis, $id_produk);
    if($keranjang->num_rows == 0){
        if($stok_produk >= $qty){
            $created_at = date('Y-m-d H:i:s');
            $obj->set_id_stokis($id_stokis);
            $obj->set_id_member($member_id);
            $obj->set_id_produk($id_produk);
            $obj->set_qty($qty);
            $obj->set_status(0);
            $obj->set_created_at($created_at);
        
            $create = $obj->create();
            if(!$create){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal menambahkan ke keranjang.']);
                return false;
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Stok Produk Kurang.']);
            return false;
        }
    
    } else {
        $total_qty = $keranjang->fetch_object()->qty + $qty;
        if($stok_produk >= $total_qty){
            $updated_at = date('Y-m-d H:i:s');
            $obj->set_id_member($member_id);
            $obj->set_id_produk($id_produk);
            $obj->set_qty($qty);
            $obj->set_updated_at($updated_at);
            $update = $obj->update();
            if(!$update){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan. Gagal mengupdate keranjang.']);
                return false;
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Stok Produk Kurang.']);
            return false;
        }
    }
    
    $get_cart = $obj->get_cart($member_id, $id_stokis, $id_plan);
    include 'card.php';
    $total = $subtotal-$diskon;
    echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => currency($diskon), 'total_nilai_produk' => decimal($total_nilai_produk), 'total' => rp($total)]);
    return true;