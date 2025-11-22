<?php
require_once '../../../helper/all.php';
require_once '../../../model/classMember.php';
require_once '../../../model/classConnection.php';

$sponsor_id = isset($_POST['sponsor_id']) ? number($_POST['sponsor_id']) : 0;

if(!$sponsor_id) {
    echo json_encode(['status' => false, 'message' => 'ID sponsor tidak valid']);
    exit;
}

$cm = new classMember();
$conn = new classConnection();
$sponsor = $cm->detail($sponsor_id);

if(!$sponsor) {
    echo json_encode(['status' => false, 'message' => 'Data sponsor tidak ditemukan']);
    exit;
}

// Hitung jumlah akun untuk generate username baru
$group_akun = $sponsor->group_akun ? $sponsor->group_akun : $sponsor->id_member;
$jumlah_akun = $cm->jumlah_akun($group_akun);
$new_username = $sponsor->user_member . $jumlah_akun;

echo json_encode([
    'status' => true,
    'data' => [
        'username' => $sponsor->user_member,
        'new_username' => $new_username,
        'nama_member' => $sponsor->nama_member ? $sponsor->nama_member : '',
        'hp_member' => $sponsor->hp_member ? $sponsor->hp_member : '',
        'email_member' => $sponsor->email_member ? $sponsor->email_member : '',
        'tempat_lahir' => $sponsor->tempat_lahir_member ? $sponsor->tempat_lahir_member : '',
        'tanggal_lahir' => $sponsor->tgl_lahir_member ? $sponsor->tgl_lahir_member : '',
        'id_bank' => $sponsor->id_bank ? $sponsor->id_bank : '',
        'no_rekening' => $sponsor->no_rekening ? $sponsor->no_rekening : '',
        'atas_nama_rekening' => $sponsor->atas_nama_rekening ? $sponsor->atas_nama_rekening : '',
        'id_provinsi' => $sponsor->id_provinsi ? $sponsor->id_provinsi : '',
        'id_kota' => $sponsor->id_kota ? $sponsor->id_kota : '',
        'id_kecamatan' => $sponsor->id_kecamatan ? $sponsor->id_kecamatan : '',
        'id_kelurahan' => $sponsor->id_kelurahan ? $sponsor->id_kelurahan : '',
        'jumlah_akun' => $jumlah_akun
    ]
]);
?>
