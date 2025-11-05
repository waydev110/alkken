<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_bonus_generasi';
$request = $_REQUEST;
$tanggal = date('Y-m-d');
$select_columns = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'd.id_member as dari_member',
    'k.nominal',
    'k.admin',
    'k.total',
    'k.id_kodeaktivasi',
    'k.generasi',
    'k.status_transfer'
];
$columns = [
    'id',
    'created_at',
    'id_member',
    'nama_member',
    'dari_member',
    'id_kodeaktivasi',
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
    'k.id_kodeaktivasi',
    'k.generasi',
    'k.nominal',
    'k.status_transfer'
];

$data_search = ['m.id_member', 'm.nama_member', 'k.id_kodeaktivasi'];

$group_conditions = [];
$minimal_transfer = [0];
$actions = [];
$additional_conditions = ["k.jenis_bonus = '14'"];
$join_tables = ["LEFT JOIN mlm_member d ON k.dari_member = d.id"];

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