<?php
if(isset($_POST['start'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classWallet.php';
    $obj = new classWallet();

    $id_member = $_SESSION['session_member_id'];
    $status = $_POST['status'];
    $start = number($_POST['start']);
    $jenis_saldo = 'cash';
    $result = $obj->riwayat_saldo($id_member, $jenis_saldo, $status, $start);
    if($result){
        $html = '';
        $count = $result->num_rows;
        if($count > 0){
            $start += 10;
            while($row = $result->fetch_object()){
                $tanggal = $row->created_at;
                $tanggal = tgl_bonus(tgl_indo($tanggal), jam($tanggal));
                $html .= '<div class="card mb-0 rounded-0 border-0 border-bottom bonus-item '.$row->status.'">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col align-self-center">
                                            <p class="mb-4 text-primary fw-bold size-16"> '.rp($row->nominal).'</p>
                                            <p class="text-dark fw-semibold mb-1 size-12">
                                            '.$row->keterangan.'
                                            </p>
                                        </div>
                                        <div class="col-auto align-self-right">
                                            '.$tanggal.'
                                            '.status_saldo($row->status).'
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
        exit(json_encode(['status' => true, 'html' => $html, 'start' => $start, 'status_filter' => $status, 'count' => $count]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.', 'count' => $count]));
    }
}