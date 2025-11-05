<?php 
require_once 'classConnection.php';

class classBonusRewardPaket{
    protected $attributes = [];

    // Magic method untuk mengakses properti
    public function __get($property) {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value) {
        $this->attributes[$property] = $value;
    }

    public function create(){
        // Ambil kolom dan nilai dari atribut
        $columns = implode(", ", array_keys($this->attributes));
        
        // Buat array untuk menampung nilai yang telah disanitasi
        $sanitized_values = [];
        
        // Sanitasi nilai-nilai atribut
        foreach ($this->attributes as $value) {
            $sanitized_values[] = "'" . addslashes($value) . "'"; // Sanitasi dengan addslashes
        }
        
        // Gabungkan nilai-nilai tersebut untuk dimasukkan ke dalam query
        $values = implode(", ", $sanitized_values);
        
        // Query SQL untuk insert
        $sql = "INSERT INTO mlm_bonus_reward_paket ($columns) VALUES ($values)";
        // Koneksi ke database
        $c = new classConnection();
        
        // Jalankan query
        $query = $c->_query_insert($sql);
        
        return $query;
    }

    public function datatable($request){
        $sort_column =array(
            'k.id',
            'k.created_at',
            'm.id_member',
            'm.nama_member',
            'pj.nama_reward',
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
                        pj.nama_reward,
                        k.reward,
                        k.nominal,
                        k.status_transfer,
                        k.created_at,
                        k.updated_at
                    FROM mlm_bonus_reward_paket k
                    LEFT JOIN mlm_bonus_reward_paket_setting s 
                    ON k.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_produk_jenis pj 
                    ON s.id_produk_jenis = pj.id
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
            $subdata[] = $row->nama_reward;
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
                    FROM mlm_bonus_reward_paket k
                    LEFT JOIN mlm_bonus_reward_paket_setting s 
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
                    FROM mlm_bonus_reward_paket k
                    LEFT JOIN mlm_bonus_reward_paket_setting s 
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
                    FROM mlm_bonus_reward_paket k
                    LEFT JOIN mlm_bonus_reward_paket_setting s 
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
        $sql = "UPDATE mlm_bonus_reward_paket
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
                    FROM mlm_bonus_reward_paket k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_member d ON k.dari_member = d.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'
                    AND k.jenis_bonus = '$jenis_bonus'";	
		$c    = new classConnection();
		$query  = $c->_query_fetch($sql);
		return $query;
	}

    public function create_poin($id_member, $jumlah_hu, $id_kodeaktivasi, $id_produk_jenis, $jenis_posting, $created_at){
        $c = new classConnection();             
        $cek_poin_reward = $this->cek_poin_reward($id_member, $id_kodeaktivasi, $id_produk_jenis);
        if($cek_poin_reward == 0){      
            $sql = "INSERT INTO mlm_member_poin_reward_paket 
                    (id_member,
                    posisi,
                    poin,
                    id_kodeaktivasi,
                    id_produk_jenis,
                    type,
                    status,
                    created_at)
                    values
                    (
                        '$id_member',
                        '',
                        '$jumlah_hu',
                        '$id_kodeaktivasi',
                        '$id_produk_jenis',
                        '$jenis_posting',
                        'd',
                        '$created_at'
                    )";
            $query = $c->_query($sql);
            return $query;
        }
        return true;
    }
    
    
    public function cek_poin_reward($id_member, $id_kodeaktivasi, $id_produk_jenis)
    {
        $sql = "SELECT COUNT(*) AS total
                FROM mlm_member_poin_reward_paket r
                WHERE r.id_member = '$id_member' 
                AND r.id_produk_jenis = '$id_plan'
                AND r.id_kodeaktivasi = '$id_kodeaktivasi'
                AND r.status = 'd'
                AND r.deleted_at is null";
                // echo $sql.'<br>';
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function bonus_reward($id, $idsetbonus){
        $sql = "SELECT * FROM mlm_bonus_reward_paket
                WHERE id_member = '$id'
                AND id_bonus_reward_setting = '$idsetbonus'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_reward($id_member, $id_produk_jenis)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kiri' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kiri' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS reward_kiri, 
                    COALESCE(SUM(CASE 
                        WHEN m.posisi = 'kanan' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'kanan' AND m.status = 'k'
                        THEN m.poin
                        ELSE 0 
                    END),0) AS reward_kanan  
                    FROM mlm_member_poin_reward_paket m
                    LEFT JOIN mlm_kodeaktivasi k ON m.id_kodeaktivasi = k.id
                    WHERE m.id_member = '$id_member' 
                    AND m.id_produk_jenis = '$id_produk_jenis'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query;
    }

    public function jumlah_poin_reward_pribadi($id_member, $id_produk_jenis)
    {
        $sql = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN m.status = 'd' 
                        THEN m.poin
                        ELSE 0 
                    END)
                    -
                    SUM(CASE 
                        WHEN m.posisi = 'k'
                        THEN m.poin
                        ELSE 0 
                    END), 0) AS poin_reward  
                    FROM mlm_member_poin_reward_paket m
                    WHERE m.id_member = '$id_member' 
                    AND m.id_produk_jenis = '$id_produk_jenis'
                    AND m.deleted_at is null";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        return $query->poin_reward;
    }
}