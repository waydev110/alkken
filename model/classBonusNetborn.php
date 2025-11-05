<?php 
require_once 'classConnection.php';

class classBonusNetborn{

    private $arr_bonus = [
        'bonus_sponsor' => [
            'type' => 'bonus_sponsor',
            'table' => 'mlm_bonus_sponsor b',
            'join_table' =>  '',
            'additional_condition' => 'b.jenis_bonus IN (15,16,17)',
        ],
        'bonus_pasangan' => [
            'type' => 'bonus_pasangan',
            'table' => 'mlm_bonus_pasangan b',
            'join_table' =>  '',
            'additional_condition' => 'b.id_plan = 15',
        ],
        'bonus_pasangan_level' => [
            'type' => 'pasangan_level',
            'table' => 'mlm_bonus_pasangan_level b',
            'join_table' =>  '',
            'additional_condition' => 'b.id_plan IN (15,16,17)',
        ],
        'bonus_generasi' => [
            'type' => 'bonus_generasi',
            'table' => 'mlm_bonus_generasi b',
            'join_table' =>  '',
            'additional_condition' => 'b.jenis_bonus IN (15,16,17)',
        ],
        'bonus_upline' => [
            'type' => 'bonus_upline',
            'table' => 'mlm_bonus_upline b',
            'join_table' =>  '',
            'additional_condition' => 'b.jenis_bonus IN (15,16,17)',
        ],
        'bonus_balik_modal' => [
            'type' => 'bonus_balik_modal',
            'table' => 'mlm_bonus_balik_modal b',
            'join_table' =>  '',
            'additional_condition' => 'b.jenis_bonus IN (16,17)',
        ],
        // 'bonus_reward' => [
        //     'type' => 'bonus_reward',
        //     'table' => 'mlm_bonus_reward b',
        //     'join_table' =>  'JOIN mlm_bonus_reward_setting s ON b.id_bonus_reward_setting = s.id',
        //     'additional_condition' => 's.id_plan = 15',
        // ],
    ];

    protected function _SQL_TRANSFER_ALL($status_transfer)
    {
        $queries = [];
        foreach ($this->arr_bonus as $key => $bonus) {
            $queries[] = "SELECT         
                            b.id,
                            b.id_member,
                            '{$bonus['type']}' AS type,
                            b.nominal,
                            b.admin,
                            b.autosave,
                            b.total,
                            b.status_transfer,
                            b.created_at,
                            b.updated_at
                        FROM {$bonus['table']}
                        {$bonus['join_table']}
                        WHERE {$bonus['additional_condition']}
                        AND b.status_transfer = '$status_transfer'";
        }
    
        $sql = implode(" UNION ALL ", $queries);
        return $sql;
    }    
    
    private function _SQL_ALL_REKENING($sql, $tanggal) {
        $sum_columns = [];
        foreach ($this->arr_bonus as $key => $bonus) {
            $sum_columns[] = "SUM(CASE WHEN k.type = '{$bonus['type']}' THEN k.nominal ELSE 0 END) as {$bonus['type']}";
        }

        $sum_columns = implode(",\n", $sum_columns);
        
        $sql = "
            SELECT 
                m.id,
                m.id_member,
                m.nama_member,
                m.id_bank,
                b.nama_bank,
                b.kode_bank,
                m.no_rekening,
                m.atas_nama_rekening,
                m.cabang_rekening,
                k.type,
                $sum_columns,
                SUM(k.nominal) as nominal,
                SUM(k.autosave) as autosave,
                SUM(k.admin) as admin,
                SUM(k.total) as total,
                sw.saldo_bonus,
                MAX(k.created_at) AS created_at,
                k.status_transfer,
                k.updated_at
            FROM ($sql) k
            LEFT JOIN (
                SELECT
                    sp.id_member,
                    COALESCE(SUM(CASE 
                        WHEN sp.status = 'd'
                        THEN sp.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN sp.status = 'k'
                        THEN sp.nominal
                        ELSE 0 
                    END),0) AS saldo_bonus                
                FROM mlm_saldo_penarikan sp
                WHERE sp.jenis_saldo = 'saldo_wd' 
                AND sp.deleted_at is null
                GROUP BY sp.id_member
            ) sw ON k.id_member = sw.id_member
            LEFT JOIN mlm_member m ON k.id_member = m.id
            LEFT JOIN mlm_bank b ON m.id_bank = b.id
            WHERE LEFT(k.created_at, 10) <= '$tanggal'
        ";
        return $sql;
    }

    public function datatable_transfer($request, $tanggal) {   
        $add_sort_column = [];
        foreach ($this->arr_bonus as $key => $bonus) {
            $sum_columns[] = "{$bonus['type']}'";
        }

        $add_sort_column = implode(",\n", $sum_columns);
        $sort_column =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'm.cabang_rekening',
            $add_sort_column,
            'admin',
            'total',
            'm.id',
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'm.no_rekening',
            'm.atas_nama_rekening'
            );
        $sql = $this->_SQL_TRANSFER_ALL(0, $tanggal);
        $sql = $this->_SQL_ALL_REKENING($sql, $tanggal);
        
        $group = " GROUP BY k.id_member HAVING total >= 50000 AND COALESCE(sw.saldo_bonus, 0) >= total";
        
        $c = new classConnection();
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalData = $query->num_rows;
        
        // Hitung total
        $total_bonus = $c->_query_fetch("SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b")->total;
        $total_admin = $c->_query_fetch("SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b")->total;
        $total_transfer = $c->_query_fetch("SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b")->total;
        
        // Filter data jika ada pencarian
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
        
        $sql_group = $sql.$group;
        $query 	= $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        $sql_group.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = [
                $no,
                $row->id_member,
                $row->nama_member,
                $row->nama_bank,
                $row->kode_bank,
                $row->no_rekening,
                $row->cabang_rekening
            ];

            foreach ($this->arr_bonus as $key => $bonus) {
                $subdata[] = currency($row->{$bonus['type']});
            }

            $subdata[] = currency($row->autosave);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] = "
                <button type='button' class='btn btn-danger btn-xs' onclick=\"reject('$row->id', '$row->created_at', '$row->total', this)\">
                    <i class='fas fa-times'></i> Reject
                </button>
                <button type='button' class='btn btn-primary btn-xs' onclick=\"transfer('$row->id', '$row->created_at', '$row->total', this)\">
                    <i class='fas fa-paper-plane'></i> Transfer
                </button>
            ";
            $data[] = $subdata;
        }

        $json_data = [
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "total_bonus"       => rp($total_bonus),
            "total_admin"       => rp($total_admin),
            "total_transfer"    => rp($total_transfer),
            "data"              => $data
        ];
        
        return $json_data;
    }

    public function datatable_laporan($request, $tanggal) {
        $sql = $this->_SQL_TRANSFER_ALL(1, $tanggal);
        $sql = $this->_SQL_ALL_REKENING($sql, $tanggal);
        
        $group = " GROUP BY k.id_member, k.updated_at ";
        
        $c = new classConnection();
        if(!empty($request['start_date'])){
            $start_date = $request['start_date'];
            $sql.=" AND (LEFT(k.updated_at, 10) >= '$start_date') ";
        }
        if(!empty($request['end_date'])){
            $end_date = $request['end_date'];
            $sql.=" AND (LEFT(k.updated_at, 10) <= '$end_date') ";
        }
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalData = $query->num_rows;
        
        // Hitung total
        $total_bonus = $c->_query_fetch("SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b")->total;
        $total_admin = $c->_query_fetch("SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b")->total;
        $total_transfer = $c->_query_fetch("SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b")->total;
        
        // Filter data jika ada pencarian
        if (!empty($request['search']['value'])) {
            $sql .= " AND (";
            $data_search = ['m.id', 'm.id_member', 'm.nama_member', 'b.nama_bank', 'm.no_rekening', 'm.atas_nama_rekening'];
            foreach ($data_search as $key => $value) {
                if ($key > 0) {
                    $sql .= " OR ";
                }
                $sql .= "$value LIKE '%" . $request['search']['value'] . "%'";
            }
            $sql .= ")";
        }
        
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        
        $sql_group .= " ORDER BY " . $request['order'][0]['column'] . " " . $request['order'][0]['dir'] . " LIMIT " . $request['start'] . "," . $request['length'];
        $query = $c->_query($sql_group);
        
        $data = [];
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = [
                $no,
                $row->id_member,
                $row->nama_member,
                $row->nama_bank,
                $row->kode_bank,
                $row->no_rekening,
                $row->cabang_rekening
            ];

            foreach ($this->arr_bonus as $key => $bonus) {
                $subdata[] = currency($row->{$bonus['type']});
            }

            $subdata[] = currency($row->autosave);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] =  $row->updated_at;
            $subdata[] = '<button type="button" class="btn btn-teal btn-xs" onclick="send_notif('."'".$row->id."', '".$row->updated_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Send Notif</button>';
            $data[] = $subdata;
        }

        $json_data = [
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "total_bonus"       => rp($total_bonus),
            "total_admin"       => rp($total_admin),
            "total_transfer"    => rp($total_transfer),
            "data"              => $data
        ];
        
        return $json_data;
    }

    public function datatable_reject($request, $tanggal) {
        $sql = $this->_SQL_TRANSFER_ALL(2, $tanggal);
        $sql = $this->_SQL_ALL_REKENING($sql, $tanggal);
        
        $group = " GROUP BY k.id_member, k.updated_at ";
        
        $c = new classConnection();
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalData = $query->num_rows;
        
        // Hitung total
        $total_bonus = $c->_query_fetch("SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b")->total;
        $total_admin = $c->_query_fetch("SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b")->total;
        $total_transfer = $c->_query_fetch("SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b")->total;
        
        // Filter data jika ada pencarian
        if (!empty($request['search']['value'])) {
            $sql .= " AND (";
            $data_search = ['m.id', 'm.id_member', 'm.nama_member', 'b.nama_bank', 'm.no_rekening', 'm.atas_nama_rekening'];
            foreach ($data_search as $key => $value) {
                if ($key > 0) {
                    $sql .= " OR ";
                }
                $sql .= "$value LIKE '%" . $request['search']['value'] . "%'";
            }
            $sql .= ")";
        }
        
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        
        $sql_group .= " ORDER BY " . $request['order'][0]['column'] . " " . $request['order'][0]['dir'] . " LIMIT " . $request['start'] . "," . $request['length'];
        $query = $c->_query($sql_group);
        
        $data = [];
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = [
                $no,
                $row->id_member,
                $row->nama_member,
                $row->nama_bank,
                $row->kode_bank,
                $row->no_rekening,
                $row->cabang_rekening
            ];

            foreach ($this->arr_bonus as $key => $bonus) {
                $subdata[] = currency($row->{$bonus['type']});
            }

            $subdata[] = currency($row->autosave);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] = '<button type="button" class="btn btn-primary btn-xs" onclick="pending('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-check"></i> Pending</button>';
            $data[] = $subdata;
        }

        $json_data = [
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "total_bonus"       => rp($total_bonus),
            "total_admin"       => rp($total_admin),
            "total_transfer"    => rp($total_transfer),
            "data"              => $data
        ];
        
        return $json_data;
    }


    public function datatable_limit($request, $tanggal) {   
        $add_sort_column = [];
        foreach ($this->arr_bonus as $key => $bonus) {
            $sum_columns[] = "{$bonus['type']}'";
        }

        $add_sort_column = implode(",\n", $sum_columns);
        $sort_column =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'm.cabang_rekening',
            $add_sort_column,
            'admin',
            'total',
            'm.id',
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'm.no_rekening',
            'm.atas_nama_rekening'
            );
        $sql = $this->_SQL_TRANSFER_ALL(0, $tanggal);
        $sql = $this->_SQL_ALL_REKENING($sql, $tanggal);
        
        $group = " GROUP BY k.id_member HAVING total >= 50000 AND COALESCE(sw.saldo_bonus, 0) < total";
        
        $c = new classConnection();
        $sql_group = $sql . $group;
        $query = $c->_query($sql_group);
        $totalData = $query->num_rows;
        
        // Hitung total
        $total_bonus = $c->_query_fetch("SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b")->total;
        $total_admin = $c->_query_fetch("SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b")->total;
        $total_transfer = $c->_query_fetch("SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b")->total;
        
        // Filter data jika ada pencarian
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
        
        $sql_group = $sql.$group;
        $query 	= $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        $sql_group.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while ($row = $query->fetch_object()) {
            $no++;
            $subdata = [
                $no,
                $row->id_member,
                $row->nama_member,
                $row->nama_bank,
                $row->kode_bank,
                $row->no_rekening,
                $row->cabang_rekening
            ];

            foreach ($this->arr_bonus as $key => $bonus) {
                $subdata[] = currency($row->{$bonus['type']});
            }

            $subdata[] = currency($row->autosave);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] = '<span class="text-danger">Saldo Bonus Kurang</span>';
            $data[] = $subdata;
        }

        $json_data = [
            "draw"              => intval($request['draw']),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFilter),
            "total_bonus"       => rp($total_bonus),
            "total_admin"       => rp($total_admin),
            "total_transfer"    => rp($total_transfer),
            "data"              => $data
        ];
        
        return $json_data;
    }

    public function update_transfer($id_member, $tanggal, $updated_at)
    {
        $c = new classConnection();
    
        foreach ($this->arr_bonus as $key => $bonus) {
            $sql = "UPDATE {$bonus['table']} {$bonus['join_table']}
                        SET b.status_transfer = '1',
                            b.updated_at = '$updated_at'
                    WHERE b.id_member = '$id_member'
                        AND {$bonus['additional_condition']}
                        AND b.created_at <= '$tanggal'
                        AND b.status_transfer = '0'";
            $c->_query($sql);
        }
    
        return true;
    } 

    public function update_reject($id_member, $tanggal, $updated_at)
    {
        $c = new classConnection();
    
        foreach ($this->arr_bonus as $key => $bonus) {
            $sql = "UPDATE {$bonus['table']} {$bonus['join_table']}
                        SET b.status_transfer = '2',
                            b.updated_at = '$updated_at'
                    WHERE b.id_member = '$id_member'
                        AND {$bonus['additional_condition']}
                        AND b.created_at <= '$tanggal'
                        AND b.status_transfer = '0'";
    
            $c->_query($sql);
        }
        return true;
    } 

    public function update_pending($id_member, $tanggal, $updated_at)
    {
        $c = new classConnection();
    
        foreach ($this->arr_bonus as $key => $bonus) {
            $sql = "UPDATE {$bonus['table']} {$bonus['join_table']}
                        SET b.status_transfer = '0',
                            b.updated_at = '$updated_at'
                    WHERE b.id_member = '$id_member'
                        AND {$bonus['additional_condition']}
                        AND b.created_at <= '$tanggal'
                        AND b.status_transfer = '2'";
            $c->_query($sql);
        }
        return true;
    }    
}