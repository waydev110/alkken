<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonusNetborn.php';
$obj = new classManageBonusNetborn();
$table = 'mlm_bonus_sponsor';
$request = $_REQUEST;
$tanggal = date('Y-m-d');
$select_columns = [
    'm.id',
    'm.id_member',
    'm.nama_member',
    'b.nama_bank',
    'b.kode_bank',
    'm.no_rekening',
    'm.cabang_rekening',
    'SUM(k.nominal) as nominal',
    'MAX(k.created_at) AS created_at'
];
$select_columns[] = 'SUM(k.autosave) as autosave';
$select_columns[] = 'SUM(k.admin) as admin';
$select_columns[] = 'SUM(k.total) as total';
$columns = [
    'id',
    'id_member',
    'nama_member',
    'nama_bank',
    'kode_bank',
    'no_rekening',
    'cabang_rekening',
    'nominal',
    'autosave',
    'admin',
    'total',
    'id'
];
$sort_column = $columns;

$data_search = ['k.id', 'm.id_member', 'm.nama_member', 'b.kode_bank', 'b.nama_bank'];

$group_conditions = ['m.id', 'k.updated_at'];
$minimal_transfer = [];
$actions = ['pending'];
$additional_conditions = [  
                            "k.jenis_bonus IN (15,16,17)",
                            "k.status_transfer = '2'"];

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
    $additional_conditions
);
echo json_encode($data);
return true;
?>