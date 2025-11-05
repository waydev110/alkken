<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonusNetborn.php';
$obj = new classManageBonusNetborn();
$table = 'mlm_bonus_balik_modal';
$request = $_REQUEST;
$tanggal = date('Y-m-d');

$start_date = isset($request['start_date']) ? $request['start_date'] : null;
$end_date = isset($request['end_date']) ? $request['end_date'] : null;

$select_columns = [
    'm.id',
    'm.id_member',
    'm.nama_member',
    'b.nama_bank',
    'b.kode_bank',
    'm.no_rekening',
    'm.cabang_rekening',
    'SUM(k.nominal) as nominal',
    'k.updated_at'
];
// Kondisi dinamis hanya untuk kolom admin dan total

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
    'updated_at',
    'id'
];
$sort_column = $columns;

$data_search = ['k.id', 'm.id_member', 'm.nama_member', 'b.kode_bank', 'b.nama_bank'];

$group_conditions = ['m.id', 'k.updated_at'];
$minimal_transfer = [0];
$actions = ['notif'];
$additional_conditions = [  
                            "k.status_transfer = '1'"];
if ($start_date) {
    $additional_conditions[] = "LEFT(k.updated_at, 10) >= '$start_date'";
}
if ($end_date) {
    $additional_conditions[] = "LEFT(k.updated_at, 10) <= '$end_date'";
}

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