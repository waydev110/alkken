<?php
require_once 'classConnection.php';
class classCRUD
{

    protected $attributes = [];

    // Magic method untuk mengakses properti
    public function __get($property)
    {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value)
    {
        $this->attributes[$property] = $value;
    }

    public function create($table)
    {
        $columns = implode(", ", array_keys($this->attributes));

        $sanitized_values = [];

        foreach ($this->attributes as $value) {
            $sanitized_values[] = "'" . $value . "'";
        }

        $values = implode(", ", $sanitized_values);

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        
        $c = new classConnection();
        
        $query = $c->_query_insert($sql);
        return $query;
    }

    public function update($table, $id)
    {
        $updates = [];

        foreach ($this->attributes as $column => $value) {
            $updates[] = "$column = '" . $value . "'";
        }

        $updates_str = implode(", ", $updates);

        $sql = "UPDATE $table SET $updates_str WHERE id = '" . addslashes($id) . "'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function datatable(
        $url, 
        $dir_img, 
        $table, 
        $request, 
        $select_columns,
        $columns, 
        $sort_column, 
        $data_search, 
        $actions = [], 
        $additional_conditions = [],
        $join_tables = [],
        $groups = []
    )
    {
        $select_columns = implode(", ", $select_columns);

        $sql  = "SELECT 
                        $select_columns
                    FROM $table t ";

        if (!empty($join_tables)) {
            foreach ($join_tables as $join_table) {
                $sql .= " $join_table ";
            }
        }

        $sql .= " WHERE 1 ";
        if (!empty($additional_conditions)) {        
            foreach ($additional_conditions as $condition) {
                $sql .= " AND $condition";
            }
        }

        $c = new classConnection();
        $sql_group = $sql;
        
        if (!empty($groups)) {
            $sql_group_all = $sql_group.' GROUP BY '.implode(", ", $groups);
        }
        // echo $sql_group;
        $sql_all = "SELECT COUNT(*) AS total FROM ($sql_group_all) AS t";
        // echo $sql_all;
        $query = $c->_query_fetch($sql_all);
        $totalData = $query->total;

        if (!empty($request['search']['value'])) {
            $sql .= " AND (";
            foreach ($data_search as $key => $value) {
                if ($key > 0) {
                    $sql .= " OR ";
                }
                if($value == 'kode_order'){
                    $sql .= "t.id = '" . extractIdFromOrderCode($request['search']['value']) . "'";
                } else {
                    $sql .= "$value LIKE '%" . $request['search']['value'] . "%'";
                }
            }
            $sql .= ")";
        }

        if (!empty($request['keyword'])) {
            $sql .= " AND (";
            foreach ($data_search as $key => $value) {
                if ($key > 0) {
                    $sql .= " OR ";
                }
                if($value == 'kode_order'){
                    $sql .= "t.id = '" . extractIdFromOrderCode($request['keyword']) . "'";
                } else {
                    $sql .= "$value LIKE '%" . $request['keyword'] . "%'";
                }
            }
            $sql .= ")";
        }

        $sql_group = $sql;
        if (!empty($groups)) {
            $sql_group_filter = $sql_group.' GROUP BY '.implode(", ", $groups);
        }
        $sql_filter = "SELECT COUNT(*) AS total FROM ($sql_group_filter) AS x";
        $query = $c->_query_fetch($sql_filter);
        $totalFilter = $query->total;
        
        if (!empty($groups)) {
            $sql_group .= ' GROUP BY '.implode(", ", $groups);
        }
        $sort_column_index = $request['order'][0]['column'];
        $sql_group .= " ORDER BY " . $sort_column[$sort_column_index] . " " . $request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql_group.="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        $query = $c->_query($sql_group);
        $data = array();
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = array();
            $subdata[] = $no;
            foreach ($columns as $col) {
                $value = $row->$col;
                if (in_array($col, ['id'])) {
                    continue;
                }
                if (in_array($col, ['nominal', 'harga', 'harga_promo', 'bonus_sponsor', 'bonus_generasi', 'bonus_upline', 'bonus_pasangan','bonus_pasangan_level', 'fee_stokis', 'terjual'])) {
                    $subdata[] = currency($value);
                } else if (in_array($col, ['nilai_produk', 'poin_belanja', 'poin_redeem', 'poin_reward', 'jumlah_hu'])) {
                    $subdata[] = decimal($value);
                } else if (in_array($col, ['gambar'])) {
                    $subdata[] = '<img src="../images/'.$dir_img.'/'.$row->gambar. '" height="30" class="img-clickable">';
                } else if (in_array($col, ['status_transfer'])) {
                    $subdata[] = status_transfer($value);
                } else if (in_array($col, ['kode_order'])) {
                    $subdata[] = idOrder($value, $row->created_at);
                } else if (in_array($col, ['status'])) {
                    $subdata[] = status_aktif($value);
                } else if (in_array($col, ['status_aktivasi'])) {
                    $subdata[] = status_aktivasi($value);
                } else if (in_array($col, ['status_sync'])) {
                    $subdata[] = status_sync($value);
                } else if (in_array($col, ['status_order'])) {
                    $subdata[] = status_order($value);
                } else if (in_array($col, ['metode_pembayaran'])) {
                    $subdata[] = metode_pembayaran($value);
                } else if (in_array($col, ['pass_admin', 'password'])) {
                    $subdata[] = base64_decode($value);
                } else if (in_array($col, ['tampilkan'])) {
                    $subdata[] = status_tampil($value, $row->tampilkan);
                } else {
                    $subdata[] = $value;
                }
            }

            $aksi = '<div class="btn-group">';
            if (in_array('edit', $actions)) {
                $aksi .= '<a href="'.site_url($url).'_edit&id='.$row->id .'" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i> Edit</a>';
            }
            if (in_array('duplikat', $actions)) {
                $aksi .= '<a href="'.site_url($url).'_create&id='.$row->id .'" class="btn btn-primary btn-xs"><i class="fas fa-plus"></i> Duplikat</a>';
            }
            if (in_array('delete', $actions)) {
                $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="delete('."'".$row->id."'".', this)"><i class="fas fa-trash"></i></button>';
            }
            if (in_array('download', $actions)) {
                $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="download('."'".$row->id."'".', this)"><i class="fas fa-download"></i> Download</button>';
            }
            if (in_array('import', $actions)) {
                $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="sync('."'".$row->id."'".', this)"><i class="fas fa-file-check"></i> Sync</button>';
            }
            if (in_array('approve', $actions)) {
                $aksi .= '<button type="button" class="btn btn-success btn-xs" onclick="approve('."'".$row->id."'".', this)"><i class="fas fa-check"></i> Approve</button>';
            }
            if (in_array('proses_order', $actions)) {
                $aksi .= '<a href="?go=member_order_detail&id_order='.idOrder($row->id, $row->created_at).'&member_id='.$row->member_id.'" class="btn btn-default btn-xs"><i class="fas fa-info-circle"></i> Detail</a>';
            }
            if (in_array('proses_order', $actions)) {
                if(isset($row->status_order) && $row->status_order == 0){
                    $aksi .= '<button type="button" class="btn btn-default btn-xs" onclick="proses('."'".$row->id."'".', this)"><i class="fas fa-box-taped"></i> Proses</button>';
                }
            }
            if (in_array('reject_order', $actions)) {
                if(isset($row->status_order) && $row->status_order == 0){
                    $aksi .= '<button type="button" class="btn btn-danger btn-xs" onclick="reject('."'".$row->id."'".', this)"><i class="fas fa-times"></i> Reject</button>';
                }
            }
            if (in_array('input_resi', $actions)) {
                if(isset($row->status_order) && $row->status_order == 1){
                    $aksi .= '<button type="button" class="btn btn-primary btn-xs" onclick="showFormInputResi('."'".$row->id."'".', this)"><i class="fas fa-paper-plane"></i> Input Resi</button>';
                }
            }
            if (in_array('edit_resi', $actions)) {
                if(isset($row->status_order) && $row->status_order == 2){
                    $aksi .= '<button type="button" class="btn btn-primary btn-xs" onclick="showFormEditResi('."'".$row->id."'".', this)"><i class="fas fa-paper-plane"></i> Edit Resi</button>';
                }
            }
            if (in_array('finish_order', $actions)) {
                if(isset($row->status_order) && $row->status_order == 2){
                    $aksi .= '<button type="button" class="btn btn-success btn-xs" onclick="finish('."'".$row->id."'".', this)"><i class="fas fa-check-circle"></i> Selesai</button>';
                }
            }
            if (in_array('reject', $actions)) {
                $aksi .= '<button type="button" class="btn btn-danger btn-xs" onclick="reject('."'".$row->id."'".', this)"><i class="fas fa-times"></i> Reject</button>';
            }
            $aksi .= '</div>';
            
            $subdata[] = $aksi;
            
            $data[] = $subdata;
        }

        $json_data = array(
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "data"              => $data
        );

        return $json_data;
    }

    public function index($table)
    {
        $sql  = "SELECT t.* 
                        FROM $table t 
                        WHERE t.deleted_at IS NULL";
        $c    = new classConnection();
        $query     = $c->_query($sql);
        return $query;
    }

    public function show($table, $id)
    {
        $sql  = "SELECT t.*
                        FROM $table t 
                        WHERE t.deleted_at IS NULL 
                        AND t.id = '$id'";
        $c    = new classConnection();
        $query     = $c->_query_fetch($sql);
        return $query;
    }

}
