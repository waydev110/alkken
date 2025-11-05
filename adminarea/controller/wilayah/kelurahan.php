<?php
if(isset($_POST['id_kecamatan'])){
    require_once '../../../model/classKelurahan.php';
    $c = new classKelurahan();
    
    $id_kecamatan = addslashes(strip_tags($_POST['id_kecamatan']));
    $result = $c->get_kelurahan($id_kecamatan);

    $option = '<option value="">Pilih Kelurahan</option>';
    while($row = $result->fetch_object()){
        $option .= '<option value="' . $row->id . '">'.$row->nama_kelurahan.'</option>';
    }
    echo $option;
}