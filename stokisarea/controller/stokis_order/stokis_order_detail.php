<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisDepositDetail.php';

    $obj = new classStokisDepositDetail();

    if(!isset($_POST['id_deposit'])){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    $id_deposit = addslashes(strip_tags($_POST['id_deposit']));
    
    $detail = $obj->index($id_deposit);
    $html = '';
    $no = 0;
    while($row = $detail->fetch_object()){
        $no++;
        $html .= '<tr>
                    <td class="text-center">'.$no.'</td>
                    <td class="text-center">'.$row->sku.'</td>
                    <td class="text-left">'.$row->nama_produk_detail.'</td>
                    <td class="text-center">'.$row->total_produk.' '.$row->satuan.'</td>
                    <td class="text-right">'.currency($row->harga).'</td>
                    <td class="text-right">'.currency($row->qty).'</td>
                    <td class="text-right">'.currency($row->jumlah).'</td>
                </tr>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    return true;