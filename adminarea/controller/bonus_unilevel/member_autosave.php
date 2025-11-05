<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_wallet';
$request = $_REQUEST;
$tanggal = date('Y-m-d');

$tutup_poin = isset($request['tutup_poin']) ? $request['tutup_poin'] : null;
$start_date = isset($request['start_date']) ? $request['start_date'] : null;
$end_date = isset($request['end_date']) ? $request['end_date'] : null;

$select_columns = [
    'm.id',
    'LEFT(k.created_at, 7) AS created_at',
    'm.id_member',
    'm.nama_member',
    'pl.nama_plan',
    'pl.max_autosave',
    "SUM(CASE WHEN k.type != 'tupo_automaintain' THEN k.nominal ELSE 0 END) AS nominal_potongan",
    "SUM(CASE WHEN k.type = 'tupo_automaintain' THEN k.nominal ELSE 0 END) AS nominal_tupo",
    'COALESCE(SUM(k.nominal),0) AS nominal',
    '(pl.max_autosave - COALESCE(SUM(k.nominal),0)) AS kekurangan'
];
$columns = [
    'id',
    'created_at',
    'id_member',
    'nama_member',
    'nama_plan',
    'max_autosave',
    'nominal_potongan',
    'nominal_tupo',
    'nominal'
];
$sort_column = [
    'm.id',
    'k.created_at',
    'm.id_member',
    'm.nama_member',
    'pl.nama_plan',
    'pl.max_autosave',
    'nominal_potongan',
    'nominal_tupo',
    'nominal',
    'id'
];

$data_search = ['m.id', 'm.id_member', 'm.nama_member'];

$group_conditions = ['m.id','LEFT(k.created_at, 7)'];
$actions = ['fix_saldo'];
$additional_conditions = ["k.jenis_saldo = 'poin'", "k.status = 'd'"];
if ($tutup_poin) {
    if($tutup_poin == '1'){
        // $additional_conditions[] = "nominal >= 350000";
        $minimal_transfer = [350000];
    } else {
        $minimal_transfer = [0];
    }
} else {
    $minimal_transfer = [0];
}
if ($start_date) {
    $additional_conditions[] = "LEFT(k.created_at, 10) >= '$start_date'";
}
if ($end_date) {
    $additional_conditions[] = "LEFT(k.created_at, 10) <= '$end_date'";
}
$join_tables = ["JOIN mlm_plan pl ON m.id_plan = pl.id"];

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