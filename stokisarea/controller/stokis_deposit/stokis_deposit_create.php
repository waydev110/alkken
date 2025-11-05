<?php    
    require_once '../../../helper/all.php';
    require_once '../../../model/classStokisDepositCart.php';
    require_once '../../../model/classStokisDeposit.php';
    require_once '../../../model/classStokisMember.php';
    require_once '../../../model/classStokisPaket.php';
    require_once '../../../model/classStokisDepositDetail.php';
    require_once '../../../model/classSMS.php';
    
    $ccart = new classStokisDepositCart();
    $obj = new classStokisDeposit();
    $cdd = new classStokisDepositDetail();
    $cps = new classStokisPaket();
    $csms = new classSMS();
    
    $stokis_id= $_SESSION['session_stokis_id'];
    $id_paket_stokis = $_SESSION['session_paket_stokis'];
    if(!isset($_POST['id_stokis'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $created_at = date('Y-m-d H:i:s');
    $id_stokis_tujuan = addslashes(strip_tags($_POST['id_stokis']));
    $subtotal  = $ccart->total_order($stokis_id, $id_stokis_tujuan);
    $diskon = $ccart->total_diskon($stokis_id, $id_stokis_tujuan);
    $total_bayar = $subtotal - $diskon;
    $total_cart = $ccart->total_cart($stokis_id, $id_stokis_tujuan);
    $status = 0;
    $keterangan = 'Deposit Order Stokis';

    if($total_cart == 0){
        echo json_encode(['status' => false, 'message' => 'Deposit harus lebih dari 0.']);
        return false;
    }
    $obj->set_id_stokis($stokis_id);
    $obj->set_subtotal($subtotal);
    $obj->set_diskon($diskon);
    $obj->set_nominal($total_bayar);
    $obj->set_status($status);
    $obj->set_id_stokis_tujuan($id_stokis_tujuan);
    $obj->set_keterangan($keterangan);
    $obj->set_created_at($created_at);
    $create = $obj->create();

    if(!$create){
        echo json_encode(['status' => false, 'message' => 'Deposit gagal.']);
        return false;
    }
    $paket_stokis = $cps->show($id_paket_stokis);
    if(!$paket_stokis){
        $persentase_fee = 0;
    }
    $create_detail = $cdd->create($stokis_id, $id_stokis_tujuan, $create, $created_at);
    if(!$create_detail){
        $obj->delete($create);
        echo json_encode(['status' => false, 'message' => 'Detail Deposit gagal.']);
        return false;
    }
    $ccart->set_id_stokis($stokis_id);
    $ccart->set_id_stokis_tujuan($id_stokis_tujuan);
    $ccart->set_status(1);
    $update_status = $ccart->update_status();

    $message = '<h3 class="my-0">Deposit order telah berhasil dibuat.</h3>
                <br>
                <table class="table table-hover table-bordered">
                    <tr>
                        <th>Subtotal</th>
                        <th width="100">'.rp($subtotal).'</th>
                    </tr>
                    <tr>
                        <th>Diskon</th>
                        <th>'.rp($diskon).'</th>
                    </tr>
                    <tr>
                        <th>Total Bayar</th>
                        <th>'.rp($total_bayar).'</th>
                    </tr>
                </table>';
    echo json_encode(['status' => true, 'id_deposit' => $create, 'message' => $message, 'subtotal' => rp($subtotal), 'diskon' => rp($diskon), 'total_bayar' => rp($total_bayar)]);
    $csms->smsDepositStokisNew($stokis_id, $create, $created_at);
    return true;