<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$table = 'mlm_bonus_cashback';
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
// Kondisi dinamis hanya untuk kolom admin dan total
if ($_setting_admin === 'percent') {
    // Jika setting_admin adalah persentase
    $select_columns[] = 'SUM(k.admin) as admin';
    $select_columns[] = 'SUM(k.total) as total';
} else {
    // Jika setting_admin adalah nominal
    $select_columns[] = "$_admin as admin"; // Menggunakan $_admin sebagai admin
    $select_columns[] = "SUM(k.total) - $_admin as total"; // Mengurangi $_admin dari total
}
$columns = [
    'id',
    'id_member',
    'nama_member',
    'nama_bank',
    'kode_bank',
    'no_rekening',
    'cabang_rekening',
    'nominal',
    'admin',
    'total',
    'id'
];
$sort_column = $columns;

$data_search = ['k.id', 'm.id_member', 'm.nama_member', 'b.kode_bank', 'b.nama_bank'];

$group_conditions = ['m.id'];
$minimal_transfer = [];
$actions = ['transfer', 'reject'];
$additional_conditions = [  
                            "k.jenis_bonus <> '14'",
                            "k.status_transfer = '0'", 
                            "LEFT(k.created_at, 10) <= '$tanggal'"];

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