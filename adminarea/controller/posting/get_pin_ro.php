<?php
require_once '../../../helper/all.php';
require_once '../../../model/classKodeAktivasi.php';

if(!isset($_POST['member_id'])) {
    echo '<option value="">-- Data tidak valid --</option>';
    exit;
}

$member_id = number($_POST['member_id']);

$cka = new classKodeAktivasi();

// Query to get RO PINs - jenis_plan = 1 (RO), status_aktivasi = 0 (available)
$sql = "SELECT a.id, 
            a.kode_aktivasi,
            pl.nama_plan,
            a.harga
        FROM mlm_kodeaktivasi a
        LEFT JOIN mlm_plan pl ON a.jenis_aktivasi = pl.id
        WHERE a.id_member = '$member_id'
        AND pl.jenis_plan >= 1
        AND a.status_aktivasi = '0'
        AND a.deleted_at IS NULL
        ORDER BY a.created_at DESC";

$c = new classConnection();
$pins = $c->_query($sql);

if($pins && $pins->num_rows > 0) {
    echo '<option value="">-- Pilih PIN RO --</option>';
    while($pin = $pins->fetch_object()) {
        $info = $pin->nama_plan . ' (' . rp($pin->harga) . ')';
        echo '<option value="' . $pin->id . '">' . $pin->kode_aktivasi . ' - ' . $info . '</option>';
    }
} else {
    echo '<option value="">-- Tidak ada PIN RO tersedia --</option>';
}
