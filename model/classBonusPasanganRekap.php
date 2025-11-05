<?php 
require_once 'classConnection.php';

class classBonusPasanganRekap{

    public function datatable($request){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'k.total_hu',
            'k.total_terpasang',
            'k.bonus_pasangan',
            'k.index_pasangan',
            'k.nominal_bonus'
        );

        $data_search =array(
            'k.id',
            'm.created_at'
            );

            $sql  = "SELECT k.*
                    FROM mlm_bonus_pasangan_rekap k
                    WHERE k.deleted_at IS NULL ";

        $c = new classConnection();
        $query = $c->_query($sql);
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
        $query 	= $c->_query($sql);
        $totalFilter = $query->num_rows;
        $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql);
        $data=array();
        $no = $request['start'];
        while($row = $query->fetch_object()){
            $no++;
            $subdata=array();
            $subdata[] = $no;       
            $subdata[] = $row->created_at;     
            $subdata[] = currency($row->total_hu);
            $subdata[] = currency($row->total_terpasang);
            $subdata[] = currency($row->bonus_pasangan);
            $subdata[] = decimal($row->index_pasangan);
            $subdata[] = currency($row->nominal_bonus);
            $data[]    = $subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return $json_data;
    }
}