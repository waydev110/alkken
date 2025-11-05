<?php
if(isset($_POST['bulan'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classBonus.php';
    $obj = new classBonus();
    
    $bulan = addslashes(strip_tags($_POST['bulan']));
    $id_member = $session_member_id;

    $result = $obj->statement_penarikan($id_member, $bulan);

    if($result){
        if($result->num_rows > 0){
            $html = '';
            while($row = $result->fetch_object()){
                $html .= '<div class="card mx-2 mt-2 shadow-none rounded-0">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-auto pe-2">
                                        <div class="avatar avatar-30 border-theme text-'.color_type($row->type).' shadow-sm rounded-circle">
                                            '.icon_type($row->type).'
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <p class="mb-0 size-10">'.$lang[$row->type].'</p>
                                        <h6>'.currency($row->jumlah).'</h6>
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
                                    <p class="text-muted text-center"><i class="fa-solid fa-money-simple-from-bracket fa-8x"></i></p>                            
                                    <h6 class="text-center fw-normal">Tidak ada statement transfer.</h6>
                                </div>
                            </div>
                        </div>
                    </div>';

        }
        
        $total_bonus = currency($obj->jumlah_bonus($id_member, $bulan));
        $total_penarikan = currency($obj->jumlah_penarikan($id_member, $bulan));

        $first_date = date("Y-m-d", strtotime($bulan.'-01'));
        $last_date = date("Y-m-t", strtotime($first_date));

        $statement_tgl = tgl_bulan($first_date).' - '.tgl_indo($last_date);

        $statement_bulan = bulan(date('Y-m-d', strtotime($first_date)));

        exit(json_encode(['status' => true, 'total_bonus' => $total_bonus, 'total_penarikan' => $total_penarikan, 'statement_tgl' => $statement_tgl, 'statement_bulan' => $statement_bulan, 'html' => $html]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']));
    }
}