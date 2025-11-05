<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classMember.php';

    $cm = new classMember();
    $id = base64_decode(addslashes(strip_tags($_POST['id'])));
    $member = $cm->detail($id);
    $nama_member = capital_word(addslashes(strip_tags($_POST['nama_member'])));
    $nama_samaran = capital_word(addslashes(strip_tags($_POST['nama_samaran'])));
    $hp_member = number($_POST['hp_member']);
    // $tempat_lahir = capital_word(addslashes(strip_tags($_POST['tempat_lahir'])));
    // $tanggal_lahir = post_date($_POST['tanggal_lahir']);
    // $no_ktp_member = addslashes(strip_tags($_POST['nik']));
    $id_plan = addslashes(strip_tags($_POST['id_plan']));
    $id_produk_jenis = addslashes(strip_tags($_POST['id_produk_jenis']));
    $id_provinsi = addslashes(strip_tags($_POST['provinsi']));
    $id_kota = addslashes(strip_tags($_POST['kota']));
    $id_kecamatan = addslashes(strip_tags($_POST['kecamatan']));
    $id_kelurahan = addslashes(strip_tags($_POST['kelurahan']));
    // $rtrw = addslashes(strip_tags($_POST['rtrw']));
    $alamat_member = addslashes(strip_tags($_POST['alamat']));
    $kodepos = addslashes(strip_tags($_POST['kodepos']));
    $sponsor = addslashes(strip_tags($_POST['sponsor']));

    $id_bank = addslashes(strip_tags($_POST['id_bank']));
    $no_rekening = addslashes(strip_tags($_POST['no_rekening']));
    $cabang_rekening = addslashes(strip_tags($_POST['cabang_rekening']));
    $user_member = addslashes(strip_tags($_POST['user_member']));

    $group_akun = addslashes(strip_tags($_POST['group_akun']));

    $cm->set_nama_member($nama_member);
    $cm->set_nama_samaran($nama_samaran);
    $cm->set_hp_member($hp_member);
    $cm->set_user_member($user_member);
    $cm->set_group_akun($group_akun);
    // $cm->set_tempat_lahir_member($tempat_lahir);
    // $cm->set_tgl_lahir_member($tanggal_lahir);
    // $cm->set_no_ktp_member($no_ktp_member);
    // $cm->set_rtrw($rtrw);
    $cm->set_id_plan($id_plan);
    $cm->set_id_produk_jenis($id_produk_jenis);
    $cm->set_id_provinsi($id_provinsi);
    $cm->set_id_kota($id_kota);
    $cm->set_id_kecamatan($id_kecamatan);
    $cm->set_id_kelurahan($id_kelurahan);
    $cm->set_alamat_member($alamat_member);
    $cm->set_kodepos_member($kodepos);
    $cm->set_sponsor($sponsor);
    
    $cm->set_id_bank($id_bank);
    $cm->set_no_rekening($no_rekening);
    $cm->set_atas_nama_rekening($nama_member);
    $cm->set_cabang_rekening($cabang_rekening);

    $result = $cm->update($id);

    if($result == true){
        $_SESSION['profile_updated'] = '1';
        if($member->id_plan <> $id_plan){
            $created_at = date('Y-m-d H:i:s');
            $create_member_plan = $cm->create_member_plan($id, $member->id_plan, $id_plan, $created_at);
        }
        echo json_encode(['status' => true, 'message' => 'Edit data berhasil.']);
        return true;
    }else{
        echo json_encode(['status' => false, 'message' => 'Edit data gagal.']);
        return false;
    }