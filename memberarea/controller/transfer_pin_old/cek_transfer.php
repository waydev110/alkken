<?php
if(isset($_POST['kode_aktivasi'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    
    $id_member = $session_member_id;
    $arr_kodeaktivasi = $_POST['kode_aktivasi'];

    $filter = [];
    foreach ($arr_kodeaktivasi as $key => $kode_aktivasi) {
        $filter[] = "k.kode_aktivasi = '$kode_aktivasi'";
    }
    $filter_kode_aktivasi = implode(' OR ', $filter);

    $result = $cka->cek_transfer($filter_kode_aktivasi, $id_member);

    if($result){
        $html = '';
        $no = 0;
        $total = 0;
        while($row = $result->fetch_object()){
            $no++;
            $total = $total + $row->harga;
            $html .='<div class="row border-bottom py-3 data-item">
                        <div class="col-auto align-self-center">
                            <h4 class="mb-1 size-18">'.$no.'.</h4>
                        </div>
                        <div class="col align-self-center ps-0">
                            <p class="size-11">'.$lang['kode_aktivasi'].' '.$row->nama_plan.'</p>
                            <h4 class="size-18">'.$row->kode_aktivasi.'</h4>
                        </div>
                        <div class="col-auto align-self-center text-end">
                            <h4 class="size-18">'.rp($row->harga).'</h4>
                        </div>
                    </div>';
        }
        $html .= '<div class="row py-3 bg-green-light">
                    <div class="col align-self-center">
                        <div class="row">
                            <div class="col">
                                <h4 class="mb-1 size-18">TOTAL</h4>
                            </div>
                            <div class="col-auto d-flex flex-wrap align-self-center w-auto">
                                <h4 class="size-18">'.rp($total).'</h4>
                            </div>
                        </div>
                    </div>
                </div>';
        echo json_encode(['status' => true, 'html' => $html]);
    } else {
        echo json_encode(['status' => false]);
    }
}