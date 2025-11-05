<?php 
require_once '../../../helper/all.php';
require_once '../../../model/classManageBonus.php';
$obj = new classManageBonus();
$request = $_REQUEST;
$tanggal = date('Y-m-d');
$bulan = date('Y-m', strtotime('-1 month'));
$table = "(SELECT 
                id_member, 
                SUM(nominal) AS nominal, 
                SUM(total) AS total,
                MAX(created_at) AS created_at,
                bulan,
                deleted_at 
            FROM 
                mlm_bonus_unilevel 
            WHERE 
                deleted_at IS NULL 
                AND status_transfer = '0' 
                AND LEFT(created_at, 10) <= '$tanggal'
            GROUP BY 
                id_member)";
$select_columns = [
    'm.id',
    'm.id_member',
    'm.nama_member',
    'b.nama_bank',
    'b.kode_bank',
    'm.no_rekening',
    'm.cabang_rekening',
    'k.nominal',
    'k.created_at'
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

$data_search = ['m.id', 'm.id_member', 'm.nama_member', 'b.kode_bank', 'b.nama_bank'];

$group_conditions = ['m.id'];
$minimal_transfer = ['0'];
$actions = ['transfer', 'reject'];
$additional_conditions = [];
// $join_tables = [
//     "JOIN mlm_plan pl ON m.id_plan = pl.id",
//     "LEFT JOIN (
//         SELECT id_member, 
//                SUM(nominal) AS wallet_nominal, 
//                LEFT(created_at, 7) AS wallet_month
//         FROM mlm_wallet
//         WHERE jenis_saldo = 'poin' 
//               AND status = 'd' 
//               AND deleted_at IS NULL
//         GROUP BY id_member, LEFT(created_at, 7)
//     ) w ON k.id_member = w.id_member AND '$bulan' = w.wallet_month"];

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