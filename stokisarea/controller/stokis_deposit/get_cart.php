<?php
require_once '../../../helper/all.php';
require_once '../../../model/classStokisDepositCart.php';
require_once '../../../model/classStokisPaket.php';

$obj = new classStokisDepositCart();
$csp = new classStokisPaket();

$id_stokis = $_SESSION['session_stokis_id'];
$id_paket_stokis = $_SESSION['session_paket_stokis'];

if (!isset($_POST['id_stokis'])) {
    echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
    return false;
}
$id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
$persentase_fee = 0;
$paket_stokis = $csp->show($id_paket_stokis);
if ($paket_stokis) {
    $persentase_fee = $paket_stokis->persentase_fee;
}

$get_cart = $obj->get_cart($id_stokis, $id_stokis_tujuan);
include 'card.php';
$total = $subtotal - $diskon;
echo json_encode(['status' => true, 'html' => $html, 'subtotal' => rp($subtotal), 'diskon' => rp($diskon), 'total' => rp($total)]);
return true;
