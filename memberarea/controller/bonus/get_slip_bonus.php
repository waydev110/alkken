<?php
if(isset($_POST['bulan'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classBonus.php';  
    require_once '../../../model/classSetting.php';
    $obj = new classBonus();
    $s = new classSetting();
    
    $tahun = addslashes(strip_tags($_POST['tahun']));
    $bulan = addslashes(strip_tags($_POST['bulan']));
    $periode = $tahun.'-'.$bulan;
    $id_member = $session_member_id;

    $result = $obj->slip_bonus($id_member, $tahun, $bulan);

    if($result){
        if($result->num_rows > 0){
            if(!empty($tahun) && !empty($bulan) ){
                $html = '<p class="size-24 fw-bold text-center mb-2">STATEMENT BONUS BULAN '.strtoupper($bulan).' TAHUN '.$tahun.'</p>';
            } else if(!empty($tahun)) {
                $html = '<p class="size-24 fw-bold text-center mb-2">STATEMENT BONUS TAHUN '.$tahun.'</p>';
            } else if(!empty($bulan)){
                $html = '<p class="size-24 fw-bold text-center mb-2">STATEMENT BONUS BULAN '.strtoupper(bulan($bulan)).'</p>';
            } else {
                $html = '<p class="size-24 fw-bold text-center mb-2">STATEMENT BONUS</p>';
            }
            $no = 0;
            $total = 0;
            while($row = $result->fetch_object()){
                $no++;
                $total += $row->jumlah;
                $html .= '<div class="row mb-1">
                            <div class="col-auto size-13 align-self-center pe-0" style="width:30px">
                                '.$no.'.
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-13">'.$lang[$row->type].'</p>
                            </div>
                            <div class="col-auto align-self-center text-end">
                                <p class="mb-0 size-13">'.rp($row->jumlah).'</p>
                            </div>
                        </div>';
            }
            $html .= '<hr class="mt-1 mb-1">
                        <div class="row mb-1">
                            <div class="col-auto size-13 align-self-center pe-0" style="width:30px">
                            </div>
                            <div class="col align-self-center">
                                <p class="mb-0 size-13 fw-bold">Total Bonus</p>
                            </div>
                            <div class="col-auto align-self-center text-end">
                                <p class="mb-0 size-13 fw-bold">'.rp($total).'</p>
                            </div>
                        </div>';
            $html .= '<p class="mt-4 mb-0 size-13">Tertanda Managemen <strong>'.$s->setting('site_pt').'</strong></p>
                      <p class="size-13 fst-italic">"Tingkatkan Penjualan anda agar penghasilan bulan depan meningkat"</p>';
        } else {
            $html = '<div class="card mx-2 mt-2 shadow-none rounded-0">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col">
                                    <p class="text-muted text-center"><i class="fa-light fa-analytics fa-8x"></i></p>                            
                                    <h6 class="text-center fw-normal">Tidak ada statement bonus.</h6>
                                </div>
                            </div>
                        </div>
                    </div>';

        }

        exit(json_encode(['status' => true, 'html' => $html]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']));
    }
}