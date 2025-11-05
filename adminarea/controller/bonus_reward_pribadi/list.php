<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_bonus_reward_paket';
$request = $_REQUEST;
if (isset($request['id_plan'])){
    $id_plan = $request['id_plan'];
} else {
    echo json_encode('Terjadi Kesalahan Parameter.');
    return true;
}
$tanggal = date('Y-m-d');
$select_columns = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'k.reward',
    'k.nominal',
    'k.status_transfer'
];
$columns = [
    'id',
    'created_at',
    'id_member',
    'nama_member',
    'reward',
    'nominal',
    'status_transfer'
];
$sort_column = $select_columns;

$data_search = ['k.id', 'm.id_member', 'm.nama_member'];

$group_conditions = [];
$minimal_transfer = [0];
$actions = [];
$additional_conditions = ["rs.id_produk_jenis = '$id_plan'"];
$join_tables = [
    "JOIN mlm_bonus_reward_paket_setting rs ON k.id_bonus_reward_setting = rs.id"
];

$data = $obj->datatable(
    $table, 
    $request, 
    $select_columns,
    $columns, 
    $sort_column, 
    $data_search, 
    $group_conditions,
    $minimal_transfer,
    $actions,
    $additional_conditions,
    $join_tables
);
echo json_encode($data);
return true;
?>