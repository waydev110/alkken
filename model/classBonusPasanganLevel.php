<?php 
require_once 'classConnection.php';

class classBonusPasanganLevel{

    private $id;
    private $id_member;
    private $nominal;
    private $status_transfer;
    private $terpasang;
    private $level;
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
    
    public function get_terpasang(){
		return $this->terpasang;
	}

	public function set_terpasang($terpasang){
		$this->terpasang = $terpasang;
	}
    
    public function get_level(){
		return $this->level;
	}

	public function set_level($level){
		$this->level = $level;
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

    public function datatable($request){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'm.id_member',
            'm.nama_member',
            'nominal',
            'k.terpasang',
            'k.status_transfer',
            );

        $data_search =array(
            'k.id',
            'm.id_member',
            'm.nama_member',
            'd.id_member',
            'k.created_at'
            );

            $sql  = "SELECT 
                        k.id,
                        m.id_member,
                        m.nama_member,
                        k.nominal,
                        k.generasi,
                        k.keterangan,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_bonus_pasangan_level k
                    LEFT JOIN mlm_member m 
                    ON k.id_member = m.id
                    LEFT JOIN mlm_member d 
                    ON k.terpasang = d.id
                    LEFT JOIN mlm_bank b 
                    ON m.id_bank = b.id
                    WHERE k.deleted_at IS NULL
                    AND m.deleted_at IS NULL
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
            $subdata[] = $row->generasi;
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
                    FROM mlm_bonus_pasangan_level k
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
                    FROM mlm_bonus_pasangan_level k
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
        $sql = "UPDATE mlm_bonus_pasangan_level 
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
                        d.id_member as terpasang
                    FROM mlm_bonus_pasangan_level k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.terpasang = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'
                    AND k.jenis_bonus = '0'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}
	
    public function rekap_bonus($tgl_rekap)
    {
        $sql = "SELECT s.id_member, SUM(s.nominal) AS nominal, m.id_plan 
                    FROM mlm_bonus_pasangan_level s
                    LEFT JOIN mlm_member m
                    ON s.id_member = m.id
                    WHERE s.status_transfer = '0'
                    AND m.id_plan <> '1'
                    AND s.created_at <= '$tgl_rekap'
                    AND s.deleted_at IS NULL
                    GROUP BY s.id_member
                    ORDER BY s.id_member ASC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
    
    public function create()
    {
        $sql =
            "INSERT INTO mlm_bonus_pasangan_level (
                    id_member,
                    terpasang,
                    nominal,
                    status_transfer,
                    keterangan,
                    level,
                    created_at
                ) values (
                    '".$this->get_id_member()."', 
                    '".$this->get_terpasang()."',
                    '".$this->get_nominal()."',
                    '".$this->get_status_transfer()."', 
                    '".$this->get_keterangan()."', 
                    '".$this->get_level()."',       
                    '".$this->get_created_at()."'
                )";
        $c = new classConnection();
        $query = $c->_query_insert($sql);
        return $query;
    }
    public function delete($id)
    {
        $sql = "DELETE FROM mlm_bonus_pasangan_level WHERE id = '$id'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    } 
    
    public function cek_poin_pasangan($id_member, $posisi, $id_plan, $generasi)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = '$posisi' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS poin 
                    FROM mlm_member_poin_pasangan_level m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.posisi = '$posisi'
                    AND m.generasi = '$generasi'
                    AND m.status = 'd'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->poin;
    }

    public function create_poin($dari_member, $jumlah_hu, $id_kodeaktivasi, $id_plan_pasangan, $jenis_posting, $created_at){
        $c = new classConnection();   
        $sql ="CALL GenerasiUpline($dari_member)";
        $generasi_upline = $c->_query($sql);
        $total_record = $generasi_upline->num_rows; 
        if($total_record > 0){    
            while($row = $generasi_upline->fetch_object()){
                $upline = $row->upline;
                $posisi = $row->posisi;
                $generasi = $row->generasi;
                $id_plan = $row->id_plan;
                
                if($id_plan >= 1){
                    $poin_pasangan = $this->cek_poin_pasangan($upline, $posisi, $id_plan_pasangan, $generasi);
                    if($poin_pasangan == 0){
                        $sql = "INSERT INTO mlm_member_poin_pasangan_level 
                                (id_member,
                                generasi,
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
                                    '$generasi',
                                    '$posisi',
                                    '$jumlah_hu',
                                    '$id_kodeaktivasi',
                                    '$id_plan_pasangan',
                                    '$jenis_posting',
                                    'd',
                                    '$created_at'
                                )";
                        $c->_query($sql);

                    }
                }

                $this->hitung_bonus_pasangan($id_kodeaktivasi, $id_plan, $id_plan_pasangan, $created_at, $upline, $generasi);
            }
        }
        return true;
    }

    public function hitung_bonus_pasangan($id_kodeaktivasi, $id_plan, $id_plan_pasangan, $created_at, $upline, $generasi){
        $c = new classConnection();   
        $sql    = "SELECT pl.* 
                        FROM mlm_plan pl 
                        WHERE pl.id = '$id_plan_pasangan'
                        AND pl.pasangan_level = '1' 
                        AND pl.bonus_pasangan_level > 0";
        $bonus  = $c->_query_fetch($sql);
        if(!$bonus){
            return true;
        }
        $bonus_pasangan = $bonus->bonus_pasangan_level;
        $nama_plan = $bonus->nama_plan;
        $show_name = 'Pasangan Level';

        // $kondisi = false;
        // if($bonus->syarat_ro == '1'){
        //     $plan_ro = 8;
        //     $jumlah_poin_ro = $this->jumlah_poin_ro($upline, $plan_ro);
        //     if($jumlah_poin_ro > 0){
        //         $kondisi = true;
        //     } else {
        //         $kondisi = false;
        //     }
        // } else {
            $kondisi = true;
        // }

        if($kondisi == true){   
            $potensi = $this->jumlah_poin_pasangan($upline, $id_plan_pasangan, $generasi);

            $potensi_kiri = $potensi->poin_kiri-$potensi->terpasang_kiri;
            $potensi_kanan = $potensi->poin_kanan-$potensi->terpasang_kanan;
            
            if($potensi_kiri > 0 && $potensi_kanan > 0){
                if($potensi_kiri >= $potensi_kanan){
                    $terpasang = $potensi_kanan;
                } else {
                    $terpasang = $potensi_kiri;
                }

                if($bonus_pasangan >0 ){
                    $keterangan = $show_name.' '.$nama_plan.' Terpasang '.$terpasang.' di Level ke-'.$generasi;
                    $nominal_bonus = $bonus_pasangan*$terpasang;    

                    if($id_plan_pasangan >= 200){
                		$sql 	= "INSERT INTO mlm_wallet (
                                        id_member, 
                                        jenis_saldo, 
                                        nominal, 
                                        type, 
                                        keterangan, 
                                        status, 
                                        status_transfer, 
                                        dari_member, 
                                        id_kodeaktivasi, 
                                        dibaca, 
                                        created_at
                                    ) values (
                                        '$upline',
                                        'cash', 
                                        '$nominal_bonus',
                                        'bonus_pasangan_level',
                                        '$keterangan',  
                                        'd',
                                        '0', 
                                        '0',       
                                        '$id_plan_pasangan',      
                                        '0',             
                                        '$created_at'
                                        )";
                		$c->_query($sql);
                    } else { 

                        $sql  = "INSERT INTO mlm_bonus_pasangan_level(
                                    id_member, 
                                    generasi,
                                    terpasang, 
                                    nominal, 
                                    status_transfer, 
                                    id_plan, 
                                    keterangan, 
                                    created_at
                                ) VALUES (
                                    $upline, 
                                    $generasi, 
                                    $terpasang, 
                                    $nominal_bonus, 
                                    '0', 
                                    '$id_plan_pasangan', 
                                    '$keterangan',
                                    '$created_at'
                                )";
                                $c->_query_insert($sql); 
                    }
                    if($terpasang > 0){
                        $sql = "INSERT INTO mlm_member_poin_pasangan_level 
                                (id_member,
                                generasi,   
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
                                    '$generasi',   
                                    'kiri',
                                    '$terpasang',
                                    '$id_kodeaktivasi',
                                    '$id_plan_pasangan',
                                    'flush_in',
                                    'k',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                        $sql = "INSERT INTO mlm_member_poin_pasangan_level 
                                (id_member,
                                generasi,   
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
                                    '$generasi',
                                    'kanan',
                                    '$terpasang',
                                    '$id_kodeaktivasi',
                                    '$id_plan_pasangan',
                                    'flush_in',
                                    'k',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                    }
                }
            }
        }
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
    
    public function jumlah_poin_pasangan($id_member, $id_plan, $generasi)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS poin_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'd'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS poin_kanan, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS terpasang_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS terpasang_kanan 
                    FROM mlm_member_poin_pasangan_level m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.generasi = '$generasi'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }
    
    public function terpasang_hari_ini($id_member, $id_plan){
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS terpasang
                    FROM mlm_member_poin_pasangan_level m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND LEFT(m.created_at, 10) = '".date('Y-m-d')."'
                    AND m.deleted_at is null";
        $c    = new classConnection();
        $data  = $c->_query_fetch($sql);
        if($data){
            return $data->terpasang;
        }else{
            return 0;
        }
    }

    public function riwayat_poin_pasangan($id_member, $id_plan)
    {
        $sql = "SELECT 
                    p.generasi,
                    COALESCE(SUM(CASE WHEN p.posisi = 'kiri' THEN p.poin ELSE 0 END), 0) AS kiri,
                    COALESCE(SUM(CASE WHEN p.posisi = 'kanan' THEN p.poin ELSE 0 END), 0) AS kanan
                FROM mlm_member_poin_pasangan_level p
                WHERE p.id_member = '$id_member' 
                    AND p.status = 'd'
                    AND p.id_plan = '$id_plan'
                    AND p.deleted_at IS NULL
                GROUP BY p.generasi
                ORDER BY p.generasi ASC";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function tanggal_last_rekap()
    {
        $sql = "SELECT MAX(created_at) as created_at FROM mlm_bonus_pasangan_rekap
                    WHERE deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            $created_at = $query->created_at;
        }
        if($created_at == null){
            return '2024-01-01 00:00:00';
        }
        return $created_at;
    }

    public function total_terpasang_member($id_plan, $created_at){
        $c = new classConnection();   
        $sql = "SELECT 
                    COALESCE(SUM(min_potensi), 0) AS total
                        FROM (
                            SELECT 
                                m.id_member,
                                LEAST(
                                    GREATEST(
                                        (COALESCE(SUM(CASE 
                                            WHEN m.posisi = 'kiri' AND m.status = 'd'
                                            THEN m.poin
                                            ELSE 0 
                                        END), 0) - COALESCE(SUM(CASE 
                                            WHEN m.posisi = 'kiri' AND m.status = 'k'
                                            THEN m.poin
                                            ELSE 0 
                                        END), 0)),
                                        0
                                    ),
                                    GREATEST(
                                        (COALESCE(SUM(CASE 
                                            WHEN m.posisi = 'kanan' AND m.status = 'd'
                                            THEN m.poin
                                            ELSE 0 
                                        END), 0) - COALESCE(SUM(CASE 
                                            WHEN m.posisi = 'kanan' AND m.status = 'k'
                                            THEN m.poin
                                            ELSE 0 
                                        END), 0)),
                                        0
                                    )
                                ) AS min_potensi
                            FROM mlm_member_poin_pasangan_level m
                            WHERE m.id_plan = '$id_plan'
                                AND m.created_at < '$created_at'
                                AND m.deleted_at IS NULL
                            GROUP BY m.id_member
                            HAVING min_potensi > 0
                        ) AS subquery";
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
}