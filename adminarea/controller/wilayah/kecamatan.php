<?php
if(isset($_POST['id_kota'])){
    require_once '../../../model/classKecamatan.php';
    $c = new classKecamatan();
    
    $id_kota = addslashes(strip_tags($_POST['id_kota']));
    $result = $c->get_kecamatan($id_kota);

    $option = '<option value="">Pilih Kecamatan</option>';
    while($row = $result->fetch_object()){
        $option .= '<option value="' . $row->id . '">'.$row->nama_kecamatan.'</option>';
    }
    echo $option;
}