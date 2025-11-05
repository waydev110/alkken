<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_bonus_unilevel';
$request = $_REQUEST;
$tanggal = date('Y-m-d');
$select_columns = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'd.id_member as dari_member',
    'k.nominal',
    'k.generasi',
    'k.status_transfer'
];
$columns = [
    'id',
    'created_at',
    'id_member',
    'nama_member',
    'dari_member',
    'generasi',
    'nominal',
    'status_transfer'
];
$sort_column = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'd.id_member',
    'k.nominal',
    'k.generasi',
    'k.status_transfer'
];

$data_search = ['m.id', 'm.id_member', 'm.nama_member'];

$group_conditions = [];
$minimal_transfer = [0];
$actions = [];
$additional_conditions = [];
$join_tables = ["JOIN mlm_member d ON k.dari_member = d.id"];

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