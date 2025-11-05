<?php
if(isset($_POST['start'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classBonus.php';
    $obj = new classBonus();

    $id_member = $_SESSION['session_member_id'];
    $type = $_POST['type'];
    $start = $_POST['start'];
    $status_transfer = $_POST['status_transfer'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $keterangan = addslashes(strip_tags($_POST['keterangan']));
    $result = $obj->ajax($id_member, $start, $type, $keterangan, $status_transfer, $start_date, $end_date);
    if($result){
        $html = '';
        $count = $result->num_rows;
        if($count > 0){
            $start += 10;
            while($row = $result->fetch_object()){
                // $tanggal = $row->status_transfer == '1' ? $row->updated_at : $row->created_at;
                $tanggal = $row->created_at;
                $status_transfer = status_bonus($row->status_transfer);
                $tanggal_bonus = tgl_bonus(tgl_indo($tanggal), jam($tanggal));
                $keterangan_autosave = $row->autosave > 0 ? ' Autosave : '.currency($row->autosave).' Jumlah : '.currency($row->total) : '';
                $html .= '<div class="card mb-0 rounded-0 border-0 border-bottom bonus-item '.$row->type.'">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                            <p class="mb-0 fw-bold text-default size-14">'.$lang[$row->type].'</p>
                                <p>
                                    <span class="text-dark fw-bold mb-1 size-18">
                                        '.currency($row->nominal).'
                                    </span>
                                </p>
                            </div>
                            <div class="col-auto align-self-right">
                                '.$tanggal_bonus.'
                                '.$status_transfer.'
                            </div>
                        </div>
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="mb-0"><span class="text-muted size-12">'.$row->keterangan.$keterangan_autosave.'</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            $count = 0;
            if($start == 0){
                $html = '<div class="card shadow-none rounded-15">
                            <div class="card-body p-5">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted text-center"><i class="fa-light fa-analytics fa-8x"></i></p>                            
                                        <h6 class="text-center fw-normal">Tidak ada bonus.</h6>
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