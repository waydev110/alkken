<?php
if(isset($_POST['nominal']) && isset($_POST['rekening']) && isset($_POST['kode_unik']) && isset($_POST['total_bayar'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classTopupSaldo.php';
    $obj = new classTopupSaldo();
    require_once '../../../model/classRekening.php';
    $cr = new classRekening();
    
    $id_member = $session_member_id;
    $nominal = number($_POST['nominal']);
    $kode_unik = number($_POST['kode_unik']);
    $total_bayar = number($_POST['total_bayar']);
    $id_rekening = addslashes(strip_tags($_POST['rekening']));
    $created_at = date('Y-m-d H:i:s');
    $rekening = $cr->show($id_rekening);
    if($nominal < 0){
        echo json_encode(['status' => false, 'html' => 'Nominal Topup minimal Rp'.rp($nominal)]);
        return false;
    }
    $obj->set_nominal($nominal);
    $obj->set_kode_unik($kode_unik);
    $obj->set_total_bayar($total_bayar);
    $obj->set_status('0');
    $obj->set_bank_transfer($id_rekening);
    $obj->set_id_member($id_member);
    $obj->set_created_at($created_at);
    
    $create = $obj->create();
    if(!$create){
        echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        return false;
    }
    $message = '<p class="text-center text-muted mb-2 size-18">Permintaan Top Up Berhasil</p>
                <p class="text-center text-muted mb-2 size-12">Permintaan topup berhasil telah dikirimkan. Anda akan diberitahu jika prosesnya berhasil. Terima Kasih.</p>
                <h6 class="text-center mb-2">Jumlah Top Up</h6>
                <h6 class="text-center mb-2">'.rp($nominal).'</h6>';
    echo json_encode(['status' => true, 'message' => $message]);
    return true;
}