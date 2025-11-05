<?php
if(isset($_POST['start'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classTestimoni.php';
    $obj = new classTestimoni();

    $start = $_POST['start'];
    $result = $obj->index_member($start);
    if($result){
        $html = '';
        $count = $result->num_rows;
        if($count > 0){
            $start += 10;
            while($row = $result->fetch_object()){
                $aksi = substr($row->testimoni, 150) <> '' ? '<a href="javascript:void(0);" class="text-bold comment-link" onclick="showComment(this, ' . "'text" . $row->id . "'" . ')">Baca Selengkapnya</a>' : '';
                $html .= '
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-center">
                                <p class="text-color-theme fw-bold size-12 mb-0">
                                    '.$row->nama_samaran.'
                                </p>
                                <p class="text-color-theme paket-name fw-bold size-12">Member '.$row->nama_plan.'</p>
                            </div>
                            <div class="col align-self-center text-end">
                                <p class="text-dark size-11 mb-0">'.tgl_indo_jam($row->created_at).'</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col align-self-center">
                                <p class="text-muted size-12">
                                    '.substr($row->testimoni, 0, 150).'<span class="text-readmore" id="text'.$row->id.'" style="display:none">'.substr($row->testimoni, 150).'</span>
                                    '.$aksi.'
                                </p>
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
                                        <h6 class="text-center fw-normal">Tidak ada testimoni.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>';
            }

        }
        exit(json_encode(['status' => true, 'html' => $html, 'start' => $start, 'count' => $count]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.', 'count' => $count]));
    }
}