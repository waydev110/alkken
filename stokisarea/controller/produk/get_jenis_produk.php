<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../model/classProduk.php';

    $obj = new classProduk();

    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $html = '<option value="">Semua Produk</option>';
    $get_jenis_produk = $obj->get_jenis_produk($id_plan);
    if($get_jenis_produk->num_rows > 0){
        while ($row = $get_jenis_produk->fetch_object()) {
            $html .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
    }

    echo json_encode(['status' => true, 'html' => $html]);
    return true;