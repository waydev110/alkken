<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisJualPinDetail.php';

    $obj = new classStokisJualPinDetail();

    if(!isset($_POST['id_jual_pin'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_jual_pin = addslashes(strip_tags($_POST['id_jual_pin']));
    
    $detail = $obj->index($id_jual_pin);
    $html = '';
    $no = 0;
    while($row = $detail->fetch_object()){
        $no++;
        $html .= '<tr>
                    <td class="text-center">'.$no.'</td>
                    <td class="text-left">'.$row->nama_produk.'</td>
                    <td class="text-center">'.$row->nama_plan.'</td>
                    <td class="text-right">'.currency($row->fee_stokis / $row->qty).'</td>
                    <td class="text-right">'.currency($row->qty).'</td>
                    <td class="text-right">'.currency($row->fee_stokis).'</td>
                </tr>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    return true;