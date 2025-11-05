<?php
require_once "classConnection.php";

class classMemberRO {
    public function datatable($request){
        $c = new classConnection();

        $col = [
                    'a.id', 
                    'a.id_paket', 
                    'a.id_member', 
                    'a.nama_member', 
                    'a.id',
                    'a.id',
                    'a.id',
                    'a.id'];  
        $data_search =array(
            'a.id',
            'a.id_member',
            'a.nama_member',
            'a.nama_samaran'
            );
        
        $sql ="SELECT 
                    a.id_member, 
                    a.nama_member,
                    a.nama_samaran,  
                    pl.nama_plan, 
                    COUNT(h.id_member) AS jumlah_ro,
                    COALESCE(SUM(k.harga), 0) AS nominal_ro,
                    MIN(h.created_at) AS tgl_awal,
                    MAX(h.created_at) AS tgl_terbaru
                FROM mlm_kodeaktivasi_history h 
                LEFT JOIN mlm_member a ON h.id_member = a.id 
                LEFT JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                LEFT JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                WHERE pl.jenis_plan = '1'";
        $query  = $c->_query($sql);

        $totalData=$query->num_rows;

        if(!empty($request['start_date'])){
            $start_date = date('Y-m-d', strtotime($request['start_date']));
            $sql .=" AND h.created_at >= '".$start_date."' ";
        }
        if(!empty($request['end_date'])){
            $end_date = date('Y-m-d', strtotime($request['end_date']));
            $sql .=" AND h.created_at <= '".$end_date."' ";
        }

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

        $sql .=" GROUP BY h.id_member";

        $query  = $c->_query($sql);

        $totalFilter=$query->num_rows;
        $sql .=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql .="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        $query  = $c->_query($sql);
        $data=array();

        $no = $request['start'];
        $total_bonus = 0;
        $total_admin = 0;
        $total_transfer = 0;
        while($row = $query->fetch_object()){
            $total_bonus += $row->nominal;
            $total_admin += $row->admin;
            $total_transfer += $row->total;
            $no++;
            $subdata=array();      
            $subdata[]= $no; //id     
            $subdata[]= $row->nama_paket;
            $subdata[]= $row->id_member;
            $subdata[]= $row->nama_samaran;
            $subdata[]= $row->tgl_awal;
            $subdata[]= $row->tgl_terbaru;
            $subdata[]= currency($row->jumlah_ro);
            $subdata[]= currency($row->nominal_ro);
            $subdata[]='<a target="_blank" href="index.php?go=bypass_login&id='.base64_encode($row->id).'" class="btn btn-danger btn-xs bypass"><i class="fa fa-sign-in"></i></a>';
            $data[]=$subdata;
        }

        $json_data=array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return json_encode($json_data);
    }
}
