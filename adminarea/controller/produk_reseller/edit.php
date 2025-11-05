<?php
require_once '../../../helper/string.php';
require_once '../../../helper/config.php';
require_once '../../../helper/crud.php';
require_once 'setting.php';
require_once '../../../model/classCRUD.php';
require_once '../../../model/classProduk.php';
require_once '../../../model/classProdukImage.php';

$obj = new classCRUD();
$ci = new classCRUD();
$crud = new classCRUD();
$cp = new classProduk();
$cpi = new classProdukImage();

$data = setData($arr_field, $dir_img);
$id_produk = $_POST['id'] ?? null;

if ($id_produk && !empty($data)) {
    $timestamp = date('Y-m-d H:i:s');

    foreach ($data as $key => $field) {
        $column = $field['column'];
        $obj->$column = $field['value'];
    }

    $obj->updated_at = $timestamp;
    $update = $obj->update($table, $id_produk);

    if (!$update) {
        echo json_encode([
            'status' => false,
            'message' => 'Gagal memperbarui data.'
        ]);
        exit();
    }
    $old_images = isset($_POST['images']) ? $_POST['images'] : [];

    $imageRecords = $cpi->index($id_produk);
    while ($row = $imageRecords->fetch_object()) {
        if (!in_array($row->id, $old_images)) {
            $filePath = '../../../images/' . $dir_img . '/' . $row->gambar;
            if (file_exists($filePath)) unlink($filePath);
            $cpi->delete($row->id);
        }
    }


    $new_images = [];
    if (!empty($_FILES['multi_image']) && is_array($_FILES['multi_image']['name'])) {
        foreach ($_FILES['multi_image']['name'] as $index => $name) {
            if ($_FILES['multi_image']['error'][$index] === 0) {
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
                    $create_image = $crud->create('mlm_produk_image');
                    if (!$create_image) {
                        echo json_encode([
                            'status' => false,
                            'message' => 'Terjadi kesalahan. Upload image gagal disimpan.'
                        ]);
                        exit();
                    }

                    $new_images[] = $create_image;
                } else {
                    echo json_encode([
                        'status' => false,
                        'message' => 'Terjadi kesalahan. Upload image gagal.'
                    ]);
                    exit();
                }
            }
        }
    }

    $all_images = array_merge($old_images, $new_images);
    foreach ($all_images as $index => $id) {
        $cpi->sorting = $index;
        $cpi->is_primary =  $index == 0 ? 1 : 0;
        $cpi->update($id);
    }

    $is_primary = $cpi->is_primary($id_produk);

    $ci->gambar = $is_primary;
    $ci->update($table, $id_produk);

        
    if(isset($_POST['produk_plan'])){
        $produk_plan = $_POST['produk_plan'];
        $cp->insertOrUpdateAndDelete($produk_plan, $id_produk);
    }

    echo json_encode([
        'status' => true,
        'message' => 'Data berhasil diupdate.'
    ]);
    exit();
} else {
    echo json_encode([
        'status' => false,
        'message' => 'Terjadi Kesalahan.'
    ]);
    exit();
}
