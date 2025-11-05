<?php   
session_start();
require_once '../../../helper/all_member.php'; 
require_once '../../../model/classMember.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classCartAutosave.php';
require_once '../../../model/classPlan.php';
require_once '../../../model/classWallet.php';

$cm = new classMember();
$cp = new classProduk();
$cc = new classCartAutosave();
$cpl = new classPlan();
$cw = new classWallet();
$sisa_saldo = $cw->saldo($session_member_id, 'poin');

$total_harga = $cc->total_harga($session_member_id);
if($total_harga > $sisa_saldo){
    echo json_encode(['status' => false, 'message' => 'Saldo tidak cukup. Silahkan Topup Saldo terlebih dahulu.']);
    return true;
}
$plan = $cpl->show(99);

$harga_autosave = $plan->harga;

if($total_harga < $harga_autosave){

    echo json_encode(['status' => false, 'message' => 'Belum memenuhi syarat minimal klaim. Minimal Klaim '.rp($harga_autosave).'.']);
    return true;

}

echo json_encode(['status' => true, 'total_harga' => rp($total_harga)]);
return true;

?>