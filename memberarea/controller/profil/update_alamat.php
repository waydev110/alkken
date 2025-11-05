<?php
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();

    $id = $session_member_id;
    $id_provinsi = addslashes(strip_tags($_POST['provinsi']));
    $id_kota = addslashes(strip_tags($_POST['kota']));
    $id_kecamatan = addslashes(strip_tags($_POST['kecamatan']));
    $id_kelurahan = addslashes(strip_tags($_POST['kelurahan']));
    // $rtrw = addslashes(strip_tags($_POST['rtrw']));
    $alamat_member = addslashes(strip_tags($_POST['alamat_member']));
    // $kodepos = addslashes(strip_tags($_POST['kodepos']));
    // $cm->set_rtrw($rtrw);
    $cm->set_id_provinsi($id_provinsi);
    $cm->set_id_kota($id_kota);
    $cm->set_id_kecamatan($id_kecamatan);
    $cm->set_id_kelurahan($id_kelurahan);
    $cm->set_alamat_member($alamat_member);
    // $cm->set_kodepos_member($kodepos);

    $result = $cm->update($id);
    
    if($result == true){
        echo true;
    }else{
        echo "false";
    }
} else {
    echo "no token";
}