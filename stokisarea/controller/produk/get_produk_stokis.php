<?php
    session_start();
    $id_stokis= $_SESSION['session_stokis_id'];
    require_once '../../../helper/string.php';
    require_once '../../../model/classStokisProduk.php';
    require_once '../../../model/classPlan.php';

    $obj = new classStokisProduk();
    $cpl = new classPlan();

    $keyword = '';
    if(isset($_POST['keyword'])){
        $keyword = $_POST['keyword'];
    }
    $id_plan = 0;
    if(isset($_POST['id_plan']) && $_POST['id_plan'] > 0){
        $id_plan = $_POST['id_plan'];
    }
    $jenis_produk = '';
    if(isset($_POST['jenis_produk'])){
        $jenis_produk = $_POST['jenis_produk'];
    }
    $plan = $cpl->show($id_plan);
    if($plan){
        $get_produk = $obj->index_jual_pin($id_stokis, $id_plan, $keyword, $jenis_produk);
        include 'card_produk.php';
    } else {
        $html = '<div class="card mx-2 mt-4 shadow-none rounded-0" style="padding-top:80px">
                    <div class="card-body p-5">
                        <div class="row">
                            <div class="col">
                                <p class="text-muted text-center"><i class="fa-solid fa-box-open fa-8x"></i></p>                            
                                <p class="text-center fw-normal">Tidak ada produk.</p>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    echo json_encode(['status' => true, 'html' => $html]);
    return true;