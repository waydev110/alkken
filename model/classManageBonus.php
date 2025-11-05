<?php
require_once 'classConnection.php';

class classManageBonus
{
    private $minimal_transfer = 50000;
    public function datatable(
        $table, 
        $request, 
        $select_columns,
        $columns, 
        $sort_column, 
        $data_search, 
        $group_conditions, 
        $minimal_transfer = [],
        $actions = [], 
        $additional_conditions = [],
        $join_tables = []
    )
    {
        // Membentuk query SELECT secara dinamis berdasarkan kolom yang diberikan
        $select_columns = implode(", ", $select_columns);

        $sql  = "SELECT 
                        $select_columns
                    FROM $table k
                    JOIN mlm_member m 
                    ON k.id_member = m.id
                    JOIN mlm_bank b 
                    ON m.id_bank = b.id ";

        if (!empty($join_tables)) {
            foreach ($join_tables as $join_table) {
                $sql .= " $join_table ";
            }
        }
        
        $sql .= " WHERE k.deleted_at IS NULL AND m.deleted_at IS NULL";

        // Menambahkan kondisi tambahan jika ada
        if (!empty($additional_conditions)) {
            foreach ($additional_conditions as $condition) {
                $sql .= " AND $condition";
            }
        }

        // Menambahkan GROUP BY dan HAVING conditions jika ada
        $group = !empty($group_conditions) ? " GROUP BY " . implode(", ", $group_conditions) : "";
        $group .= !empty($minimal_transfer) ? " HAVING nominal >= " . implode(" AND ", $minimal_transfer) : " HAVING total >= ".$this->minimal_transfer;

        $c = new classConnection();
        $sql_group = $sql . $group;
        $sql_all = "SELECT COUNT(*) AS total FROM ($sql_group) AS t";
        $query = $c->_query_fetch($sql_all);
        $totalData = $query->total;
        
        $sql_rekap = "SELECT                 
                    COALESCE(SUM(nominal), 0) AS total_bonus,
                    COALESCE(SUM(admin), 0) AS total_admin,
                    COALESCE(SUM(total), 0) AS total_transfer        
                    FROM ($sql_group) as b";
        $rekap = $c->_query_fetch($sql_rekap);

        // Pencarian (Search)
        if (!empty($request['search']['value'])) {
            $sql .= " AND (";
            foreach ($data_search as $key => $value) {
                if ($key > 0) {
                    $sql .= " OR ";
                }
                $sql .= "$value LIKE '%" . $request['search']['value'] . "%'";
            }
            $sql .= ")";
        }

        // Pengelompokan kembali setelah pencarian
        $sql_group = $sql . $group;
        $sql_filter = "SELECT COUNT(*) AS total FROM ($sql_group) AS t";
        $query = $c->_query_fetch($sql_filter);
        $totalFilter = $query->total;

        // Sorting dan Pagination
        $sort_column_index = $request['order'][0]['column'];
        $sql_group .= " ORDER BY " . $sort_column[$sort_column_index] . " " . $request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql_group.="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        $query = $c->_query($sql_group);
        // echo $sql_group;
        // Menyiapkan data untuk ditampilkan
        $data = array();
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = array();// Kolom pertama diisi dengan nomor urut
            $subdata[] = $no;
            
            foreach ($columns as $col) {
                $value = $row->$col;
                if (in_array($col, ['id'])) {
                    continue;
                }
                // Memeriksa jika kolom berisi angka yang perlu diformat sebagai currency
                if (in_array($col, ['nominal', 'admin', 'autosave', 'total', 'nominal_potongan', 'nominal_tupo', 'max_autosave'])) {
                    // Terapkan format currency
                    $subdata[] = currency($value);  // Fungsi currency memformat nilai menjadi mata uang
                } else if (in_array($col, ['status_transfer'])) {
                    // Terapkan format currency
                    $subdata[] = status_transfer($value);  // Fungsi currency memformat nilai menjadi mata uang
                } else {
                    $subdata[] = $value;  // Jika bukan angka, tambahkan seperti biasa
                }
            }

            // Membuat tombol aksi dinamis berdasarkan parameter `actions`
            $aksi = '<div class="btn-group">';
            if (in_array('reject', $actions)) {
                $aksi .= '<button type="button" class="btn btn-danger btn-xs" onclick="reject('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-times"></i> Hide</button>';
            }
            if (in_array('pending', $actions)) {
                $aksi .= '<button type="button" class="btn btn-warning btn-xs" onclick="pending('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-clock"></i> Pending</button>';
            }
            if (in_array('notif', $actions)) {
                $aksi .= '<button type="button" class="btn btn-info btn-xs" onclick="notif('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-bell"></i> Notif</button>';
            }
            if (in_array('transfer', $actions)) {
                $aksi .= '<button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>';
            }
            if (in_array('detail', $actions)) {
                $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="detail('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-receipt"></i> Detail</button>';
            }
            if (in_array('create', $actions)) {
                $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="create('."'".$row->id."', '".$row->id_member."', '".$row->nama_member."', '".$row->nama_member."'".', this)"><i class="fas fa-plus"></i> Tambah</button>';
            }
            if (in_array('fix_saldo', $actions)) {
                $aksi .= '<button type="button" class="btn btn-primary btn-xs" onclick="create('."'".$row->id."', '".$row->id_member."', '".$row->nama_member."', '".$row->created_at."', '".$row->kekurangan."'".', this)">Fix Saldo</button>';
            }
            $aksi .= '</div>';
            
            $subdata[] = $aksi;
            
            $data[] = $subdata;
        }

        // Output JSON
        $json_data = array(
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "total_bonus"       => rp($rekap->total_bonus),
            "total_admin"       => rp($rekap->total_admin),
            "total_transfer"    => rp($rekap->total_transfer),
            "data"              => $data
        );

        return $json_data;
    }

    public function update_transfer($table, $id_member, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k
                SET k.status_transfer = '1', k.updated_at = '$updated_at'
                WHERE k.id_member = '$id_member'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '0'";
                
        // Menambahkan kondisi tambahan jika ada
        if (!empty($additional_conditions)) {
            foreach ($additional_conditions as $condition) {
                $sql .= " AND $condition";
            }
        }
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_pending($table, $id_member, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k
                SET k.status_transfer = '0', k.updated_at = '$updated_at'
                WHERE k.id_member = '$id_member'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '2'";
                
                // Menambahkan kondisi tambahan jika ada
                if (!empty($additional_conditions)) {
                    foreach ($additional_conditions as $condition) {
                        $sql .= " AND $condition";
                    }
                }
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_reject($table, $id_member, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k 
                SET k.status_transfer = '2', k.updated_at = '$updated_at'
                WHERE k.id_member = '$id_member'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '0'";
                
                // Menambahkan kondisi tambahan jika ada
                if (!empty($additional_conditions)) {
                    foreach ($additional_conditions as $condition) {
                        $sql .= " AND $condition";
                    }
                }
                // echo $sql;
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function show_by_id($table, $id){
        $sql = "SELECT k.* FROM $table k
                WHERE k.id = '$id'
                AND k.deleted_at IS NULL";
        $c    = new classConnection(); 
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function update_transfer_by_id($table, $id, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k
                SET k.status_transfer = '1', k.updated_at = '$updated_at'
                WHERE k.id = '$id'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '0'";
                
                // Menambahkan kondisi tambahan jika ada
                if (!empty($additional_conditions)) {
                    foreach ($additional_conditions as $condition) {
                        $sql .= " AND $condition";
                    }
                }
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_pending_by_id($table, $id, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k
                SET k.status_transfer = '0', k.updated_at = '$updated_at'
                WHERE k.id = '$id'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '2'";
                
                // Menambahkan kondisi tambahan jika ada
                if (!empty($additional_conditions)) {
                    foreach ($additional_conditions as $condition) {
                        $sql .= " AND $condition";
                    }
                }
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_reject_by_id($table, $id, $tanggal, $updated_at, $additional_conditions = []){
        $sql = "UPDATE $table k
                SET k.status_transfer = '2', k.updated_at = '$updated_at'
                WHERE k.id = '$id'
                AND k.created_at <= '$tanggal'
                AND k.status_transfer = '0'";
                
                // Menambahkan kondisi tambahan jika ada
                if (!empty($additional_conditions)) {
                    foreach ($additional_conditions as $condition) {
                        $sql .= " AND $condition";
                    }
                }
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }
}
