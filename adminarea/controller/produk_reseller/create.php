<?php
require_once '../../../helper/string.php';
require_once '../../../helper/config.php';
require_once '../../../helper/crud.php';
$set_action = 'submit';
require_once 'setting.php';
require_once '../../../model/classCRUD.php';
require_once '../../../model/classProduk.php';

$obj = new classCRUD();
$crud = new classCRUD();
$cp = new classProduk();

$data = setData($arr_field, $dir_img);
if (!empty($data)) {
    $timestamp = date('Y-m-d H:i:s');
    foreach ($data as $key => $field) {
        $column = $field['column'];
        $obj->$column = $field['value'];
    }
    $obj->created_at = $timestamp;
    $create = $obj->create($table);
    $id_produk = $create;
    if (!$create) {
        echo json_encode([
            'status' => false,
            'message' => 'Terjadi kesalahan. Data gagal disimpan.'
        ]);
        exit();
    }

    if (isset($_FILES['multi_image'])) {
        $image_order = explode(',', $_POST['image_order'] ?? '');
        foreach ($image_order as $index) {
            if (!isset($_FILES['multi_image']['name'][$index])) continue;
            $file = [
                'name' => $_FILES['multi_image']['name'][$index],
                'type' => $_FILES['multi_image']['type'][$index],
                'tmp_name' => $_FILES['multi_image']['tmp_name'][$index],
                'error' => $_FILES['multi_image']['error'][$index],
                'size' => $_FILES['multi_image']['size'][$index],
            ];
            $slug = slug($_POST['nama_produk'] ?? 'produk') .slug($name). rand(10, 99).$index;
            $gambar = storeImage($file, $slug, $dir_img);
            if ($gambar) {
                $crud->id_produk = $id_produk;
                $crud->gambar = $gambar;
                $crud->created_at = $timestamp;
                $crud->is_primary = $index == 0 ? 1 : 0;
                $crud->sorting = $index;
                $create_image = $crud->create('mlm_produk_image');
                if (!$create_image) {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Terjadi kesalahan. Upload image gagal disimpan.'
                    ]);
                    exit();
                }
                if($index == 0){
                    $obj->gambar = $gambar;
                    $obj->update($table, $create);
                }
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => 'Terjadi kesalahan. Upload image gagal.'
                ]);
                exit();
            }
        }
    }
        
    if(isset($_POST['produk_plan'])){
        $produk_plan = $_POST['produk_plan'];
        $cp->insertOrUpdateAndDelete($produk_plan, $create);
    }


    echo json_encode([
        'status' => true,
        'message' => 'Data berhasil disimpan.'
    ]);
    exit();
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Terjadi Kesalahan.'
    ]);
    exit();
}
