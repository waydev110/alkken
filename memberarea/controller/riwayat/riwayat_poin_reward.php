<?php
if(isset($_POST['start'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classBonusReward.php';
    $obj = new classBonusReward();

    $id_member = $_SESSION['session_member_id'];
    $posisi = $_POST['posisi'];
    $status = $_POST['status'];
    $type = $_POST['type'];
    $start = $_POST['start'];
    $id_plan = $_POST['id_plan'];
    if($_binary == true){
        $result = $obj->riwayat_poin_binary($id_member, $posisi, $status, $type, $start, $id_plan);
    } else {
        $result = $obj->riwayat_poin($id_member, $status, $type, $start, $id_plan);
    }
    if($result){
        $html = '';
        $count = $result->num_rows;
        if($count > 0){
            $start += 10;
            while($row = $result->fetch_object()){
                $tanggal = $row->created_at;
                if($_binary == true){
                    $posisi = '<strong><i>'.ucfirst($row->posisi).'</i></strong> ';
                } else {
                    $posisi = '';
                }
                $tanggal = tgl_bonus(tgl_indo($tanggal), jam($tanggal));
                $html .= '<div class="card mb-0 rounded-0 border-0 border-bottom bonus-item '.$row->type.'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                            <p class="mb-0 text-theme size-12"> '.$posisi.poin($row->poin).' '.$row->nama_plan.'</p>
                                <p>
                                    <span class="text-default fw-semibold mb-1 size-14">
                                        dari '.$row->nama_samaran.' ('.$row->id_member.')
                                    </span>
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
                                        <h6 class="text-center fw-normal">Tidak ada riwayat poin.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

        }
        exit(json_encode(['status' => true, 'html' => $html, 'start' => $start, 'start' => $start, 'type' => $type, 'count' => $count]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.', 'count' => $count]));
    }
}