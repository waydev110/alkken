<?php 
    require_once ("../../helper/string.php");
    require_once 'classConnection.php';

    class classLaporan{
        
        public function datatable($request){
            $sort_column =array(
                'w.id',
                'm.id_member',
                'm.nama_member',
                'w.created_at',
                'asal_bonus',
                'cash',
                'autosave',
                'admin',
                'jumlah',
                'w.id',
                );

            $data_search =array(
                'w.created_at',
                'm.id_member',
                'm.nama_member'
                );

                $sql  = "SELECT 
                            w.id_kodeaktivasi,
                            m.id_member,
                            m.nama_member,
                            w.created_at,
                            w.type,
                            SUM(CASE WHEN w.jenis_saldo = 'cash' THEN w.nominal ELSE 0 END) AS nominal_cash,
                            SUM(CASE WHEN w.jenis_saldo = 'poin' THEN w.nominal ELSE 0 END) AS nominal_poin,
                            SUM(CASE WHEN w.jenis_saldo = 'admin' THEN w.nominal ELSE 0 END) AS nominal_admin,
                            COALESCE(SUM(w.nominal), 0) AS jumlah
                            FROM mlm_wallet w
                            LEFT JOIN mlm_member m ON w.id_member = m.id
                            WHERE w.status = 'd' 
                            AND w.deleted_at IS NULL";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;

            // if(is_numeric($request['id_paket'])){
            //     $sql.=" AND m.id_plan = '".$request['id_paket']."' ";
            // }
            if(!empty($request['asal_bonus'])){
                $sql.=" AND w.type = '".$request['asal_bonus']."' ";
            }
            // if(!empty($request['start_date'])){
            //     $start_date = str_replace('T', ' ', $request['start_date']) . ':00';
            //     $sql.=" AND LEFT(w.created_at, 10) >= '$start_date' ";
            // }
            // if(!empty($request['end_date'])){
            //     $end_date = str_replace('T', ' ', $request['end_date']) . ':00';
            //     $sql.=" AND LEFT(w.created_at, 10) <= '$end_date' ";
            // }
            if(!empty($request['start_date'])){
                $start_date = $request['start_date'];
                $sql.=" AND LEFT(w.created_at, 10) >= '$start_date' ";
            }
            if(!empty($request['end_date'])){
                $end_date = $request['end_date'];
                $sql.=" AND LEFT(w.created_at, 10) <= '$end_date' ";
            }

            if(!empty($request['keyword'])){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$request['keyword']."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }

            $sql1 = "SELECT COALESCE(SUM(nominal_cash), 0) AS total FROM ($sql) AS s";
            $cash 	= $c->_query_fetch($sql1)->total;
            $sql2 = "SELECT COALESCE(SUM(nominal_poin), 0) AS total FROM ($sql) AS s";
            $poin 	= $c->_query_fetch($sql2)->total;
            $sql3 = "SELECT COALESCE(SUM(nominal_admin), 0) AS total FROM ($sql) AS s";
            $admin 	= $c->_query_fetch($sql3)->total;
            

            $sql .= " GROUP BY w.id_kodeaktivasi, m.id_member, m.nama_member, w.created_at, w.type";

            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
            if($request['length'] > 0){
                $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
            }
            // echo $sql;
            $query 	= $c->_query($sql);
            $data=array();
            $no = $request['start'];
            while($row = $query->fetch_object()){
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = $row->created_at;
                $subdata[] = type($row->type);
                $subdata[] = $row->id_member;
                $subdata[] = $row->nama_member;
                $subdata[] = currency($row->nominal_cash);
                $subdata[] = currency($row->nominal_poin);
                $subdata[] = currency($row->nominal_admin);
                $subdata[] = currency($row->jumlah);
                $data[]    = $subdata;
            }
            

            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "cash"              =>  rp($cash),
                "poin"              =>  rp($poin),
                "admin"             =>  rp($admin),
                "data"              =>  $data
            );
            return $json_data;
        }
    }
?>