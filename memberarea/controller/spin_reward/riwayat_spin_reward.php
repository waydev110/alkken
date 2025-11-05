<?php
if(isset($_POST['start'])){
    require_once '../../../helper/all.php';    
    require_once '../../../model/classSpinReward.php';
    $obj = new classSpinReward();

    $id_member = $_SESSION['session_member_id'];
    $start = $_POST['start'];
    $result = $obj->riwayat_spin_reward($id_member, $start);
    if($result){
        $html = '';
        $count = $result->num_rows;
        if($count > 0){
            $start += 10;
            while($row = $result->fetch_object()){
                $tanggal = $row->created_at;
                $tanggal = tgl_bonus(tgl_indo($tanggal), jam($tanggal));
                $html .= '<div class="card mb-0 rounded-0 border-0 border-bottom bonus-item">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <p class="mb-2 text-dark fw-bold size-12"> Selamat anda mendapatkan reward</p>
                                            <p class="text-danger fw-bold mb-1 size-14">
                                            '.$row->nama_reward.'
                                            </p>
                                        </div>
                                        <div class="col-auto align-self-right">
                                            '.$tanggal.'
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ';
            }
        } else {
            $count = 0;
            if($start == 0){
                $html = '<div class="card mx-2 mt-2 shadow-none rounded-0">
                            <div class="card-body p-5">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted text-center"><i class="fa-light fa-analytics fa-8x"></i></p>                            
                                        <h6 class="text-center fw-normal">Tidak ada riwayat.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

        }
        exit(json_encode(['status' => true, 'html' => $html, 'start' => $start, 'start' => $start, 'count' => $count]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.', 'count' => $count]));
    }
}