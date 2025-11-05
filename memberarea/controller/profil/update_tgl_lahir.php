<?php
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    require_once '../../../model/classMember.php';
    
    $cm = new classMember();

    $nama_samaran = addslashes(strip_tags($_POST['nama_samaran']));
    $tempat_lahir = capital_word(addslashes(strip_tags($_POST['tempat_lahir'])));
    $tanggal_lahir = post_date($_POST['tanggal_lahir']);
    // $tgl_lahir_member = $tahun.'-'.$bulan.'-'.$tanggal;
    $tgl_lahir_member = $tanggal_lahir;
    $tahun_lahir = date('Y', strtotime($tgl_lahir_member));
    if($tahun_lahir == '2000'){
        $tgl_lahir_elemen = $tahun_lahir.'-'. date('m-d', strtotime($tgl_lahir_member));
    } else {
        $tgl_lahir_elemen = $tgl_lahir_member;
    }
    $angka_elemen = $cm->sum_tanggal_lahir($tgl_lahir_elemen);
    
    $cm->set_nama_samaran($nama_samaran);
    $cm->set_tempat_lahir_member($tempat_lahir);
    $cm->set_tgl_lahir_member($tanggal_lahir);
    $cm->set_angka_elemen($angka_elemen);

    $result = $cm->update($session_member_id);
    
    if($result){
        $_SESSION['profile_updated'] = '1';
        echo true;
    }else{
        echo "false";
    }
} else {
    echo "no token";
}