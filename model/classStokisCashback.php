<?php 
require_once 'classConnection.php';

class classStokisCashback{

    private $id;
    private $id_stokis;
    private $nominal;
    private $status_transfer;
    private $id_transaksi;
    private $created_at;
    private $updated_at;
    private $deleted_at;    

    public function get_id(){
		return $this->id;
	}

	public function set_id($id){
		$this->id = $id;
	}
    
    public function get_id_stokis(){
		return $this->id_stokis;
	}

	public function set_id_stokis($id_stokis){
		$this->id_stokis = $id_stokis;
	}
    
    public function get_nominal(){
		return $this->nominal;
	}

	public function set_nominal($nominal){
		$this->nominal = $nominal;
	}
    
    public function get_status_transfer(){
		return $this->status_transfer;
	}

	public function set_status_transfer($status_transfer){
		$this->status_transfer = $status_transfer;
	}
    
    public function get_id_transaksi(){
		return $this->id_transaksi;
	}

	public function set_id_transaksi($id_transaksi){
		$this->id_transaksi = $id_transaksi;
	}
    
    public function get_created_at(){
		return $this->created_at;
	}

	public function set_created_at($created_at){
		$this->created_at = $created_at;
	}
    
    public function get_updated_at(){
		return $this->updated_at;
	}

	public function set_updated_at($updated_at){
		$this->updated_at = $updated_at;
	}
    
    public function get_deleted_at(){
		return $this->deleted_at;
	}

	public function set_deleted_at($deleted_at){
		$this->deleted_at = $deleted_at;
	}

    public function persentase_bonus_sponsor($id_stokis){
        
        $sql = "SELECT p.persentase_bonus FROM mlm_stokis_member m
                        LEFT JOIN mlm_stokis_cashback_setting p ON m.id_peringkat = p.id_peringkat
                        WHERE m.id = '$id_stokis'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->persentase_bonus;
    }
    
    public function create()
    {
        $sql =
            "INSERT INTO mlm_stokis_cashback (
                    id_stokis,
                    nominal,
                    status_transfer,
                    id_transaksi,
                    created_at
                ) values (
                    '".$this->get_id_stokis()."', 
                    '".$this->get_nominal()."',
                    '".$this->get_status_transfer()."',
                    '".$this->get_id_transaksi()."',   
                    '".$this->get_created_at()."'
                )";
        $c = new classConnection();
        $query = $c->_query_insert($sql);
        return $query;
    }

    public function datatable($request){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'm.id_stokis',
            'm.nama_stokis',
            'nominal',
            'k.dari_member',
            'k.status_transfer',
            );

        $data_search =array(
            'k.id',
            'm.id_stokis',
            'm.nama_stokis',
            'd.id_stokis'
            );

            $sql  = "SELECT 
                        k.id,
                        m.id_stokis,
                        m.nama_stokis,
                        k.nominal,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_stokis_cashback k
                    LEFT JOIN mlm_stokis_member m 
                    ON k.id_stokis = m.id
                    LEFT JOIN mlm_stokis_rekening r 
                    ON r.id_stokis = m.id
                    LEFT JOIN mlm_bank b 
                    ON r.id_bank = b.id
                    WHERE k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
                    AND k.status_transfer = '0'
                    AND k.nominal > 0";

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
            $subdata[] = $row->id_stokis;
            $subdata[] = $row->nama_stokis;
            $subdata[] = currency($row->nominal);
            $subdata[] = status_transfer($row->status_transfer);
            if($row->status_transfer == 0){
                $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->created_at."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>';
            } else {
                $aksi = $row->updated_at;
            }
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

    public function datatable_transfer($request, $tanggal, $admin){
        $sort_column =array(
            'k.id',
            'm.id',
            'b.nama_bank',
            'b.kode_bank',
            'r.no_rekening',
            'nominal',
            'admin',
            'total',
            'k.id',
            );

        $data_search =array(
            'k.id',
            'm.id_stokis',
            'm.nama_stokis'
            );

            $sql  = "SELECT 
                        m.id,
                        m.id_stokis,
                        m.nama_stokis,
                        r.id as id_rekening,
                        b.nama_bank,
                        b.kode_bank,
                        r.no_rekening,
                        r.atas_nama_rekening,
                        r.cabang_rekening,
                        SUM(k.nominal) as nominal,
                        $admin as admin,
                        (SUM(k.nominal) - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_stokis_cashback k
                    LEFT JOIN mlm_stokis_member m 
                    ON k.id_stokis = m.id
                    LEFT JOIN mlm_stokis_rekening r 
                    ON r.id_stokis = m.id
                    LEFT JOIN mlm_bank b 
                    ON r.id_bank = b.id
                    WHERE k.status_transfer = '0'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
                    AND r.main_rekening = '1'
                    AND LEFT(k.created_at, 10) <= '$tanggal'";

        $group = ' GROUP BY k.id_stokis HAVING total > 100000 ';

        $c = new classConnection();
        $query = $c->_query($sql.$group);
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
        $sql = $sql.$group;
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
            // $subdata[] = $row->id;
            $subdata[] = $row->id_stokis;
            $subdata[] = $row->nama_stokis;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->id_rekening."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>';
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

    public function datatable_laporan($request, $tanggal, $admin){
        $sort_column =array(
            'k.id',
            'm.id',
            'b.nama_bank',
            'b.kode_bank',
            'r.no_rekening',
            'nominal',
            'admin',
            'total',
            'k.updated_at',
            );

        $data_search =array(
            'k.id',
            'm.id_stokis',
            'm.nama_stokis'
            );

            $sql  = "SELECT 
                        m.id,
                        m.id_stokis,
                        m.nama_stokis,
                        b.nama_bank,
                        b.kode_bank,
                        r.no_rekening,
                        r.atas_nama_rekening,
                        r.cabang_rekening,
                        SUM(k.nominal) as nominal,
                        $admin as admin,
                        (SUM(k.nominal) - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_stokis_cashback k
                    LEFT JOIN mlm_stokis_member m 
                    ON k.id_stokis = m.id
                    LEFT JOIN mlm_stokis_rekening r 
                    ON k.id_rekening = r.id
                    LEFT JOIN mlm_bank b 
                    ON r.id_bank = b.id
                    WHERE k.status_transfer = '1'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL";
        $group = ' GROUP BY k.id_stokis, k.updated_at ';

        $c = new classConnection();
        $query = $c->_query($sql.$group);
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
        $sql = $sql.$group;
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
            // $subdata[] = $row->id;
            $subdata[] = $row->id_stokis;
            $subdata[] = $row->nama_stokis;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
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


    public function update_transfer($id_stokis, $id_rekening, $tanggal, $updated_at)
    {
        $sql = "UPDATE mlm_stokis_cashback 
                SET updated_at = '$updated_at', status_transfer = '1', id_rekening = '$id_rekening'
                WHERE id_stokis = '$id_stokis' AND status_transfer = '0'                 
                AND LEFT(created_at, 10) <= '$tanggal'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function history($id_transaksi){
		$sql  = "SELECT k.*, 
                        m.id_stokis, 
                        m.nama_stokis
                    FROM mlm_stokis_cashback k
                    LEFT JOIN mlm_stokis_member m ON k.id_stokis = m.id
                    WHERE k.id_transaksi = '$id_transaksi'
                    AND k.jenis_bonus = '0'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}
}