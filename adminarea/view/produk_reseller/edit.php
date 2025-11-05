<?php
    require_once 'controller/' . $mod_url . '/setting.php';
    require_once '../helper/crud.php';
    require_once '../model/classProduk.php';
    require_once '../model/classSatuan.php';
    require_once '../model/classPlan.php';
    require_once '../model/classProdukJenis.php';
    $cp = new classProduk();
    $cs = new classSatuan();
    $cpl = new classPlan();
    $cpj = new classProdukJenis();
    $produk_jenis = $cpj->index();
    $plan = $cpl->index();

    $arr_option = [];
    while ($row = $produk_jenis->fetch_object()) {
        $option = [];
        $option['label'] = $row->name;
        $option['value'] = $row->id;
        $arr_option[] = $option;
    }
    $arr_field[0]['option'] = $arr_option;

    $satuan = $cs->index();
    $arr_option = [];
    while ($row = $satuan->fetch_object()) {
        $option = [];
        $option['label'] = $row->satuan;
        $option['value'] = $row->satuan;
        $arr_option[] = $option;
    }
    $arr_field[15]['option'] = $arr_option;

    require_once '../model/classCRUD.php';
    $obj = new classCRUD();

    $id = $_GET['id'];
    $data = $obj->show($table, $id);

    $images = $cp->index_image($id);
    $arr_option = [];
    while ($row = $images->fetch_object()) {
        $option = [];
        $gambar = '../images/produk/'.$row->gambar;
        $option['label'] = imgBase64($gambar);
        // $option['label'] = $gambar;
        $option['value'] = $row->id;
        $option['sorting'] = $row->sorting;
        $arr_option[] = $option;
    }
    $arr_field[1]['option'] = $arr_option;


    $plan = $cp->index_produk_plan($id);
    $arr_option = [];
    while ($row = $plan->fetch_object()) {
        $option = [];
        $option['label'] = $row->nama_plan;
        $option['value'] = $row->id;
        $option['id'] = $row->id_produk;
        $option['data'] = $id;
        $arr_option[] = $option;
    }
    $arr_field[18]['option'] = $arr_option;
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $title ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body box-profile">
                    <?php
                    echo generateEditForm($arr_field, $url, $dir_img, $data);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../assets/plugins/ckeditor4_basic/ckeditor.js"></script>
    <script type="text/javascript" src="../assets/plugins/jquery-validation-1.19.5/jquery.validate.js"></script>
    <script type="text/javascript" src="../assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <script type="text/javascript" src="../assets/dist/js/script_crud.js"></script>
    <script type="text/javascript" src="view/<?= $url ?>/script.js"></script>