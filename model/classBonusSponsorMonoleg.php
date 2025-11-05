<?php 
require_once 'classConnection.php';

class classBonusSponsorMonoleg{

    private $id;
    private $id_member;
    private $nominal;
    private $status_transfer;
    private $dari_member;
    private $id_kodeaktivasi;
    private $jenis_bonus;
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

    public function persentase_bonus_sponsor($id_member){
        
        $sql = "SELECT p.persentase_bonus FROM mlm_member m
                        LEFT JOIN mlm_bonus_sponsor_monoleg_setting p ON m.id_peringkat = p.id_peringkat
                        WHERE m.id = '$id_member'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->persentase_bonus;
    }
    
    public function create()
    {
        $sql =
            "INSERT INTO mlm_bonus_sponsor_monoleg (
                    id_member,
                    nominal,
                    status_transfer,
                    dari_member,
                    id_kodeaktivasi,
                    jenis_bonus,
                    keterangan,
                    created_at
                ) values (
                    '".$this->get_id_member()."', 
                    '".$this->get_nominal()."',
                    '".$this->get_status_transfer()."',
                    '".$this->get_dari_member()."',
                    '".$this->get_id_kodeaktivasi()."',       
                    '".$this->get_jenis_bonus()."',     
                    '".$this->get_keterangan()."',       
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
            'm.id_member',
            'm.nama_member',
            'nominal',
            'k.dari_member',
            'k.status_transfer',
            );

        $data_search =array(
            'k.id',
            'm.id_member',
            'm.nama_member',
            'd.id_member'
            );

            $sql  = "SELECT 
                        k.id,
                        m.id_member,
                        m.nama_member,
                        k.nominal,
                        k.keterangan,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at,
                        d.id_member as dari_member
                    FROM mlm_bonus_sponsor_monoleg k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_member d 
                    ON k.dari_member = d.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
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
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = currency($row->nominal);
            $subdata[] = $row->dari_member;
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
            'm.no_rekening',
            'nominal',
            'admin',
            'total',
            'k.id',
            );

        $data_search =array(
            'k.id',
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
                        (SUM(k.nominal) - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_sponsor_monoleg k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '0'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
                    AND LEFT(k.created_at, 10) <= '$tanggal'";

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
            'm.no_rekening',
            'nominal',
            'admin',
            'total',
            'k.updated_at',
            'k.id'
            );

        $data_search =array(
            'k.id',
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
                        (SUM(k.nominal) - $admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_sponsor_monoleg k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '1'
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


    public function update_transfer($id_member, $tanggal, $updated_at)
    {
        $sql = "UPDATE mlm_bonus_sponsor_monoleg 
                SET updated_at = '$updated_at', status_transfer = '1'
                WHERE id_member = '$id_member' AND status_transfer = '0'                 
                AND LEFT(created_at, 10) <= '$tanggal'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function history($id_kodeaktivasi){
		$sql  = "SELECT k.*, 
                        m.id_member, 
                        m.nama_member,
                        d.id_member as dari_member
                    FROM mlm_bonus_sponsor_monoleg k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.dari_member = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

    public function rekap_bonus($tgl_rekap)
    {
        $sql = "SELECT s.id_member, SUM(s.nominal) AS nominal, m.id_plan 
                    FROM mlm_bonus_sponsor_monoleg s
                    LEFT JOIN mlm_member m
                    ON s.id_member = m.id
                    WHERE s.status_transfer = '0'
                    AND s.created_at <= '$tgl_rekap'
                    AND s.deleted_at IS NULL
                    GROUP BY s.id_member
                    ORDER BY s.id_member ASC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function update_rekap($tgl_rekap)
    {
        $sql = "UPDATE mlm_bonus_sponsor_monoleg s
                    SET s.status_transfer = '1', updated_at = '$tgl_rekap'
                    WHERE s.status_transfer = '0'
                    AND s.created_at <= '$tgl_rekap'
                    AND s.deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM mlm_bonus_sponsor_monoleg WHERE id = '$id'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function count_bonus($id_member, $jenis_bonus)
    {
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_bonus_sponsor_monoleg s
                    WHERE s.id_member = '$id_member'
                    AND s.jenis_bonus = '$jenis_bonus'
                    AND s.deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function setting_sponsor_plan($id_plan)
    {        
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_bonus_sponsor_plan_setting
                    WHERE id_plan = '$id_plan'
                    AND deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function persentase_sponsor_plan($id_plan, $bonus_ke)
    {        
        $sql = "SELECT persentase_bonus 
                    FROM mlm_bonus_sponsor_plan_setting
                    WHERE id_plan = '$id_plan'
                    AND bonus_ke = '$bonus_ke'
                    AND deleted_at IS NULL
                    LIMIT 1";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function get_sponsor_monoleg($member_id)
    {        
        $sql ="CALL GenerasiSponsor($member_id)";
        $c = new classConnection();
        $generasi_sponsor = $c->_query($sql);
        $total_record = $generasi_sponsor->num_rows;                
        if($total_record > 0){
            while($row = $generasi_sponsor->fetch_object()){
                $sponsor = $row->sponsor;    
                $sponsori = $this->sponsori($sponsor);
                if($sponsori > 1){
                    return $sponsor;
                }
            }
        }
        return 0;
    }
    public function jumlah_poin_ro($id_member, $jenis_aktivasi)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_kodeaktivasi_history h
                WHERE h.id_member = '$id_member' 
                AND h.jenis_aktivasi = '$jenis_aktivasi'
                AND h.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }

    public function sponsori($sponsor)
    {
        $sql = "SELECT COALESCE(COUNT(id), 0) AS total 
                    FROM mlm_member
                    WHERE sponsor = '$sponsor'
                    AND reposisi = '0'";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
}