<?php
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    
    $id_member = $session_member_id;
    $result = $cka->index($id_member);

    if($result){
        $html = '';
        while($row = $result->fetch_object()){
            $html .='<label class="row border-bottom py-3 data-item" for="kode_aktivasi['.$row->id.']">
                        <div class="col align-self-center">
                            <div class="row">
                                <div class="col">
                                    <h6 class="mb-1 size-10">'.$lang['kode_aktivasi'].' '.$row->nama_plan.'</h6>
                                    <h4 class="size-18">'.rp($row->harga).'</h4>
                                </div>
                                <div class="col-auto d-flex flex-wrap align-self-center w-auto">
                                    <input type="checkbox" id="kode_aktivasi['.$row->id.']" name="kode_aktivasi['.$row->id.']" value="'.$row->kode_aktivasi.'">
                                </div>
                            </div>
                        </div>
                    </label>';
        }
        echo json_encode(['status' => true, 'html' => $html]);
    } else {
        echo json_encode(['status' => false]);
    }