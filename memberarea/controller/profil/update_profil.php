<?php
require_once '../../../helper/all_member.php';

if(cek_token() == true){
    require_once '../../../model/classMember.php';
    require_once '../../../model/classKodeAktivasi.php';
    
    $cm = new classMember();
    $cka = new classKodeAktivasi();

    $nama_member = capital_word(addslashes(strip_tags($_POST['nama_member'])));
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
    $no_ktp_member = addslashes(strip_tags($_POST['nik']));
    $id_provinsi = addslashes(strip_tags($_POST['provinsi']));
    $id_kota = addslashes(strip_tags($_POST['kota']));
    $id_kecamatan = addslashes(strip_tags($_POST['kecamatan']));
    $id_kelurahan = addslashes(strip_tags($_POST['kelurahan']));
    // $rtrw = addslashes(strip_tags($_POST['rtrw']));
    $alamat_member = addslashes(strip_tags($_POST['alamat_member']));
    // $kodepos = addslashes(strip_tags($_POST['kodepos']));
    
    $id_bank = addslashes(strip_tags($_POST['bank']));
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    $atas_nama_rekening = $nama_member;
    $cabang_rekening = addslashes(strip_tags($_POST['cabang_rekening']));
    $nama_samaran = addslashes(strip_tags($_POST['nama_samaran']));
    
    $cm->set_id_bank($id_bank);
    $cm->set_no_rekening($no_rekening);
    $cm->set_atas_nama_rekening($atas_nama_rekening);
    $cm->set_cabang_rekening($cabang_rekening);
    
    $cm->set_nama_member($nama_member);
    $cm->set_tempat_lahir_member($tempat_lahir);
    $cm->set_tgl_lahir_member($tanggal_lahir);
    $cm->set_no_ktp_member($no_ktp_member);
    // $cm->set_rtrw($rtrw);
    $cm->set_id_provinsi($id_provinsi);
    $cm->set_id_kota($id_kota);
    $cm->set_id_kecamatan($id_kecamatan);
    $cm->set_id_kelurahan($id_kelurahan);
    $cm->set_alamat_member($alamat_member);
    // $cm->set_kodepos_member($kodepos);
    $cm->set_nama_samaran($nama_samaran);
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