<?php
if(isset($_POST['arr_plan'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    
    $id_member = $session_member_id;
    $arr_plan = $_POST['arr_plan'];
    $arr_jenis = $_POST['arr_jenis'];
    $arr_reposisi = $_POST['arr_reposisi'];
    $arr_founder = $_POST['arr_founder'];
    $arr_qty = $_POST['qty'];

    $filter = [];
    $html = '';
    $no = 0;
    $total = 0;
    foreach ($arr_plan as $key => $id_plan) {
        $jenis_produk = $arr_jenis[$key];
        $reposisi = $arr_reposisi[$key];
        $founder = $arr_founder[$key];

        $qty = $arr_qty[$key];
        if($qty > 0){
            $result = $cka->index_group($id_member, $id_plan, $jenis_produk, $reposisi, $founder);
            $reposisi_label = $reposisi == '1' ? 'Reposisi' : '';
            $founder_label = $founder == '1' ? 'Founder' : '';
            $pin_label = $lang['kode_aktivasi'].' '.$reposisi_label.' '.$founder_label;
            if(!$result){
                echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
                return false;
            }
            $row = $result->fetch_object();
            if($row->total < $qty){
                echo json_encode(['status' => false, 'message' => $pin_label.' '.$row->nama_plan.' '.$row->name.' maksimal '.$row->total.'.']);
                return false;
            }
            $no++;
            $total = $total + ($row->harga*$qty);
            $html .='<div class="row border-bottom py-3 data-item">
                        <div class="col-auto align-self-center">
                            <h4 class="mb-1 size-18">'.$no.'.</h4>
                        </div>
                        <div class="col align-self-center ps-0">
                            <h4 class="mb-1 size-11">'.$pin_label.'</h4><h4 class="size-18">'.$row->nama_plan.' '.$row->name.'</h4>
                        </div>
                        <div class="col-auto align-self-center text-end">
                            <p class="size-11">Jumlah</p>
                            <h4 class="size-18">'.currency($qty).'</h4>
                        </div>
                    </div>';
        }
    }
    if($html == ''){
        echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
        return false;
    }
    // $html .= '<div class="row py-3 bg-theme">
    //             <div class="col align-self-center">
    //                 <div class="row">
    //                     <div class="col">
    //                         <h4 class="mb-1 size-18 ">TOTAL</h4>
    //                     </div>
    //                     <div class="col-auto d-flex flex-wrap align-self-center w-auto">
    //                         <h4 class="size-18">'.rp($total).'</h4>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>';
    echo json_encode(['status' => true, 'html' => $html]);
    return true;
}
echo json_encode(['status' => false, 'message' => 'Terjadi Kesalahan.']);
return false;