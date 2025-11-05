<?php 
require_once 'classConnection.php';

class classBonusPasangan{

    private $id;
    private $id_member;
    private $nominal;
    private $status_transfer;
    private $terpasang;
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
                        k.terpasang,
                        k.keterangan,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_bonus_pasangan k
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
            $subdata[] = $row->terpasang;
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
                    FROM mlm_bonus_pasangan k
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
                    FROM mlm_bonus_pasangan k
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
        $sql = "UPDATE mlm_bonus_pasangan 
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
                    FROM mlm_bonus_pasangan k
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
                    FROM mlm_bonus_pasangan s
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

    public function update_rekap($tgl_rekap)
    {
        $sql = "UPDATE mlm_bonus_pasangan s
                    LEFT JOIN mlm_member m
                    ON s.id_member = m.id
                    SET s.status_transfer = '1', s.updated_at = '$tgl_rekap'
                    WHERE s.status_transfer = '0'
                    AND m.id_plan <> '1'
                    AND s.created_at <= '$tgl_rekap'
                    AND s.deleted_at IS NULL";
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
                            FROM mlm_member_poin_pasangan m
                            WHERE m.id_plan = '$id_plan'
                                AND m.created_at < '$created_at'
                                AND m.deleted_at IS NULL
                            GROUP BY m.id_member
                            HAVING min_potensi > 0
                        ) AS subquery";
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function get_member_terpasang($id_plan, $created_at){
        $c = new classConnection();   
        $sql = "SELECT 
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
                FROM mlm_member_poin_pasangan m
                WHERE m.id_plan = '$id_plan'
                    AND m.created_at < '$created_at'
                    AND m.deleted_at IS NULL
                GROUP BY m.id_member
                HAVING min_potensi > 0";
        $query  = $c->_query($sql);
        return $query;
    }
    public function nominal_bonus_pasangan($id_plan_pasangan){
        $c = new classConnection();   
        $sql    = "SELECT pl.* 
                        FROM mlm_plan pl 
                        WHERE pl.id = '$id_plan_pasangan'
                        AND pl.pasangan = '1' 
                        AND pl.bonus_pasangan > 0";
        $bonus  = $c->_query_fetch($sql);
        if($bonus){
            return $bonus->bonus_pasangan;
        }
        return 0;
    }
    
    public function terpasang_hari_ini($id_member, $id_plan){
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS terpasang
                    FROM mlm_member_poin_pasangan m
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

    public function jumlah_poin_pasangan($id_member, $id_plan)
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
                    FROM mlm_member_poin_pasangan m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_plan = '$id_plan'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function create_rekap($total_aktivasi, $total_terpasang_member, $bonus_pasangan, $index_pasangan, $nominal_bonus, $created_at){
        $sql = "INSERT INTO mlm_bonus_pasangan_rekap 
                    (
                        total_hu,
                        total_terpasang,
                        bonus_pasangan,
                        index_pasangan,
                        nominal_bonus,
                        created_at
                    )
                    values
                    (
                        '$total_aktivasi',
                        '$total_terpasang_member',
                        '$bonus_pasangan',
                        '$index_pasangan',
                        '$nominal_bonus',
                        '$created_at'
                    )
                    ";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
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
                $id_plan = $row->id_plan;
                $id_produk_jenis = $row->id_produk_jenis;
                
                if($id_plan >= 1){
                    $cek_poin = $this->cek_poin($upline, $id_kodeaktivasi, $id_plan_pasangan, $posisi);
                    if($cek_poin == 0){
                        $sql = "INSERT INTO mlm_member_poin_pasangan 
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
                                    '$id_plan_pasangan',
                                    '$jenis_posting',
                                    'd',
                                    '$created_at'
                                )";
                        $c->_query($sql);
                    }
                }

                $this->hitung_bonus_pasangan($id_kodeaktivasi, $id_plan, $id_plan_pasangan, $created_at, $upline, $id_produk_jenis);
            }
        }
        return true;
    }

    public function hitung_bonus_pasangan($id_kodeaktivasi, $id_plan, $id_plan_pasangan, $created_at, $upline, $id_produk_jenis){
        $c = new classConnection();   
        $sql    = "SELECT pl.* 
                        FROM mlm_plan pl 
                        WHERE pl.id = '$id_plan_pasangan'
                        AND pl.pasangan = '1' 
                        AND pl.bonus_pasangan > 0";
        $bonus  = $c->_query_fetch($sql);
        if(!$bonus){
            return true;
        }

        $bonus_pasangan = $bonus->bonus_pasangan;
        $show_name = $bonus->show_name;
        
        $kondisi = true;

        if($kondisi == true){            
            $sql    = "SELECT max_pasangan FROM mlm_plan WHERE id = '$id_plan'";
            $paket  = $c->_query_fetch($sql);
            if($paket){
                $sql    = "SELECT multiplication 
                                FROM mlm_produk_jenis
                                WHERE id = '$id_produk_jenis'";
                $produk_jenis  = $c->_query_fetch($sql);
                if($produk_jenis) {
                    $multiplication = $produk_jenis->multiplication;
                } else {
                    $multiplication = 1;
                }
                $max_pasangan = $paket->max_pasangan*$multiplication;

                $potensi = $this->jumlah_poin_pasangan($upline, $id_plan_pasangan);

                $potensi_kiri = $potensi->poin_kiri-$potensi->terpasang_kiri;
                $potensi_kanan = $potensi->poin_kanan-$potensi->terpasang_kanan;
                
                if($potensi_kiri > 0 && $potensi_kanan > 0){
                    if($potensi_kiri >= $potensi_kanan){
                        $terpasang = $potensi_kanan;
                    } else {
                        $terpasang = $potensi_kiri;
                    }

                    if($bonus_pasangan >0 ){
                        $terpasang_hari_ini = $this->terpasang_hari_ini($upline, $id_plan_pasangan); 
                        
                        if($max_pasangan > $terpasang_hari_ini){
                            if($terpasang+$terpasang_hari_ini > $max_pasangan){
                                $flush_in = $max_pasangan - $terpasang_hari_ini;
                                $flush_out = $terpasang - $flush_in;
                                $keterangan = $show_name.' Terpasang '.$flush_in.'. Flush Out '.$flush_out.' (Max pasangan telah tercapai.)';
                            } else {
                                $flush_in = $terpasang;
                                $flush_out = 0;
                                $keterangan = $show_name.' Terpasang '.$flush_in;
                            }
                            $nominal_bonus = $bonus_pasangan*$flush_in;                            
                            // $nominal_bonus = floor($nominal_bonus * 0.8);
                            // $autosave = $nominal_bonus - $nominal_bonus;

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
                                                'bonus_pasangan',
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
                                $sql  = "INSERT INTO mlm_bonus_pasangan(
                                            id_member, 
                                            terpasang, 
                                            nominal, 
                                            status_transfer, 
                                            id_plan, 
                                            keterangan, 
                                            created_at
                                        ) VALUES (
                                            $upline, 
                                            $terpasang, 
                                            $nominal_bonus, 
                                            '0', 
                                            '$id_plan_pasangan', 
                                            '$keterangan',
                                            '$created_at'
                                        )";
                                $create_bonus_pasangan = $c->_query_insert($sql); 
                            }   
                            // if($create_bonus_pasangan){
                            //     $this->create_bonus_matching($upline, $id_plan_pasangan, $terpasang, $bonus->bonus_pasangan_level, $created_at);
                            // }
                        } else {
                            $flush_in = 0;
                            $flush_out = $terpasang;
                        }
                        if($flush_in > 0){
                            $sql = "INSERT INTO mlm_member_poin_pasangan 
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
                                        'kiri',
                                        '$flush_in',
                                        '$id_kodeaktivasi',
                                        '$id_plan_pasangan',
                                        'flush_in',
                                        'k',
                                        '$created_at'
                                    )";
                            $create = $c->_query($sql);
                            $sql = "INSERT INTO mlm_member_poin_pasangan 
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
                                        'kanan',
                                        '$flush_in',
                                        '$id_kodeaktivasi',
                                        '$id_plan_pasangan',
                                        'flush_in',
                                        'k',
                                        '$created_at'
                                    )";
                            $create = $c->_query($sql);
                        }
                        if($flush_out > 0){
                            $sql = "INSERT INTO mlm_member_poin_pasangan 
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
                                        'kiri',
                                        '$flush_out',
                                        '$id_kodeaktivasi',
                                        '$id_plan_pasangan',
                                        'flush_out',
                                        'k',
                                        '$created_at'
                                    )
                                    ";
                            $create = $c->_query($sql);
                            $sql = "INSERT INTO mlm_member_poin_pasangan 
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
                                        'kanan',
                                        '$flush_out',
                                        '$id_kodeaktivasi',
                                        '$id_plan_pasangan',
                                        'flush_out',
                                        'k',
                                        '$created_at'
                                    )
                                    ";
                            $create = $c->_query($sql);
                        }
                    }
                }
            }
        }
    }
    
    public function history_poin($id_kodeaktivasi)
    {
        $sql = "SELECT p.poin, p.created_at, m.id_member, m.nama_member, m.level 
                    FROM mlm_member_poin_pasangan p
                    LEFT JOIN mlm_member m ON p.id_member = m.id
                    WHERE p.status = 'd' 
                    AND p.id_kodeaktivasi = '$id_kodeaktivasi'
                    ORDER BY p.id ASC";
                    // echo $sql;
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }
    
    public function cek_poin($id_member, $id_kodeaktivasi, $id_plan, $posisi)
    {
        $sql = "SELECT COUNT(*) AS total 
                    FROM mlm_member_poin_pasangan
                    WHERE status = 'd' 
                    AND id_kodeaktivasi = '$id_kodeaktivasi'
                    AND id_member = '$id_member'
                    AND id_plan = '$id_plan'
                    AND posisi = '$posisi'";
                    // echo $sql;
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
}