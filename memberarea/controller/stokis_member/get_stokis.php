<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisMember.php';

    $obj = new classStokisMember();

    $id_stokis = '';
    $id_kota = '';
    if(isset($_POST['id_stokis'])){
        $id_stokis = $_POST['id_stokis'];
    }
    if(isset($_POST['id_kota'])){
        $id_kota = $_POST['id_kota'];
    }
    $get_stokis = $obj->index($id_kota);
    $html = '<option>--Pilih Stokis--</option>';
    while($stokis = $get_stokis->fetch_object()){
        $html .= '<option value="'.$stokis->id.'">'.$stokis->nama_stokis.' ('.$stokis->id_stokis.')</option>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    return true;