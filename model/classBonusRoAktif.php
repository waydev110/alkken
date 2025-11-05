<?php 
require_once 'classConnection.php';

class classBonusRoAktif{

    private function _SQL_TRANSFER_ALL($status_transfer, $tanggal = '') {
        $sql = "SELECT 
                    id,
                    id_member,
                    'bonus_sponsor' AS type,
                    nominal,
                    admin,
                    autosave,
                    total,
                    status_transfer,
                    created_at,
                    updated_at
                FROM mlm_bonus_sponsor
                WHERE status_transfer = '$status_transfer'
                AND jenis_bonus = '14'
                AND nominal > 0

                UNION ALL
                
                SELECT 
                    id,
                    id_member,
                    'bonus_cashback' AS type,
                    nominal,
                    admin,
                    autosave,
                    total,
                    status_transfer,
                    created_at,
                    updated_at
                FROM mlm_bonus_cashback
                WHERE status_transfer = '$status_transfer'
                AND jenis_bonus = '14'
                AND nominal > 0

                UNION ALL

                SELECT 
                    id,
                    id_member,
                    'bonus_generasi' AS type,
                    nominal,
                    admin,
                    autosave,
                    total,
                    status_transfer,
                    created_at,
                    updated_at
                FROM mlm_bonus_generasi
                WHERE jenis_bonus = '14' 
                AND status_transfer = '$status_transfer'
                AND nominal > 0

                UNION ALL

                SELECT 
                    id,
                    id_member,
                    'bonus_upline' AS type,
                    nominal,
                    admin,
                    autosave,
                    total,
                    status_transfer,
                    created_at,
                    updated_at
                FROM mlm_bonus_upline
                WHERE jenis_bonus = '14' 
                AND status_transfer = '$status_transfer'
                AND nominal > 0

                UNION ALL

                SELECT 
                    id,
                    id_member,
                    'bonus_royalti_omset' AS type,
                    nominal,
                    admin,
                    autosave,
                    total,
                    status_transfer,
                    created_at,
                    updated_at
                FROM mlm_bonus_royalti_omset
                WHERE status_transfer = '$status_transfer'
                AND nominal > 0";
        return $sql;

    }

    private function _SQL_ALL_REKENING($sql, $tanggal, $admin){
        $sql = "SELECT 
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
                    SUM(CASE WHEN k.type = 'bonus_sponsor' THEN k.nominal ELSE 0 END) as bonus_sponsor,
                    SUM(CASE WHEN k.type = 'bonus_cashback' THEN k.nominal ELSE 0 END) as bonus_cashback,
                    SUM(CASE WHEN k.type = 'bonus_generasi' THEN k.nominal ELSE 0 END) as bonus_generasi,
                    SUM(CASE WHEN k.type = 'bonus_upline' THEN k.nominal ELSE 0 END) as bonus_upline,
                    SUM(CASE WHEN k.type = 'bonus_royalti_omset' THEN k.nominal ELSE 0 END) as bonus_royalti_omset,
                    SUM(k.nominal) as nominal,
                    (SUM(k.nominal)*$admin/100) as admin,
                    (SUM(k.nominal) - (SUM(k.nominal)*$admin/100)) as total,
                    MAX(k.created_at) AS created_at,
                    k.status_transfer,
                    k.updated_at
                FROM ($sql) k
                LEFT JOIN mlm_member m 
                ON k.id_member = m.id
                LEFT JOIN mlm_bank b 
                ON m.id_bank = b.id
                WHERE LEFT(k.created_at, 10) <= '$tanggal'";
        return $sql;
    }

    public function datatable_transfer($request, $tanggal, $admin){
        $sort_column =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'm.cabang_rekening',
            'bonus_sponsor',
            'bonus_cashback',
            'bonus_generasi',
            'bonus_upline',
            'bonus_royalti_omset',
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
            $sql  = $this->_SQL_ALL_REKENING($sql, $tanggal, $admin);
        
        $group = " GROUP BY k.id_member
                        HAVING nominal >= 10000 ";

        $c = new classConnection();
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;
        
        $sql1 = "SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b";
        $total_admin = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b";
        $total_transfer = $c->_query_fetch($sql3)->total;
        
        if(!empty($request['search']['value'])){
            $sql.=" AND (";
            foreach ($data_search as $key => $value) {
                if($key > 0){
                    $sql.=" OR ";
                }
                $sql.="$value LIKE '%".$request['search']['value']."%'";
            }
            $sql.=")";
        }
        $sql_group = $sql.$group;
        $query 	= $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        $sql_group.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while($row = $query->fetch_object()){
            
            $no++;
            $subdata=array();
            $subdata[] = $no;
            // $subdata[] = $row->id;
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = $row->cabang_rekening;
            $subdata[] = currency($row->bonus_sponsor);
            $subdata[] = currency($row->bonus_cashback);
            $subdata[] = currency($row->bonus_generasi);
            $subdata[] = currency($row->bonus_upline);
            $subdata[] = currency($row->bonus_royalti_omset);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $aksi = '<button type="button" class="btn btn-danger btn-xs" onclick="reject('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-times"></i> Reject</button>
                     <button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>
                     ';
            $subdata[] = $aksi;
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "total_admin"       =>  rp($total_admin),
            "total_transfer"    =>  rp($total_transfer),
            "data"              =>  $data
        );
        return $json_data;
    }

    public function datatable_laporan($request, $admin){
        $sort_column =array(
            'k.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'm.cabang_rekening',
            'bonus_sponsor',
            'bonus_cashback',
            'bonus_generasi',
            'bonus_upline',
            'bonus_royalti_omset',
            'admin',
            'total',
            'k.updated_at',
            'k.id'
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'm.no_rekening',
            'm.atas_nama_rekening'
            );
            
            $sql = $this->_SQL_TRANSFER_ALL(1);
            $sql  = "SELECT 
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
                        SUM(CASE WHEN k.type = 'bonus_sponsor' THEN k.nominal ELSE 0 END) as bonus_sponsor,
                        SUM(CASE WHEN k.type = 'bonus_cashback' THEN k.nominal ELSE 0 END) as bonus_cashback,
                        SUM(CASE WHEN k.type = 'bonus_generasi' THEN k.nominal ELSE 0 END) as bonus_generasi,
                        SUM(CASE WHEN k.type = 'bonus_upline' THEN k.nominal ELSE 0 END) as bonus_upline,
                        SUM(CASE WHEN k.type = 'bonus_royalti_omset' THEN k.nominal ELSE 0 END) as bonus_royalti_omset,
                        SUM(k.nominal) as nominal,
                        SUM(k.admin) as admin,
                        SUM(k.total) as total,
                        k.status_transfer,
                        k.updated_at  
                    FROM ($sql) k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '1' ";
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
        
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;
        
        $sql1 = "SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b";
        $total_admin = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b";
        $total_transfer = $c->_query_fetch($sql3)->total;

        if(!empty($request['search']['value'])){
            $sql.=" AND (";
            foreach ($data_search as $key => $value) {
                if($key > 0){
                    $sql.=" OR ";
                }
                $sql.="$value LIKE '%".$request['search']['value']."%'";
            }
            $sql.=")";
        }
        $sql_group = $sql.$group;
        $query 	= $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        $sql_group .=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while($row = $query->fetch_object()){
            $no++;
            $subdata=array();
            $subdata[] = $no;
            // $subdata[] = $row->id;
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = $row->cabang_rekening;
            $subdata[] = currency($row->bonus_sponsor);
            $subdata[] = currency($row->bonus_cashback);
            $subdata[] = currency($row->bonus_generasi);
            $subdata[] = currency($row->bonus_upline);
            $subdata[] = currency($row->bonus_royalti_omset);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] =  $row->updated_at;
            $aksi = '<button type="button" class="btn btn-teal btn-xs" onclick="send_notif('."'".$row->id."', '".$row->updated_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Send Notif</button>';
            $subdata[] = $aksi;
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "total_admin"       =>  rp($total_admin),
            "total_transfer"    =>  rp($total_transfer),
            "data"              =>  $data
        );
        return $json_data;
    }

    public function datatable_reject($request, $tanggal, $admin){
        $sort_column =array(
            'k.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'm.no_rekening',
            'bonus_sponsor',
            'bonus_cashback',
            'bonus_generasi',
            'bonus_upline',
            'bonus_royalti_omset',
            'admin',
            'total',
            'k.id'
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.nama_bank',
            'm.no_rekening',
            'm.atas_nama_rekening'
            );
            
            $sql = $this->_SQL_TRANSFER_ALL(2);
            $sql  = "SELECT 
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
                        SUM(CASE WHEN k.type = 'bonus_sponsor' THEN k.nominal ELSE 0 END) as bonus_sponsor,
                        SUM(CASE WHEN k.type = 'bonus_cashback' THEN k.nominal ELSE 0 END) as bonus_cashback,
                        SUM(CASE WHEN k.type = 'bonus_generasi' THEN k.nominal ELSE 0 END) as bonus_generasi,
                        SUM(CASE WHEN k.type = 'bonus_upline' THEN k.nominal ELSE 0 END) as bonus_upline,
                        SUM(CASE WHEN k.type = 'bonus_royalti_omset' THEN k.nominal ELSE 0 END) as bonus_royalti_omset,
                        SUM(k.nominal) as nominal,
                        (SUM(k.nominal)*$admin/100) as admin,
                        (SUM(k.nominal) - (SUM(k.nominal)*$admin/100)) as total,
                        k.status_transfer,
                        k.updated_at  
                    FROM ($sql) k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '2' ";
        $group = " GROUP BY k.id_member, k.updated_at ";
        $c = new classConnection();
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;
        
        $sql1 = "SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(admin), 0) as total FROM ($sql_group) as b";
        $total_admin = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total), 0) as total FROM ($sql_group) as b";
        $total_transfer = $c->_query_fetch($sql3)->total;

        if(!empty($request['search']['value'])){
            $sql.=" AND (";
            foreach ($data_search as $key => $value) {
                if($key > 0){
                    $sql.=" OR ";
                }
                $sql.="$value LIKE '%".$request['search']['value']."%'";
            }
            $sql.=")";
        }
        $sql_group = $sql.$group;
        $query 	= $c->_query($sql_group);
        $totalFilter = $query->num_rows;
        $sql_group .=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        // echo $sql;
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while($row = $query->fetch_object()){
            $no++;
            $subdata=array();
            $subdata[] = $no;
            // $subdata[] = $row->id;
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->bonus_sponsor);
            $subdata[] = currency($row->bonus_cashback);
            $subdata[] = currency($row->bonus_generasi);
            $subdata[] = currency($row->bonus_upline);
            $subdata[] = currency($row->bonus_royalti_omset);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="pending('."'".$row->id."', '".$row->updated_at."', '".$row->total."'".', this)"><i class="fas fa-check"></i> Pending</button>';
            $subdata[] = $aksi;
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "total_admin"       =>  rp($total_admin),
            "total_transfer"    =>  rp($total_transfer),
            "data"              =>  $data
        );
        return $json_data;
    }

    public function update_transfer($table, $id_member, $tanggal, $updated_at, $admin){
        $sql = "UPDATE $table 
                    SET status_transfer = '1', 
                    admin = nominal*$admin/100,
                    total = nominal - (nominal*$admin/100),
                    updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                    AND created_at <= '$tanggal'
                    AND status_transfer = '0'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_pending($table, $id_member, $tanggal, $updated_at){
        $sql = "UPDATE $table 
                SET status_transfer = '0', updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                AND created_at <= '$tanggal'
                AND status_transfer = '2'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_reject($table, $id_member, $tanggal, $updated_at){
        $sql = "UPDATE $table 
                SET status_transfer = '2', updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                AND created_at <= '$tanggal'
                AND status_transfer = '0'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }
}