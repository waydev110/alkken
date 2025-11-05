<?php 
require_once 'classConnection.php';

class classBonusMatchingGenerasi{

    private $id;
    private $id_member;
    private $nominal;
    private $status_transfer;
    private $dari_member;
    private $id_kodeaktivasi;
    private $jenis_bonus;
    private $generasi;
    private $keterangan;
    private $created_at;
    private $updated_at;
    private $deleted_at;    

    public function get_id(){
		return $this->id;
	}

	public function set_id($id){
		$this->id = $id;
	}
    
    public function get_id_member(){
		return $this->id_member;
	}

	public function set_id_member($id_member){
		$this->id_member = $id_member;
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
    
    public function get_dari_member(){
		return $this->dari_member;
	}

	public function set_dari_member($dari_member){
		$this->dari_member = $dari_member;
	}
    
    public function get_id_kodeaktivasi(){
		return $this->id_kodeaktivasi;
	}

	public function set_id_kodeaktivasi($id_kodeaktivasi){
		$this->id_kodeaktivasi = $id_kodeaktivasi;
	}
    
    public function get_jenis_bonus(){
		return $this->jenis_bonus;
	}

	public function set_jenis_bonus($jenis_bonus){
		$this->jenis_bonus = $jenis_bonus;
	}
    
    public function get_generasi(){
		return $this->generasi;
	}

	public function set_generasi($generasi){
		$this->generasi = $generasi;
	}
    
    public function get_keterangan(){
		return $this->keterangan;
	}

	public function set_keterangan($keterangan){
		$this->keterangan = $keterangan;
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
    
    public function delete($id_kodeaktivasi, $jenis_bonus)
    {
        $sql = "DELETE FROM mlm_bonus_generasi 
                    WHERE id_kodeaktivasi = '$id_kodeaktivasi'
                    AND jenis_bonus = '$jenis_bonus'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function max_generasi($harga)
    {
        $sql = "SELECT max FROM mlm_bonus_generasi_setting 
                    WHERE harga <= '$harga'
                    ORDER BY harga DESC
                    LIMIT 1";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->max;
        }
        return 0;
    }

    public function persentase_generasi($generasi)
    {
        $sql = "SELECT persentase FROM mlm_bonus_generasi_persentase 
                    WHERE generasi = '$generasi' LIMIT 1";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->persentase;
        }
        return 0;
    }

    public function datatable($request, $jenis_bonus){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'm.id',
            'm.nama_member',
            'k.nominal',
            'k.dari_member',
            'k.generasi',
            'k.id',
            );

        $data_search =array(
            'k.id',
            'm.id_member',
            'm.nama_member',
            'k.keterangan'
            );

            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        m.nama_samaran,
                        k.generasi,
                        k.nominal,
                        k.keterangan,
                        k.jenis_bonus,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at,
                        d.id_member as dari_member
                    FROM mlm_bonus_generasi k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_member d 
                    ON k.dari_member = d.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.deleted_at IS NULL
                    AND k.jenis_bonus = '$jenis_bonus'
                    AND k.status_transfer = '0'
                    AND m.deleted_at IS NULL";

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
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = currency($row->nominal);
            $subdata[] = $row->dari_member;
            $subdata[] = $row->generasi;
            // $subdata[] = $row->status_transfer == 0 && $row->qualified == 0 ? '<strong class="text-red">Belum Qualified</strong>' : status_transfer($row->status_transfer);
            $subdata[] = status_transfer($row->status_transfer);
            $data[]    =$subdata;
        }
    
        $json_data = array(
            "draw"              =>  intval($request['draw']),
            "recordsTotal"      =>  intval($totalData),
            "recordsFiltered"   =>  intval($totalFilter),
            "data"              =>  $data
        );
        return $json_data;
    }

    public function datatable_transfer($request, $tanggal, $admin, $jenis_bonus){
        $sort_column =array(
            'm.id',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'nominal',
            'admin',
            'total',
            'm.id',
            );

        $data_search =array(
            'm.id_member',
            'm.nama_member'
            );

            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        b.nama_bank,
                        b.kode_bank,
                        m.no_rekening,
                        m.atas_nama_rekening,
                        m.cabang_rekening,
                        SUM(k.nominal) as nominal,
                        $admin as admin,
                        (k.nominal - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_generasi k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '0'
                    AND k.jenis_bonus = '$jenis_bonus'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL 
                    AND LEFT(k.created_at, 10) <= '$tanggal' ";

        $group = " GROUP BY k.id_member
        HAVING nominal > 40000 ";

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
            $subdata[] = $row->nama_member.' ('.$row->id_member.')';
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->created_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>';
            $subdata[] = $aksi;
            $data[]    =$subdata;
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

    public function datatable_laporan($request, $admin, $jenis_bonus){
        $sort_column =array(
            'k.updated_at',
            'm.nama_member',
            'b.nama_bank',
            'b.kode_bank',
            'm.no_rekening',
            'nominal',
            'admin',
            'total',
            'k.updated_at',
            );

        $data_search =array(
            'm.id_member',
            'm.nama_member'
            );

            $sql  = "SELECT 
                        m.id,
                        m.id_member,
                        m.nama_member,
                        b.nama_bank,
                        b.kode_bank,
                        m.no_rekening,
                        m.atas_nama_rekening,
                        m.cabang_rekening,
                        SUM(k.nominal) as nominal,
                        $admin as admin,
                        (k.nominal - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_generasi k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '1'
                    AND k.jenis_bonus = '$jenis_bonus'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL";
                    
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
        $sql_group.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
        $query 	= $c->_query($sql_group);
        $data=array();
        $no = $request['start'];
        while($row = $query->fetch_object()){
            $no++;
            $subdata=array();
            $subdata[] = $no;
            // $subdata[] = $row->id;
            $subdata[] = $row->nama_member.' ('.$row->id_member.')';
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] =  $row->updated_at;
            $aksi = '<button type="button" class="btn btn-teal btn-xs" onclick="send_notif('."'".$row->id."', '".$row->updated_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Send Notif</button>';
            $subdata[] = $aksi;
            $data[]    =$subdata;
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


    public function update_transfer($id_member, $tanggal, $updated_at, $jenis_bonus)
    {
        $sql = "UPDATE mlm_bonus_generasi k 
                SET k.updated_at = '$updated_at', k.status_transfer = '1'
                WHERE k.id_member = '$id_member' 
                AND k.jenis_bonus = '$jenis_bonus'
                AND k.status_transfer = '0'                 
                AND LEFT(k.created_at, 10) <= '$tanggal'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function history($id_kodeaktivasi, $jenis_bonus){
		$sql  = "SELECT k.*, 
                        m.id_member, 
                        m.nama_member,
                        d.id_member as dari_member
                    FROM mlm_bonus_generasi k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.dari_member = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'
                    AND k.jenis_bonus = '$jenis_bonus'
                    ORDER BY k.id ASC";	
		$c    = new classConnection();
		$query  = $c->_query($sql);
		return $query;
	}
    

    public function create($dari_member, $id_member, $nama_samaran, $nominal, $jenis_bonus, $id_kodeaktivasi, $max, $created_at){        
        $c = new classConnection();   
        $sql ="CALL GenerasiSponsorWithMax($dari_member, $max)";
        $query = $c->_query($sql);
        $total_record = $query->num_rows;
        if($total_record > 0){
            while($row = $query->fetch_object()){
                $sponsor = $row->sponsor;
                $generasi = $row->generasi;
                $persentase = $row->persentase;
                if($persentase > 0){
                    $nominal_bonus = floor($nominal * $persentase/100);
                    if($jenis_bonus == 0){
                        $keterangan = 'Royalti Generasi dari '.$nama_samaran.' ('.$id_member.') Generasi ke-'.$generasi;
                    } else if($jenis_bonus == 1){
                        $keterangan = 'Royalti RO dari '.$nama_samaran.' ('.$id_member.') Generasi ke-'.$generasi;
                    } else {
                        $keterangan = 'Generasi THR dari '.$nama_samaran.' ('.$id_member.') Generasi ke-'.$generasi;
                    }
                    
                    if($this->cek_bonus($sponsor, $id_kodeaktivasi, $jenis_bonus) == 0){
                        $sql = "INSERT INTO mlm_bonus_generasi (
                                id_member,
                                nominal,
                                status_transfer,
                                dari_member,
                                id_kodeaktivasi,
                                jenis_bonus,
                                generasi,
                                keterangan,
                                created_at
                            ) values (
                                '$sponsor', 
                                '$nominal_bonus',
                                '0',
                                '$dari_member',
                                '$id_kodeaktivasi',       
                                '$jenis_bonus',           
                                '$generasi',     
                                '$keterangan',       
                                '$created_at'
                            )";
                        $c->_query($sql);
                    }
                }
            }
        }
        return true;
    }

    public function cek_bonus($id_member, $id_kodeaktivasi, $jenis_bonus)
    {
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_bonus_generasi 
                    WHERE id_member = '$id_member' 
                    AND id_kodeaktivasi = '$id_kodeaktivasi' 
                    AND jenis_bonus = '$jenis_bonus'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->total;
        }
        return 0;
    }
}