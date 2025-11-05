<?php 
require_once 'classConnection.php';

class classBonusReward{
    private $id;
    private $id_member;
    private $nominal;
    private $reward;
    private $poin;
    private $id_bonus_reward_setting;
    private $status_transfer ;
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
    
    public function get_reward(){
		return $this->reward;
	}

	public function set_reward($reward){
		$this->reward = $reward;
	}
    
    public function get_poin(){
		return $this->poin;
	}

	public function set_poin($poin){
		$this->poin = $poin;
	}
    
    public function get_id_bonus_reward_setting(){
		return $this->id_bonus_reward_setting;
	}

	public function set_id_bonus_reward_setting($id_bonus_reward_setting){
		$this->id_bonus_reward_setting = $id_bonus_reward_setting;
	}
    
    public function get_status_transfer(){
		return $this->status_transfer;
	}

	public function set_status_transfer($status_transfer){
		$this->status_transfer = $status_transfer;
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

	public function index(){
		$sql  = "SELECT r.*, s.gambar 
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s
                    ON r.id_bonus_reward_setting = s.id 
                    ORDER BY r.id DESC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

    public function cek_klaim_reward($id_bonus_reward_setting, $id_member){
        $sql = "SELECT * FROM mlm_bonus_reward
                WHERE id_member = '$id_member'
                AND id_bonus_reward_setting = '$id_bonus_reward_setting'";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        if($query->num_rows > 0){
            return true;
        }
        return false;
    }

	public function create(){
		$sql  = "INSERT INTO mlm_bonus_reward (
                        id,
                        id_member,
                        nominal,
                        reward,
                        poin,
                        id_bonus_reward_setting,
                        status_transfer,
                        keterangan,
                        created_at       
                    ) VALUES (
                        '".$this->get_id()."',
                        '".$this->get_id_member()."',
                        '".$this->get_nominal()."',
                        '".$this->get_reward()."',
                        '".$this->get_poin()."',
                        '".$this->get_id_bonus_reward_setting()."',
                        '".$this->get_status_transfer()."',
                        '".$this->get_keterangan()."',
                        '".$this->get_created_at()."'
                    )";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

    public function datatable($request){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'm.id_member',
            'm.nama_member',
            'pl.show_name',
            'k.reward',
            'k.nominal',
            'k.id',
            );

        $data_search =array(
            'k.id',
            'k.reward',
            'm.id_member',
            'm.nama_member'
            );

            $sql  = "SELECT 
                        k.id,
                        m.id as member_id,
                        m.id_member,
                        m.nama_member,
                        s.jenis,
                        pl.show_name,
                        k.reward,
                        k.nominal,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_bonus_reward k
                    LEFT JOIN mlm_bonus_reward_setting s 
                    ON k.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl 
                    ON s.id_plan = pl.id
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    WHERE k.deleted_at IS NULL
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
            $subdata[] = $row->show_name;
            $subdata[] = $row->reward;
            $subdata[] = currency($row->nominal);
            
            if($row->jenis == 0){
                $aksi = status_transfer($row->status_transfer);
            } else {
                $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="approve('."'".$row->id."', '".$row->member_id."', '".$row->created_at."', '".$row->nominal."', '".$row->reward."', '".$row->jenis."'".', this)"><i class="fas fa-paper-plane"></i> Approve</button>';
            }
            $subdata[] = $aksi;
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
                        k.id,
                        m.id as member_id,
                        m.id_member,
                        m.nama_member,
                        b.nama_bank,
                        b.kode_bank,
                        m.no_rekening,
                        m.atas_nama_rekening,
                        m.cabang_rekening,
                        k.nominal as nominal,
                        (SUM(k.nominal)*$admin/100) as admin,
                        (SUM(k.nominal) - (SUM(k.nominal)*$admin/100)) as total,
                        k.created_at,
                        k.updated_at,
                        k.keterangan
                    FROM mlm_bonus_reward k
                    LEFT JOIN mlm_bonus_reward_setting s 
                    ON k.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '0'
                    AND s.jenis = '0'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
                    HAVING nominal > 0";

        $c = new classConnection();
        $query = $c->_query($sql);
        $totalData=$query->num_rows;
        
        $sql1 = "SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(admin), 0) as total FROM ($sql) as b";
        $total_admin = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total), 0) as total FROM ($sql) as b";
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
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $aksi = '<button type="button" class="btn btn-primary btn-xs" onclick="transfer('."'".$row->id."', '".$row->member_id."', '".$row->created_at."', '".$row->total."', '".$row->keterangan."'".', this)"><i class="fas fa-paper-plane"></i> Transfer</button>';
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
                        k.nominal as nominal,
                        (SUM(k.nominal)*$admin/100) as admin,
                        (SUM(k.nominal) - (SUM(k.nominal)*$admin/100)) as total,
                        k.updated_at,
                        k.keterangan
                    FROM mlm_bonus_reward k
                    LEFT JOIN mlm_bonus_reward_setting s 
                    ON k.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '1'
                    AND s.jenis = '0'
                    AND k.deleted_at IS NULL
                    AND m.deleted_at IS NULL";

        $c = new classConnection();
        $query = $c->_query($sql);
        $totalData=$query->num_rows;

        $sql1 = "SELECT COALESCE(SUM(nominal), 0) as total FROM ($sql) as b";
        $total_bonus = $c->_query_fetch($sql1)->total;
        $sql2 = "SELECT COALESCE(SUM(admin), 0) as total FROM ($sql) as b";
        $total_admin = $c->_query_fetch($sql2)->total;
        $sql3 = "SELECT COALESCE(SUM(total), 0) as total FROM ($sql) as b";
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
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->nama_bank;
            $subdata[] = $row->kode_bank;
            $subdata[] = $row->no_rekening;
            $subdata[] = currency($row->nominal);
            $subdata[] = currency($row->admin);
            $subdata[] = currency($row->total);
            $subdata[] =  $row->updated_at;
            $aksi = '<button type="button" class="btn btn-teal btn-xs" onclick="send_notif('."'".$row->id."', '".$row->updated_at."', '".$row->total."', '".$row->keterangan."'".', this)"><i class="fas fa-paper-plane"></i> Send Notif</button>';
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

    public function datatable_approved($request, $tanggal, $admin){
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
                        k.reward,
                        k.nominal,
                        $admin as admin,
                        (k.nominal - $admin) as total,
                        k.updated_at
                    FROM mlm_bonus_reward k
                    LEFT JOIN mlm_bonus_reward_setting s 
                    ON k.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.status_transfer = '1'
                    AND s.jenis <> '0'
                    AND k.deleted_at IS NULL
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
            // $subdata[] = $row->id;
            $subdata[] = $row->id_member;
            $subdata[] = $row->nama_member;
            $subdata[] = $row->reward;
            $subdata[] = currency($row->nominal);
            $subdata[] =  $row->updated_at;
            $aksi = '<button type="button" class="btn btn-teal btn-xs" onclick="send_notif('."'".$row->id."', '".$row->updated_at."', '".$row->total."'".', this)"><i class="fas fa-paper-plane"></i> Send Notif</button>';
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

    public function update_transfer($id, $id_member, $tanggal, $updated_at)
    {
        $sql = "UPDATE mlm_bonus_reward
                SET updated_at = '$updated_at', status_transfer = '1'
                WHERE id = '$id' AND id_member = '$id_member' AND status_transfer = '0'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

	public function history($id_kodeaktivasi, $jenis_bonus){
		$sql  = "SELECT k.*, 
                        m.id_member, 
                        m.nama_member,
                        d.id_member as dari_member
                    FROM mlm_bonus_reward k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.dari_member = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'
                    AND k.jenis_bonus = '$jenis_bonus'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

	public function reset_poin($id_plan, $created_at){
		$c    = new classConnection();
		$sql  = "INSERT INTO mlm_member_poin_reward 
                (
                    id_member,
                    posisi,
                    poin,
                    id_kodeaktivasi,
                    id_plan,
                    type,
                    status,
                    created_at
                ) SELECT 
                    m.id_member,
                    'kiri',
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'd'  
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS reward_kiri, 
                    '0',
                    $id_plan,
                    'reset',
                    'k',
                    '$created_at' 
                    FROM mlm_member_poin_reward m
                    WHERE m.id_plan = '$id_plan'
                    AND m.deleted_at is null
                    GROUP BY m.id_member
                    HAVING reward_kiri > 0";	
		$query  = $c->_query($sql);
		$sql  = "INSERT INTO mlm_member_poin_reward 
                (
                    id_member,
                    posisi,
                    poin,
                    id_kodeaktivasi,
                    id_plan,
                    type,
                    status,
                    created_at
                ) SELECT 
                    m.id_member,
                    'kanan',
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'd' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS reward_kanan, 
                    '0',
                    $id_plan,
                    'reset',
                    'k',
                    '$created_at' 
                    FROM mlm_member_poin_reward m
                    WHERE m.id_plan = '$id_plan'
                    AND m.deleted_at is null
                    GROUP BY m.id_member
                    HAVING reward_kanan > 0";	
		$query  = $c->_query($sql);
		return $query;
	}

	public function reset_poin_pribadi($id_plan, $created_at){
		$c    = new classConnection();
		$sql  = "INSERT INTO mlm_member_poin_reward 
                (
                    id_member,
                    posisi,
                    poin,
                    id_kodeaktivasi,
                    id_plan,
                    type,
                    status,
                    created_at
                ) SELECT 
                    m.id_member,
                    '',
                    COALESCE(SUM(CASE 
                        WHEN m.status = 'd' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS poin_reward, 
                    '0',
                    $id_plan,
                    'reset',
                    'k',
                    '$created_at' 
                    FROM mlm_member_poin_reward m
                    WHERE m.id_plan = '$id_plan'
                    AND m.deleted_at is null
                    GROUP BY m.id_member
                    HAVING poin_reward > 0";	
		$query  = $c->_query($sql);
		return $query;
	}
    

    public function create_poin_binary($dari_member, $jumlah_hu, $id_kodeaktivasi, $id_plan, $wajib_ro, $jenis_posting, $created_at){
        $c = new classConnection();   
        $sql ="CALL GenerasiUpline($dari_member)";
        $generasi_upline = $c->_query($sql);
        $total_record = $generasi_upline->num_rows;
        if($total_record > 0){
            while($row = $generasi_upline->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                $kondisi = false;
                if($wajib_ro == 1){
                    $jumlah_poin_ro = $this->jumlah_poin_ro_reward($upline, $id_plan);
                    if($jumlah_poin_ro > 0){
                        $kondisi = true;
                    }
                } else {
                    $kondisi = true;
                }

                if($id_plan >= 1){
                    $kondisi = true;
                } else {
                    $kondisi = false;
                }
                
                if($kondisi == true){
                    $cek_poin_reward = $this->cek_poin_reward($upline, $id_kodeaktivasi, $id_plan, $posisi);
                    if($cek_poin_reward == 0){
                        $sql = "INSERT INTO mlm_member_poin_reward 
                                (id_member,
                                posisi,
                                poin,
                                id_kodeaktivasi,
                                id_plan,
                                type,
                                status,
                                created_at)
                                values
                                (
                                    '$upline',
                                    '$posisi',
                                    '$jumlah_hu',
                                    '$id_kodeaktivasi',
                                    '$id_plan',
                                    '$jenis_posting',
                                    'd',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                    }
                }
            }
        }
        return true;
    }
    public function rekap_reward_ro_aktif($dari_member, $jumlah_hu, $id_kodeaktivasi, $id_plan, $plan_reward, $wajib_ro, $jenis_posting, $bulan, $created_at){
        $c = new classConnection();   
        $sql ="CALL GenerasiUpline($dari_member)";
        $generasi_upline = $c->_query($sql);
        $total_record = $generasi_upline->num_rows;
        if($total_record > 0){
            while($row = $generasi_upline->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                $kondisi = false;
                if($wajib_ro == 1){
                
                    // echo 'Wajib RO : '.$wajib_ro.'<br>';
                    $jumlah_poin_ro = $this->jumlah_poin_ro_aktif_reward($upline, $id_plan, $bulan);
                    if($jumlah_poin_ro > 0){
                        $kondisi = true;
                    }
                } else {
                    // echo 'Wajib RO : '.$wajib_ro.'<br>';
                    $kondisi = true;
                }
                
                if($kondisi == true){
                    $cek_poin_reward = $this->cek_poin_reward($upline, $id_kodeaktivasi, $plan_reward, $posisi);
                    if($cek_poin_reward == 0){
                        $sql = "INSERT INTO mlm_member_poin_reward 
                                (id_member,
                                posisi,
                                poin,
                                id_kodeaktivasi,
                                id_plan,
                                type,
                                status,
                                created_at)
                                values
                                (
                                    '$upline',
                                    '$posisi',
                                    '$jumlah_hu',
                                    '$id_kodeaktivasi',
                                    '$plan_reward',
                                    '$jenis_posting',
                                    'd',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                        // echo $sql;
                        echo 'Sudah RO <br>';
                    }
                } else {
                    echo 'Belum RO <br>';
                }
            }
        }
        return true;
    }
    

    public function create_poin_binary_fix($dari_member, $jumlah_hu, $id_kodeaktivasi, $id_plan, $wajib_ro, $jenis_posting, $created_at){
        $c = new classConnection();   
        $sql ="CALL GenerasiUpline($dari_member)";
        $generasi_upline = $c->_query($sql);
        $total_record = $generasi_upline->num_rows;
        if($total_record > 0){
            while($row = $generasi_upline->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                echo 'Upline : '.$row->upline.'<br>';
                echo 'Posisi : '.$row->posisi.'<br>';
                $kondisi = false;
                if($wajib_ro == 1){
                    $jumlah_poin_ro = $this->jumlah_poin_ro_reward($upline, $id_plan);
                    if($jumlah_poin_ro > 0){
                        $kondisi = true;
                    }
                } else {
                    $kondisi = true;
                }

                if($id_plan >= 1){
                    $kondisi = true;
                } else {
                    $kondisi = false;
                }
                
                echo 'ID Plan : '.$id_plan.'<br>';
                if($kondisi == true){
                    $cek_poin_reward = $this->cek_poin_reward($upline, $id_kodeaktivasi, $id_plan, $posisi);
                    echo 'Cek poin reward : '.$cek_poin_reward.'<br><br>';
                    if($cek_poin_reward == 0){
                        $sql = "INSERT INTO mlm_member_poin_reward 
                                (id_member,
                                posisi,
                                poin,
                                id_kodeaktivasi,
                                id_plan,
                                type,
                                status,
                                created_at)
                                values
                                (
                                    '$upline',
                                    '$posisi',
                                    '$jumlah_hu',
                                    '$id_kodeaktivasi',
                                    '$id_plan',
                                    '$jenis_posting',
                                    'd',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                    }
                }
            }
        }
        return true;
    }
    
    public function cek_poin_reward($id_member, $id_kodeaktivasi, $id_plan, $posisi)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member_poin_reward r
                WHERE r.id_member = '$id_member' 
                AND r.posisi = '$posisi'
                AND r.id_plan = '$id_plan'
                AND r.id_kodeaktivasi = '$id_kodeaktivasi'
                AND r.status = 'd'
                AND r.deleted_at is null";
                // echo $sql.'<br>';
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
    

    public function jumlah_poin_ro_reward($id_member, $jenis_aktivasi)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_kodeaktivasi_history h
                LEFT JOIN mlm_plan pl ON h.jenis_aktivasi = pl.id
                WHERE h.id_member = '$id_member'
                AND ((pl.id = '$jenis_aktivasi' AND pl.reward = '1') OR pl.parent_reward = '$jenis_aktivasi')
                AND h.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
    

    public function jumlah_poin_ro_aktif_reward($id_member, $jenis_aktivasi, $bulan)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_kodeaktivasi_history h
                LEFT JOIN mlm_plan pl ON h.jenis_aktivasi = pl.id
                WHERE h.id_member = '$id_member'
                AND h.jenis_aktivasi = '$jenis_aktivasi'
                AND LEFT(h.created_at, 7) = '$bulan'
                AND h.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function create_poin_pribadi($id_member, $jumlah_hu, $id_kodeaktivasi, $id_plan, $jenis_posting, $created_at){
        $c = new classConnection();                   
        $sql = "INSERT INTO mlm_member_poin_reward 
                (id_member,
                posisi,
                poin,
                id_kodeaktivasi,
                id_plan,
                type,
                status,
                created_at)
                values
                (
                    '$id_member',
                    '',
                    '$jumlah_hu',
                    '$id_kodeaktivasi',
                    '$id_plan',
                    '$jenis_posting',
                    'd',
                    '$created_at'
                )";
        $query = $c->_query($sql);
        return $query;
    }
    public function bonus_reward($id, $idsetbonus){
        $sql = "SELECT * FROM mlm_bonus_reward
                WHERE id_member = '$id'
                AND id_bonus_reward_setting = '$idsetbonus'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }
    
    public function history_poin($id_kodeaktivasi)
    {
        $sql = "SELECT p.poin, p.created_at, m.id_member, m.nama_member, m.level 
                    FROM mlm_member_poin_reward p
                    LEFT JOIN mlm_member m ON p.id_member = m.id
                    WHERE p.status = 'd' 
                    AND p.id_kodeaktivasi = '$id_kodeaktivasi'
                    ORDER BY p.id ASC";
                    // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
}