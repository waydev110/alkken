<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_bonus_royalti_omset';
$request = $_REQUEST;
$tanggal = date('Y-m-d');
$select_columns = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'pr.nama_peringkat',
    'k.nominal',
    'k.status_transfer'
];
$columns = [
    'id',
    'created_at',
    'id_member',
    'nama_member',
    'nama_peringkat',
    'nominal',
    'status_transfer'
];
$sort_column = $select_columns;

$data_search = ['k.id', 'm.id_member', 'm.nama_member'];

$group_conditions = [];
$minimal_transfer = [0];
$actions = [];
$additional_conditions = [];
$join_tables = ["LEFT JOIN mlm_peringkat pr ON k.id_peringkat = pr.id"];

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