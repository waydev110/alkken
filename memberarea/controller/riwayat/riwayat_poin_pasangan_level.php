<?php
if(isset($_POST['id_plan'])){
    require_once '../../../helper/all_member.php';    
    require_once '../../../model/classBonusPasanganLevel.php';
    $obj = new classBonusPasanganLevel();

    $id_member = $_SESSION['session_member_id'];
    $id_plan = $_POST['id_plan'];
    $result = $obj->riwayat_poin_pasangan($id_member, $id_plan);
    if($result){
        $html = '';
        if($result->num_rows > 0){
            $html .= '<div class="card mb-0 rounded-0 border-0 border-bottom">
                        <div class="card-body">
                            <div class="row">
                                <div class="col align-self-center">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Level</th>
                                                <th class="text-center">Kiri</th>
                                                <th class="text-center">Kanan</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>';
            while($row = $result->fetch_object()){
                $html .= '
                                        <tbody>
                                            <tr>
                                                <td class="text-center">'.currency($row->generasi).'</td>
                                                <td class="text-center">'.currency($row->kiri).'</td>
                                                <td class="text-center">'.currency($row->kanan).'</td>
                                                <td class="text-center">'.($row->kiri == $row->kanan ? 'Terpasang' : 'Pending').'</td>
                                            </tr>
                                        </tbody>
                        ';
            }
            $html .= '
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>';
        } else {
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
        exit(json_encode(['status' => true, 'html' => $html]));
    } else {
        exit(json_encode(['status' => false, 'message' => 'Terjadi kesalahan saat memanggil data.']));
    }
}