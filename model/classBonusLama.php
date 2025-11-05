<?php 
require_once 'classConnection.php';

class classBonusLama{


    public function datatable($request){
        $sort_column =array(
            'b.id',
            'm.id_member',
            'b.idmember',
            'm.nama_member',
            'b.type',
            'b.amount',
            'b.regdate',
            'b.note'
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.idmember'
            );
            
            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        b.idmember AS user_member,
                        b.type,
                        SUM(b.amount) AS amount,
                        b.regdate,
                        b.note  
                    FROM backup_bonus b
                    JOIN mlm_member m 
                    ON b.member_id = m.id ";
        if(isset($request['groupby']) && $request['groupby'] <> ''){
            $group = " GROUP BY ".$request['groupby']." ";
        } else {
            $group = " GROUP BY b.id ";
        }
        $c = new classConnection();
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;
        $sql1 = "SELECT COALESCE(SUM(amount), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;

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
            $subdata[] = $row->user_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->type;
            $subdata[] = currency($row->amount);
            $subdata[] = $row->regdate;
            $subdata[] =  $row->note;
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "data"              =>  $data
        );
        return $json_data;
    }
    
    public function datatable_transfer($request){
        $sort_column =array(
            'b.id',
            'm.id_member',
            'b.idmember',
            'm.nama_member',
            'b.nama_bank',
            'b.pemilik_rekening',
            'b.no_rekening',
            'b.amount',
            'b.pay_date'
            );

        $data_search =array(
            'm.id',
            'm.id_member',
            'm.nama_member',
            'b.idmember',
            'b.nama_bank'
            );
            
            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        b.idmember AS user_member,
                        b.nama_bank,
                        b.pemilik_rekening,
                        b.no_rekening,
                        SUM(b.amount) AS amount,
                        b.pay_date
                    FROM backup_trfbonus_exe b
                    JOIN mlm_member m 
                    ON b.member_id = m.id ";
        if(isset($request['groupby']) && $request['groupby'] <> ''){
            $group = " GROUP BY ".$request['groupby']." ";
        } else {
            $group = " GROUP BY b.id ";
        }
        $c = new classConnection();
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;
        $sql1 = "SELECT COALESCE(SUM(amount), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;

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
            $subdata[] = $row->user_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->pemilik_rekening;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->amount);
            $subdata[] = $row->pay_date;
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "data"              =>  $data
        );
        return $json_data;
    }
    
    public function datatable_rekap($request){
        $sort_column =array(
            'b.id',
            'm.id_member',
            'b.idmember',
            'm.nama_member',
            'total_bonus',
            'total_autosave',
            'total_admin',
            'total_cash',
            'total_transfer',
            'total_pending'
            );

        $data_search =array(
            'm.id_member'
            );
            
            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        b.idmember AS user_member,
                        SUM(b.amount) AS total_bonus,
                        SUM(b.amount*0.2) AS total_autosave,
                        SUM(b.amount*0.1) AS total_admin,
                        SUM(b.amount*0.7) AS total_cash,
                        tbl_transfer.amount AS total_transfer,
                        COALESCE(SUM(b.amount*0.7) - COALESCE(tbl_transfer.amount, 0), 0) AS total_pending
                    FROM backup_bonus b
                    JOIN mlm_member m 
                    ON b.member_id = m.id 
                    LEFT JOIN (
                        SELECT member_id, SUM(amount) AS amount 
                        FROM backup_trfbonus_exe 
                        GROUP BY member_id
                    ) AS tbl_transfer ON b.member_id = tbl_transfer.member_id ";
        $group = " GROUP BY b.member_id ";
        $c = new classConnection();
        $sql_group = $sql.$group;
        $query = $c->_query($sql_group);
        $totalData=$query->num_rows;

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
        
        if(isset($request['batasan_pending']) && $request['batasan_pending'] <> ''){
            $sql_group .= " HAVING total_pending ".$request['batasan_pending']." ";
        }
        $sql1 = "SELECT COALESCE(SUM(total_bonus), 0) as total FROM ($sql_group) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(total_autosave), 0) as total FROM ($sql_group) as b";
        $total_autosave = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total_admin), 0) as total FROM ($sql_group) as b";
        $total_admin = $c->_query_fetch($sql3)->total;
        $sql4 = "SELECT COALESCE(SUM(total_cash), 0) as total FROM ($sql_group) as b";
        $total_cash = $c->_query_fetch($sql4)->total;
        $sql5 = "SELECT COALESCE(SUM(total_transfer), 0) as total FROM ($sql_group) as b";
        $total_transfer = $c->_query_fetch($sql5)->total;
        $sql6 = "SELECT COALESCE(SUM(total_pending), 0) as total FROM ($sql_group) as b";
        $total_pending = $c->_query_fetch($sql6)->total;
        
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
            $subdata[] = $row->user_member;
            $subdata[] = $row->nama_member;
            $subdata[] = currency($row->total_bonus);
            $subdata[] = currency($row->total_autosave);
            $subdata[] = currency($row->total_admin);
            $subdata[] = currency($row->total_cash);
            $subdata[] = currency($row->total_transfer);
            $subdata[] = currency($row->total_pending);
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "total_bonus"       =>  rp($total_bonus),
            "total_autosave"    =>  rp($total_autosave),
            "total_admin"       =>  rp($total_admin),
            "total_cash"        =>  rp($total_cash),
            "total_transfer"    =>  rp($total_transfer),
            "total_pending"     =>  rp($total_pending),
            "data"              =>  $data
        );
        return $json_data;
    }
}