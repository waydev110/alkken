<?php 
    require_once '../../../model/classMember.php';
    require_once '../../../model/classMemberReedem.php';
    require_once '../../../model/classMemberReedemDetail.php';

    $cm = new classMember();
    $obj = new classMemberReedem();
    $cmod = new classMemberReedemDetail();

    $id_member = base64_decode($_POST['id_member']);
    $qty = addslashes(strip_tags($_POST['qty']));
    $nominal = addslashes(strip_tags($_POST['nominal']));

    $cek_order = $obj->cek_order($id_member);
    if($cek_order){
        $id = $cek_order->id;
        $update = $obj->update_order($id, $id_member, $qty, $nominal);
        if($update){
            $update_detail = $cmod->update_order_detail($id, $qty, $nominal);
            if($update_detail){
                echo json_encode(['status' => true, 'message' => 'Order berhasi di update.']);
                return true;
            } else {
                echo json_encode(['status' => false, 'message' => 'Order Detail gagal di update.']);
                return true;
            }
        } else {
            echo json_encode(['status' => true, 'message' => 'Order gagal di update.']);
            return true;
        }
    } else {
        $member = $cm->detail($id_member);
        $created_at = date('Y-m-d H:i:s');
        $obj->set_id_member($id_member);
        $obj->set_qty($qty);
        $obj->set_nominal($nominal);
        $obj->set_status(0);
        $obj->set_id_provinsi($member->id_provinsi);
        $obj->set_id_kota($member->id_kota);
        $obj->set_id_kecamatan($member->id_kecamatan);
        $obj->set_id_kelurahan($member->id_kelurahan);
        $obj->set_alamat_kirim($member->alamat_member);
        $obj->set_kodepos($member->kodepos_member);
        $obj->set_keterangan('Order by Transfer PIN');
        $obj->set_created_at($created_at);
        $create = $obj->create();
        if($create > 0){
            $cmod->create_detail($create, $qty, $nominal, $created_at);
            echo json_encode(['status' => true, 'message' => 'Order berhasi dibuat.']);
            return true;
        } else {
            echo json_encode(['status' => true, 'message' => 'Order gagal dibuat.']);
            return true;
        }
    }
?>