<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classUndianKupon.php';
    require_once '../../../model/classUndianPemenang.php';
    require_once '../../../model/classMember.php';
    $cuk = new classUndianKupon();
    $obj = new classUndianPemenang();
    $cm = new classMember();

    
    $kupon_id = $_POST['kupon_id'];
    $periode = $_POST['periode'];
    $data_kupon = $cuk->show($kupon_id);
    if($data_kupon){
        $id_member = $data_kupon->id_member;
        $jenis_kupon = $data_kupon->jenis_kupon;
        $doorprize = $data_kupon->doorprize;
        $periode = $periode;
        $status_transfer = '0';
        $created_at = date('Y-m-d H:i:s');

        $obj->set_id_member($id_member);
        $obj->set_kupon_id($kupon_id);
        $obj->set_jenis_kupon($jenis_kupon);
        $obj->set_periode($periode);
        $obj->set_doorprize($doorprize);
        $obj->set_status_transfer($status_transfer);
        $obj->set_created_at($created_at);
        
        $create = $obj->create();
            
    
        if($create){
            $cuk->update($kupon_id, $created_at);
            $member = $cm->detail($id_member);
            $kupon = '<div class="pemenang-undian">'.$kupon_id.'</div>';
            $pemenang = '<h2 class="fw-bold">'.$member->id_member.'</h2>
                        <h2 class="fw-bold">'.strtoupper($member->nama_samaran).'</h2>    
            ';
            echo json_encode(['status' => true, 'kupon_id' => $kupon, 'pemenang' => $pemenang]);
        }else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan pemenang.']);
        }
    } else {
        echo json_encode(['status' => false, 'message' => 'Pemenang sudah tersimpan.']);
    }