<?php
    require_once 'classConnection.php';
    class classStokisMember{
        private $id_stokis;
        private $id_paket;
        private $nama_stokis;
        private $no_handphone;
        private $username;
        private $password;
        private $pin;
        private $id_provinsi;
        private $id_kota;
        private $id_kecamatan;
        private $id_kelurahan;
        private $rt;
        private $rw;
        private $kodepos;
        private $alamat;
        private $email;
        private $status;
        private $created_at;
        private $updated_at;
        private $deleted_at;        

        public function get_id_stokis(){
            return $this->id_stokis;
        }
    
        public function set_id_stokis($id_stokis){
            $this->id_stokis = $id_stokis;
        }
        
        public function get_id_paket(){
            return $this->id_paket;
        }
    
        public function set_id_paket($id_paket){
            $this->id_paket = $id_paket;
        }
        
        public function get_nama_stokis(){
            return $this->nama_stokis;
        }
    
        public function set_nama_stokis($nama_stokis){
            $this->nama_stokis = $nama_stokis;
        }
        
        public function get_no_handphone(){
            return $this->no_handphone;
        }
    
        public function set_no_handphone($no_handphone){
            $this->no_handphone = $no_handphone;
        }
        
        public function get_username(){
            return $this->username;
        }
    
        public function set_username($username){
            $this->username = $username;
        }
        
        public function get_password(){
            return $this->password;
        }
    
        public function set_password($password){
            $this->password = $password;
        }
        
        public function get_pin(){
            return $this->pin;
        }
    
        public function set_pin($pin){
            $this->pin = $pin;
        }    
        
        public function get_id_provinsi(){
            return $this->id_provinsi;
        }
    
        public function set_id_provinsi($id_provinsi){
            $this->id_provinsi = $id_provinsi;
        }
        
        public function get_id_kota(){
            return $this->id_kota;
        }
    
        public function set_id_kota($id_kota){
            $this->id_kota = $id_kota;
        }
        
        public function get_id_kecamatan(){
            return $this->id_kecamatan;
        }
    
        public function set_id_kecamatan($id_kecamatan){
            $this->id_kecamatan = $id_kecamatan;
        }
        
        public function get_id_kelurahan(){
            return $this->id_kelurahan;
        }
    
        public function set_id_kelurahan($id_kelurahan){
            $this->id_kelurahan = $id_kelurahan;
        }
        
        public function get_rt(){
            return $this->rt;
        }
    
        public function set_rt($rt){
            $this->rt = $rt;
        }
        
        public function get_rw(){
            return $this->rw;
        }
    
        public function set_rw($rw){
            $this->rw = $rw;
        }
        
        public function get_kodepos(){
            return $this->kodepos;
        }
    
        public function set_kodepos($kodepos){
            $this->kodepos = $kodepos;
        }
        
        public function get_alamat(){
            return $this->alamat;
        }
    
        public function set_alamat($alamat){
            $this->alamat = $alamat;
        }
        
        public function get_email(){
            return $this->email;
        }
    
        public function set_email($email){
            $this->email = $email;
        }
        
        public function get_status(){
            return $this->status;
        }
    
        public function set_status($status){
            $this->status = $status;
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
                's.id',
                's.id_stokis',
                's.nama_stokis',
                'sp.nama_paket',
                'k.nama_kota',
                's.no_handphone',
                'stok',
                's.status',
                's.username',
                's.id',
                );

            $data_search =array(
                's.id',
                's.id_stokis',
                's.nama_stokis',
                'k.nama_kota',
                's.no_handphone',
                's.status',
                's.username'
                );

                $sql  = "SELECT 
                            s.*, 
                            ps.nama_paket,
                            k.nama_kota,
                            COALESCE(wallet_summary.debet, 0) AS debet,
                            COALESCE(stok_summary.stok, 0) AS stok
                        FROM mlm_stokis_member s
                        LEFT JOIN mlm_stokis_paket ps ON s.id_paket = ps.id
                        LEFT JOIN mlm_kota k ON s.id_kota = k.id
                        -- Aggregate wallet debet
                        LEFT JOIN (
                            SELECT 
                                w.id_stokis, 
                                SUM(CASE 
                                    WHEN w.status = 'd' AND w.jenis = 'saldo' 
                                    THEN w.nominal ELSE 0 
                                END) AS debet
                            FROM mlm_stokis_wallet w
                            WHERE w.deleted_at IS NULL
                            GROUP BY w.id_stokis
                        ) wallet_summary ON wallet_summary.id_stokis = s.id
                        -- Aggregate stok
                        LEFT JOIN (
                            SELECT 
                                sp.id_stokis, 
                                SUM(CASE WHEN sp.status = 'd' THEN sp.qty ELSE 0 END) - 
                                SUM(CASE WHEN sp.status = 'k' THEN sp.qty ELSE 0 END) AS stok
                            FROM mlm_stokis_produk sp
                            WHERE sp.deleted_at IS NULL
                            GROUP BY sp.id_stokis
                        ) stok_summary ON stok_summary.id_stokis = s.id
                        WHERE s.deleted_at IS NULL";

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
            while($row = $query->fetch_object()){
                $subdata=array();
                $subdata[] = $row->id;
                $subdata[] = $row->id_stokis;
                $subdata[] = $row->nama_stokis;
                $subdata[] = $row->nama_paket;
                $subdata[] = $row->nama_kota;
                $subdata[] = $row->no_handphone;
                $subdata[] = currency($row->debet);
                $subdata[] = currency($row->stok);
                $subdata[] = $row->username.'<br>'.base64_decode($row->password);
                $subdata[] = status($row->status);
                $subdata[] = '<a href="index.php?go=stokis_member_edit&id='.base64_encode($row->id).'" class="btn btn-default btn-xs"><i class="fas fa-edit"></i></a>
                                <a href="index.php?go=blokir_stokis&id='.base64_encode($row->id).'" class="btn btn-danger btn-xs"><i class="fas fa-ban"></i></a>
                                <a target="_blank" href="index.php?go=bypass_login_stokis&username='.base64_encode($row->username).'&password='.$row->password.'" class="btn btn-primary btn-xs"><i class="fas fa-sign-in"></i></a>
                                ';
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

        public function create()
        {
            $sql 	= "INSERT INTO mlm_stokis_member(
                            id_paket,
                            nama_stokis,
                            no_handphone,
                            id_provinsi,
                            id_kota,
                            id_kecamatan,
                            id_kelurahan,
                            rt,
                            rw,
                            kodepos,
                            alamat,
                            email,
                            username,
                            password,
                            pin,
                            status,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_paket()."', 
                            '".$this->get_nama_stokis()."', 
                            '".$this->get_no_handphone()."', 
                            '".$this->get_id_provinsi()."', 
                            '".$this->get_id_kota()."', 
                            '".$this->get_id_kecamatan()."', 
                            '".$this->get_id_kelurahan()."', 
                            '".$this->get_rt()."', 
                            '".$this->get_rw()."', 
                            '".$this->get_kodepos()."', 
                            '".$this->get_alamat()."', 
                            '".$this->get_email()."', 
                            '".$this->get_username()."', 
                            '".$this->get_password()."', 
                            '".$this->get_pin()."',  
                            '".$this->get_status()."', 
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update_id_stokis($id){
            $sql  = "UPDATE mlm_stokis_member set 
                        id_stokis = '".$this->get_id_stokis()."'
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        
        public function update($id){
            $sql  = "UPDATE mlm_stokis_member set 
                        nama_stokis = CASE WHEN LENGTH('".$this->get_nama_stokis()."') > 0 THEN '".$this->get_nama_stokis()."'  ELSE nama_stokis END,
                        no_handphone = CASE WHEN LENGTH('".$this->get_no_handphone()."') > 0 THEN '".$this->get_no_handphone()."'  ELSE no_handphone END,
                        username = CASE WHEN LENGTH('".$this->get_username()."') > 0 THEN '".$this->get_username()."'  ELSE username END,
                        password = CASE WHEN LENGTH('".$this->get_password()."') > 0 THEN '".$this->get_password()."'  ELSE password END,
                        pin = CASE WHEN LENGTH('".$this->get_pin()."') > 0 THEN '".$this->get_pin()."'  ELSE pin END,
                        id_provinsi = CASE WHEN LENGTH('".$this->get_id_provinsi()."') > 0 THEN '".$this->get_id_provinsi()."'  ELSE id_provinsi END,
                        id_kota = CASE WHEN LENGTH('".$this->get_id_kota()."') > 0 THEN '".$this->get_id_kota()."'  ELSE id_kota END,
                        id_kecamatan = CASE WHEN LENGTH('".$this->get_id_kecamatan()."') > 0 THEN '".$this->get_id_kecamatan()."'  ELSE id_kecamatan END,
                        id_kelurahan = CASE WHEN LENGTH('".$this->get_id_kelurahan()."') > 0 THEN '".$this->get_id_kelurahan()."'  ELSE id_kelurahan END,
                        rt = CASE WHEN LENGTH('".$this->get_rt()."') > 0 THEN '".$this->get_rt()."'  ELSE rt END,
                        rw = CASE WHEN LENGTH('".$this->get_rw()."') > 0 THEN '".$this->get_rw()."'  ELSE rw END,
                        kodepos = CASE WHEN LENGTH('".$this->get_kodepos()."') > 0 THEN '".$this->get_kodepos()."'  ELSE kodepos END,
                        alamat = CASE WHEN LENGTH('".$this->get_alamat()."') > 0 THEN '".$this->get_alamat()."'  ELSE alamat END,
                        email = CASE WHEN LENGTH('".$this->get_email()."') > 0 THEN '".$this->get_email()."'  ELSE email END,
                        id_paket = CASE WHEN LENGTH('".$this->get_id_paket()."') > 0 THEN '".$this->get_id_paket()."'  ELSE id_paket END,
                        status = CASE WHEN LENGTH('".$this->get_status()."') > 0 THEN '".$this->get_status()."'  ELSE status END
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT 
                        s.*, 
                        ps.nama_paket,
                        p.nama_provinsi,
                        k.nama_kota,
                        kc.nama_kecamatan,
                        kl.nama_kelurahan
                    FROM mlm_stokis_member s
                    LEFT JOIN mlm_stokis_paket ps ON s.id_paket = ps.id
                    LEFT JOIN mlm_provinsi p ON s.id_provinsi = p.id
                    LEFT JOIN mlm_kota k ON s.id_kota = k.id
                    LEFT JOIN mlm_kecamatan kc ON s.id_kecamatan = kc.id
                    LEFT JOIN mlm_kelurahan kl ON s.id_kelurahan = kl.id
                    WHERE s.deleted_at IS NULL 
                    AND s.status = '1'
                    ORDER BY s.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT s.*, ps.nama_paket 
                        FROM mlm_stokis_member s 
                        LEFT JOIN mlm_stokis_paket ps ON s.id_paket = ps.id WHERE s.id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function detail($id, $id_rekening = ''){
            $sql  = "SELECT s.*, 
                        ps.nama_paket, 
                        b.nama_bank,
                        b.kode_bank,
                        r.no_rekening,
                        r.atas_nama_rekening,
                        r.cabang_rekening
                        FROM mlm_stokis_member s 
                        LEFT JOIN mlm_stokis_paket ps ON s.id_paket = ps.id 
                        LEFT JOIN mlm_stokis_rekening r ON r.id_stokis = s.id
                        LEFT JOIN mlm_bank b ON r.id_bank = b.id 
                        WHERE s.id = '$id'
                        AND CASE WHEN LENGTH('$id_rekening') > 0 THEN r.id = '$id_rekening' ELSE 1 END
                        LIMIT 1";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function exist($username){
            $sql  = "SELECT COUNT(*) as total FROM mlm_stokis_member WHERE username = '$username'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            if($query->total == 0){
                return true;
            }
            return false;
        }

        public function total_new_stokis()
        {
            $sql = "SELECT COUNT(*) AS total 
                        FROM mlm_stokis_member 
                        WHERE LEFT(created_at, 10) = '".date('Y-m-d')."'
                        AND status = '1'
                        AND deleted_at IS NULL";
            $c = new classConnection();
            $query = $c->_query_fetch($sql);
            if($query){
                return $query->total;
            }
            return 0;
        }

        public function index_transfer($id_paket){
            $sql  = "SELECT 
                        s.*, 
                        ps.nama_paket,
                        p.nama_provinsi,
                        k.nama_kota,
                        kc.nama_kecamatan,
                        kl.nama_kelurahan
                    FROM mlm_stokis_member s
                    LEFT JOIN mlm_stokis_paket ps ON s.id_paket = ps.id
                    LEFT JOIN mlm_provinsi p ON s.id_provinsi = p.id
                    LEFT JOIN mlm_kota k ON s.id_kota = k.id
                    LEFT JOIN mlm_kecamatan kc ON s.id_kecamatan = kc.id
                    LEFT JOIN mlm_kelurahan kl ON s.id_kelurahan = kl.id
                    WHERE s.deleted_at IS NULL 
                    AND s.id_paket > '$id_paket' AND s.id_paket <> 100 ORDER BY s.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>