<?php
if(isset($_POST['id_provinsi'])){
    require_once '../../../model/classKota.php';
    $c = new classKota();
    
    $id_provinsi = addslashes(strip_tags($_POST['id_provinsi']));
    $result = $c->get_kota($id_provinsi);

    $option = '<option value="">Pilih Kab/Kota</option>';
    while($row = $result->fetch_object()){
        $option .= '<option value="' . $row->id . '">'.$row->nama_kota.'</option>';
    }
    echo $option;
}