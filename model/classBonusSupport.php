<?php 
require_once 'classConnection.php';

class classBonusSupport{

    private $id;
    private $id_member;
    private $nominal;
    private $status_transfer;
    private $id_bonus;
    private $bonus_ke;
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

	public function get_id_bonus(){
		return $this->id_bonus;
	}

	public function set_id_bonus($id_bonus){
		$this->id_bonus = $id_bonus;
	}

	public function get_bonus_ke(){
		return $this->bonus_ke;
	}

	public function set_bonus_ke($bonus_ke){
		$this->bonus_ke = $bonus_ke;
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
    
    public function create()
    {
        $sql =
            "INSERT INTO mlm_bonus_support (
                    id_member, 
                    nominal, 
                    status_transfer, 
                    id_bonus, 
                    bonus_ke, 
                    keterangan, 
                    created_at
                ) values (
                    '".$this->get_id_member()."',
                    '".$this->get_nominal()."',
                    '".$this->get_status_transfer()."',
                    '".$this->get_id_bonus()."',
                    '".$this->get_bonus_ke()."',
                    '".$this->get_keterangan()."',
                    '".$this->get_created_at()."'
                )";
        $c = new classConnection();
        $query = $c->_query_insert($sql);
        return $query;
    }
    
    public function create_bonus($id_member,$id_autosave,$periode,$nominal,$created_at) {
        $sql = "INSERT INTO mlm_bonus_support_member (
                    id_member, 
                    id_autosave, 
                    periode, 
                    nominal, 
                    created_at
                ) values (
                    '$id_member',
                    '$id_autosave',
                    '$periode',
                    '$nominal',
                    '$created_at'
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
            'k.bonus_ke',
            'k.status_transfer',
            );

        $data_search =array(
            'k.id',
            'm.id_member',
            'm.nama_member'
            );

            $sql  = "SELECT 
                        k.id,
                        m.id_member,
                        m.nama_member,
                        k.nominal,
                        k.bonus_ke,
                        k.keterangan,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_bonus_support k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
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
            $subdata[] = $row->bonus_ke;
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
                        (SUM(k.nominal)*$admin) as admin,
                        SUM(k.nominal) - (SUM(k.nominal)*$admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_support k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '0'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
                    AND LEFT(k.created_at, 10) <= '$tanggal'";

        $group = " GROUP BY k.id_member
                        HAVING total >= 100000 ";

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
                        (SUM(k.nominal)*$admin) as admin,
                        SUM(k.nominal) - (SUM(k.nominal)*$admin) as total,
                        MAX(k.created_at) AS created_at,
                        k.updated_at
                    FROM mlm_bonus_support k
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
            $aksi = $row->updated_at;
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


    public function update_transfer($id_member, $tanggal, $updated_at)
    {
        $sql = "UPDATE mlm_bonus_support 
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
                    FROM mlm_bonus_support k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.dari_member = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'
                    AND k.jenis_bonus = '0'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

    public function rekap_bonus($tgl_rekap)
    {
        $sql = "SELECT s.id_member, SUM(s.nominal) AS nominal 
                    FROM mlm_bonus_support s
                    LEFT JOIN mlm_member m
                    ON s.id_member = m.id
                    WHERE s.status_transfer = '0'
                    AND LEFT(s.created_at, 10) < '$tgl_rekap'
                    AND s.deleted_at IS NULL
                    GROUP BY s.id_member
                    ORDER BY s.id_member ASC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function update_rekap($tgl_rekap)
    {
        $sql = "UPDATE mlm_bonus_support s
                    SET s.status_transfer = '1', updated_at = '$tgl_rekap'
                    WHERE s.status_transfer = '0'
                    AND LEFT(s.created_at, 10) < '$tgl_rekap'
                    AND s.deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function index($id_member, $id_bonus){
		$sql  = "SELECT m.* FROM mlm_bonus_support_member m
                    WHERE m.id_member = '$id_member'
                    AND m.id_bonus = '$id_bonus'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

	public function show($id_member, $id_bonus, $tanggal){
		$sql  = "SELECT m.* 
                    FROM mlm_bonus_support m
                    WHERE m.id_bonus = '$id_bonus'
                    AND m.id_member = '$id_member'
                    AND LEFT(m.created_at, 10) = '$tanggal'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

    public function rekap_bonus_support($tgl_rekap)
    {
        $sql = "INSERT INTO mlm_bonus_support
                (
                    id_member,
                    nominal,
                    status_transfer,
                    id_bonus,
                    bonus_ke,
                    keterangan,
                    created_at
                )
                SELECT 
                    s.id_member,
                    s.nominal,
                    '0',
                    s.id,
                    (SELECT COUNT(*) FROM mlm_bonus_support WHERE id_member = s.id_member AND id_bonus = s.id) + 1,
                    CONCAT('Bonus Support ke-', (SELECT COUNT(*) FROM mlm_bonus_support WHERE id_member = s.id_member AND id_bonus = s.id) + 1),
                    '$tgl_rekap'
                FROM mlm_bonus_support_member s
                WHERE LEFT(created_at, 7) < LEFT('$tgl_rekap', 7)
                AND (SELECT COUNT(*) FROM mlm_bonus_support WHERE id_member = s.id_member AND id_bonus = s.id) < periode
                AND (SELECT COUNT(*) FROM mlm_bonus_support WHERE id_member = s.id_member AND id_bonus = s.id AND LEFT(created_at, 7) = LEFT('$tgl_rekap', 7)) = 0 
                ";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
}