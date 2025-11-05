<?php
    require_once '../../../helper/all.php';
    require_once '../../../model/classUndianPemenang.php';
    $obj = new classUndianPemenang();

    
    $jenis_kupon = $_POST['jenis_kupon'];
    $periode = $_POST['periode'];
    $data_pemenang = $obj->show_pemenang($jenis_kupon, $periode);        

    if($data_pemenang->num_rows > 0){
        $kupon = '';
        while ($row = $data_pemenang->fetch_object()) {
            $kupon .= '<div class="pemenang-undian">'.$row->kupon_id.'</div>';
        }
        echo json_encode(['status' => true, 'list_pemenang' => $kupon]);
    }else {
        echo json_encode(['status' => false, 'list_pemenang' => '']);
    }