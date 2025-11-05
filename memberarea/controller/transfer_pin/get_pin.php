<?php
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classKodeAktivasi.php';
    $cka = new classKodeAktivasi();
    
    $id_member = $session_member_id;
    $result = $cka->index_group($id_member);

    if($result){
        $html = '';
        $no = 0;
        while($row = $result->fetch_object()){
            $no++;
            $reposisi = $row->reposisi == '1' ? 'Reposisi' : '';
            $founder = $row->founder == '1' ? 'Founder' : '';
            $pin_label = $lang['kode_aktivasi'].' '.$reposisi.' '.$founder;
            $html .='<label class="row border-bottom py-3 data-item" for="kode_aktivasi['.$no.']">
                        <div class="col align-self-center">
                            <div class="row">
                                <div class="col">
                                    <h4 class="mb-1 size-12">'.$pin_label.'</h4><h4 class="size-14">'.$row->nama_plan.' '.$row->name.'</h4>';
                                $html .='</div>
                                <div class="col-auto ps-0 text-end">
                                    <h6 class="mb-1 size-11">Jumlah (Maks '.$row->total.')</h6>
                                    <div class="input-group mt-2">
                                        <button type="button" class="btn btn-sm rounded-circle btn-default" onclick="kurang('.$no.')"><i
                                                class="fa-solid fa-minus"></i></button>
                                        <input type="number" name="qty['.$no.']" id="qty'.$no.'" value="0"
                                            class="form-control w-70 rounded-pill size-14 py-0 text-center">
                                        <button type="button" class="btn btn-sm rounded-circle btn-default"
                                            onclick="tambah('.$no.')"><i
                                                class="fa-solid fa-plus"></i></button>
                                    </div>
                                    <input type="hidden" id="arr_plan['.$no.']" name="arr_plan['.$no.']" value="'.$row->id.'">
                                    <input type="hidden" id="arr_jenis['.$no.']" name="arr_jenis['.$no.']" value="'.$row->jenis_produk.'">
                                    <input type="hidden" id="arr_reposisi['.$no.']" name="arr_reposisi['.$no.']" value="'.$row->reposisi.'">
                                    <input type="hidden" id="arr_founder['.$no.']" name="arr_founder['.$no.']" value="'.$row->founder.'">
                                </div>
                            </div>
                        </div>
                    </label>';
        }
        echo json_encode(['status' => true, 'html' => $html]);
    } else {
        echo json_encode(['status' => false]);
    }