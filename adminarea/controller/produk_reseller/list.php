<?php 
$request = $_REQUEST;
require_once '../../../helper/url.php';
require_once '../../../helper/string.php';
require_once '../../../helper/config.php';
require_once 'setting.php';
require_once '../../../model/classCRUD.php';
$obj = new classCRUD();
$select_columns = [
    't.*',
    "COALESCE(GROUP_CONCAT(pl.nama_plan SEPARATOR ', '), '') AS plan_produk"
];
$columns = [
    'id',
    'gambar',
    'sku',
    'nama_produk',
    'harga',
    'bonus_sponsor',
    'nilai_produk',
    'poin_pasangan',
    'poin_reward',
    'plan_produk',
    'tampilkan',
    'id',
];
$sort_column = [
    'id',
    'gambar',
    'sku',
    'nama_produk',
    'harga',
    'bonus_sponsor',
    'nilai_produk',
    'poin_pasangan',
    'poin_reward',
    'plan_produk',
    'tampilkan',
    'id',
];

$data_search = ['t.nama_produk'];

$actions = ['edit', 'duplikat'];
$additional_conditions = ['pp.id_plan = 201',
                            't.id_produk_jenis = 201'];
$join_tables = [
                'LEFT JOIN mlm_produk_plan pp ON pp.id_produk = t.id',
                'LEFT JOIN mlm_plan pl ON pp.id_plan = pl.id',
                'LEFT JOIN mlm_produk_jenis pj ON t.id_produk_jenis = pj.id'
                ];
            
if(!empty($request['search']['value'])){
    $additional_conditions[] = "t.nama_produk LIKE '%" . $request['search']['value'] . "%'";
}        
if(!empty($request['id_plan'])){
    $additional_conditions[] = "pp.id_plan = '" . $request['id_plan'] . "'";
}     
if(!empty($request['jenis_produk'])){
    $additional_conditions[] = "t.id_produk_jenis = '" . $request['jenis_produk'] . "'";
}
$groups = ['t.id'];

$data = $obj->datatable(
    $url,
    $dir_img,
    $table, 
    $request, 
    $select_columns,
    $columns, 
    $sort_column, 
    $data_search, 
    $actions,
    $additional_conditions,
    $join_tables,
    $groups
);
echo json_encode($data);
return true;
?>