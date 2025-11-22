<?php
require_once '../../../helper/all.php';
require_once '../../../model/classKodeAktivasi.php';
require_once '../../../model/classConnection.php';

$sponsor_id = isset($_POST['sponsor_id']) ? number($_POST['sponsor_id']) : 0;
$paket_id = isset($_POST['paket_id']) ? number($_POST['paket_id']) : 0;

if(!$sponsor_id || !$paket_id) {
    echo '<option value="">Data tidak valid</option>';
    exit;
}

$conn = new classConnection();

// Get all available PINs for sponsor and paket
$sql = "SELECT ka.id, ka.kode_aktivasi, ka.harga, p.nama_plan
        FROM mlm_kodeaktivasi ka
        LEFT JOIN mlm_plan p ON ka.jenis_aktivasi = p.id
        WHERE ka.id_member = '$sponsor_id'
        AND ka.jenis_aktivasi = '$paket_id'
        AND ka.status_aktivasi = '0'
        AND ka.deleted_at IS NULL
        ORDER BY ka.id ASC";

$result = $conn->_query($sql);

$options = '<option value="">-- Pilih Kode Aktivasi --</option>';

if($result && $result->num_rows > 0) {
    while($row = $result->fetch_object()) {
        $options .= '<option value="' . $row->id . '">';
        $options .= $row->kode_aktivasi . ' - ' . $row->nama_plan;
        $options .= ' (' . rp($row->harga) . ')';
        $options .= '</option>';
    }
} else {
    $options = '<option value="">Tidak ada kode aktivasi tersedia</option>';
}

echo $options;
?>
