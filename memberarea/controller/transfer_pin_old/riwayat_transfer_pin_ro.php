<?php
if(isset($_POST['bulan']) && isset($_POST['jenis'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classKodeAktivasiRo.php';
    $cka = new classKodeAktivasiRo();
    
    $bulan = addslashes(strip_tags($_POST['bulan']));
    $jenis = addslashes(strip_tags($_POST['jenis']));
    $id_member = $session_member_id;

    if($jenis == 'terima'){
        $result = $cka->riwayat_terima($id_member, $bulan);
    } else if($jenis == 'kirim') {
        $result = $cka->riwayat_kirim($id_member, $bulan);
    } else {
        echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']);
        return false;
    }
    $total_terima = $cka->total_terima($id_member, $bulan);
    $total_kirim = $cka->total_kirim($id_member, $bulan);
    $total_pin_terima = $cka->total_pin_terima($id_member, $bulan).' PIN';
    $total_pin_kirim = $cka->total_pin_kirim($id_member, $bulan).' PIN';

    if($result){
        if($result->num_rows > 0){
            $html = '';
            while($row = $result->fetch_object()){
                $html .= '<div class="card mx-2 mt-2 shadow-none rounded-0">
                            <div class="card-body pb-0" data-bs-toggle="collapse" href="#detail'.$row->id.'"
                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                <div class="row">
                                    <div class="col-auto pe-2">
                                        '.vicon_pengirim($row->idpengirim).'
                                    </div>
                                    <div class="col text-end">
                                        <p class="mb-4 size-11">'.tgl_indo_full($row->tanggal).'</p>
                                    </div>
                                </div>                       
                                <div class="row d-block">
                                    <div class="col-12 text-end">
                                        <div class="collapse block-detail" id="detail'.$row->id.'">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-auto px-0 text-start" style="width:90px">
                                                            <p class="size-12">PENGIRIM</p>        
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="size-12">:</p>    
                                                        </div>
                                                        <div class="col px-0 text-end">
                                                            <p class="size-12">
                                                                '.strtoupper($row->pengirim).'
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-auto px-0 text-start" style="width:90px">
                                                            <p class="size-12">HARGA</p>        
                                                        </div>
                                                        <div class="col-auto">
                                                            <p class="size-12">:</p>    
                                                        </div>
                                                        <div class="col px-0 text-end">
                                                            <p class="size-12">
                                                                '.rp($row->harga).'
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
        } else {
            $html = '<div class="card mx-2 mt-2 shadow-none rounded-0">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col">
                                    <p class="text-muted text-center"><i class="fa-light fa-box-open fa-8x"></i></p>                            
                                    <h6 class="text-center fw-normal">Tidak ada riwayat.</h6>
                                </div>
                            </div>
                        </div>
                    </div>';

        }
    
        $first_date = date("Y-m-d", strtotime($bulan.'-01'));
        $last_date = date("Y-m-t", strtotime($first_date));

        $statement_tgl = tgl_bulan($first_date).' - '.tgl_indo($last_date);

        $statement_bulan = bulan(date('Y-m-d', strtotime($first_date)));

        echo json_encode([
                            'status' => true, 
                            'statement_tgl' => $statement_tgl, 
                            'statement_bulan' => $statement_bulan, 
                            'total_terima' => currency($total_terima), 
                            'total_kirim' => currency($total_kirim), 
                            'total_pin_terima' => $total_pin_terima, 
                            'total_pin_kirim' => $total_pin_kirim, 
                            'html' => $html]);
        return true;
    } else {
        echo json_encode(['status' => false, 'message' => 'Error.']);
        return false;
    }
} else {
    echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']);
    return false;
}