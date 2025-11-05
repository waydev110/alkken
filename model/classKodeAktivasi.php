<?php 
    require_once 'classConnection.php';

    class classKodeAktivasi{
        private $kode_aktivasi;
        private $jumlah_hu;
        private $poin_reward;
        private $harga;
        private $bonus_sponsor;
        private $bonus_cashback;
        private $bonus_generasi;
        private $bonus_upline;
        private $bonus_sponsor_monoleg;
        private $bonus_poin_cashback;
        private $jenis_aktivasi;
        private $jenis_produk;
        private $status_aktivasi;
        private $id_member;
        private $id_stokis;
        private $id_jual_pin;
        private $reposisi;
        private $founder;
        private $created_at;
        private $updated_at;
        private $deleted_at;
        
        public function get_kode_aktivasi(){
            return $this->kode_aktivasi;
        }
    
        public function set_kode_aktivasi($kode_aktivasi){
            $this->kode_aktivasi = $kode_aktivasi;
        }
        
        public function get_jumlah_hu(){
            return $this->jumlah_hu;
        }
    
        public function set_jumlah_hu($jumlah_hu){
            $this->jumlah_hu = $jumlah_hu;
        }
        
        public function get_poin_reward(){
            return $this->poin_reward;
        }
    
        public function set_poin_reward($poin_reward){
            $this->poin_reward = $poin_reward;
        }
        
        public function get_harga(){
            return $this->harga;
        }
    
        public function set_harga($harga){
            $this->harga = $harga;
        }
        
        public function get_bonus_sponsor(){
            return $this->bonus_sponsor;
        }

        public function set_bonus_sponsor($bonus_sponsor){
            $this->bonus_sponsor = $bonus_sponsor;
        }
        
        public function get_bonus_cashback(){
            return $this->bonus_cashback;
        }

        public function set_bonus_cashback($bonus_cashback){
            $this->bonus_cashback = $bonus_cashback;
        }
        
        public function get_bonus_generasi(){
            return $this->bonus_generasi;
        }

        public function set_bonus_generasi($bonus_generasi){
            $this->bonus_generasi = $bonus_generasi;
        }
        
        
        public function get_bonus_upline(){
            return $this->bonus_upline;
        }

        public function set_bonus_upline($bonus_upline){
            $this->bonus_upline = $bonus_upline;
        }

        public function get_bonus_sponsor_monoleg(){
            return $this->bonus_sponsor_monoleg;
        }
    
        public function set_bonus_sponsor_monoleg($bonus_sponsor_monoleg){
            $this->bonus_sponsor_monoleg = $bonus_sponsor_monoleg;
        }
        
        public function get_bonus_poin_cashback(){
            return $this->bonus_poin_cashback;
        }
    
        public function set_bonus_poin_cashback($bonus_poin_cashback){
            $this->bonus_poin_cashback = $bonus_poin_cashback;
        }

        public function get_jenis_aktivasi(){
            return $this->jenis_aktivasi;
        }
    
        public function set_jenis_aktivasi($jenis_aktivasi){
            $this->jenis_aktivasi = $jenis_aktivasi;
        }

        public function get_jenis_produk(){
            return $this->jenis_produk;
        }
    
        public function set_jenis_produk($jenis_produk){
            $this->jenis_produk = $jenis_produk;
        }
        
        public function get_status_aktivasi(){
            return $this->status_aktivasi;
        }
    
        public function set_status_aktivasi($status_aktivasi){
            $this->status_aktivasi = $status_aktivasi;
        }
        
        public function get_id_member(){
            return $this->id_member;
        }
    
        public function set_id_member($id_member){
            $this->id_member = $id_member;
        }
        
        public function get_id_stokis(){
            return $this->id_stokis;
        }
    
        public function set_id_stokis($id_stokis){
            $this->id_stokis = $id_stokis;
        }

        public function get_id_jual_pin(){
            return $this->id_jual_pin;
        }
    
        public function set_id_jual_pin($id_jual_pin){
            $this->id_jual_pin = $id_jual_pin;
        }
        
        public function get_reposisi(){
            return $this->reposisi;
        }
    
        public function set_reposisi($reposisi){
            $this->reposisi = $reposisi;
        }
        
        public function get_founder(){
            return $this->founder;
        }
    
        public function set_founder($founder){
            $this->founder = $founder;
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
                'k.kode_aktivasi',
                'pl.nama_plan',
                'pj.name',
                'k.harga',
                'm.id_member',
                'm.nama_member',
                's.nama_stokis',
                'a.status_aktivasi',
                'k.id',
                );

            $data_search =array(
                'k.id',
                'k.kode_aktivasi',
                'm.id_member',
                'm.nama_member'
                );

                $sql  = "SELECT 
                            k.id,
                            k.created_at,
                            k.kode_aktivasi,
                            k.id_member AS member_id,
                            k.harga AS harga,
                            k.jumlah_hu,
                            k.bonus_sponsor,
                            k.bonus_cashback,
                            k.bonus_generasi,
                            k.bonus_upline,
                            k.jenis_aktivasi,
                            k.status_aktivasi,
                            m.id_member,
                            m.nama_member,
                            s.id_stokis,
                            s.nama_stokis,
                            pl.nama_plan,
                            pj.name
                        FROM mlm_kodeaktivasi k USE INDEX (idx_mlm_kodeaktivasi_jenis_produk, idx_mlm_kodeaktivasi_id_member, idx_mlm_kodeaktivasi_id_stokis, idx_mlm_kodeaktivasi_jenis_aktivasi, idx_mlm_kodeaktivasi_deleted_at, idx_mlm_kodeaktivasi_harga)
                        JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        JOIN mlm_member m ON k.id_member = m.id
                        JOIN mlm_stokis_member s ON k.id_stokis = s.id
                        JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                        WHERE k.deleted_at IS NULL";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;

            if(is_numeric($request['id_paket'])){
                $sql.=" AND s.id_paket = '".$request['id_paket']."' ";
            }
            if(is_numeric($request['id_stokis'])){
                $sql.=" AND k.id_stokis = '".$request['id_stokis']."' ";
            }
            if(is_numeric($request['id_member'])){
                $sql.=" AND k.id_member = '".$request['id_member']."' ";
            }
            if(is_numeric($request['jenis_aktivasi'])){
                $sql.=" AND k.jenis_aktivasi = '".$request['jenis_aktivasi']."' ";
            }
            if(is_numeric($request['jenis_produk'])){
                $sql.=" AND k.jenis_produk = '".$request['jenis_produk']."' ";
            }
            if(is_numeric($request['berbayar'])){
                if($request['berbayar'] == '1'){
                    $sql.=" AND k.harga > 0";
                } else {
                    $sql.=" AND k.harga <= 0 ";
                }
            }
            if(!empty($request['start_date'])){
                // $start_date = str_replace('T', ' ', $request['start_date']) . ':00';
                $start_date = $request['start_date'];
                $sql.=" AND LEFT(k.created_at, 10) >= '$start_date' ";
            }
            if(!empty($request['end_date'])){
                // $end_date = str_replace('T', ' ', $request['end_date']) . ':00';
                $end_date = $request['end_date'];
                // $sql.=" AND (h.created_at <= '$end_date' OR k.created_at <= '$end_date') ";
                $sql.=" AND LEFT(k.created_at, 10) <= '$end_date' ";
            }

            $sql1 = "SELECT COALESCE(SUM(harga), 0) AS total FROM ($sql) AS s";
            $total 	= $c->_query_fetch($sql1)->total;
            $sql2 = "SELECT COALESCE(SUM(harga), 0) AS total FROM ($sql) AS s WHERE status_aktivasi = '0'";
            $pending 	= $c->_query_fetch($sql2)->total;
            $sql3 = "SELECT COALESCE(SUM(harga), 0) AS total FROM ($sql) AS s WHERE status_aktivasi = '1'";
            $aktif 	= $c->_query_fetch($sql3)->total;

            if(is_numeric($request['status_aktivasi'])){
                $sql.=" AND k.status_aktivasi = '".$request['status_aktivasi']."' ";
            }

            if(!empty($request['keyword'])){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$request['keyword']."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }

            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
            if($request['length'] > 0){
                $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
            }
            // echo $sql;
            $query 	= $c->_query($sql);
            $data=array();
            $no = $request['start'];
            while($row = $query->fetch_object()){
                $aksi = '<a href="?go=kodeaktivasi_detail&id='.$row->id.'" class="btn btn-xs btn-default"><i class="fa fa-receipt"></i></a>';
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = $row->created_at;
                $subdata[] = $row->id;
                $subdata[] = $row->nama_plan;
                $subdata[] = $row->name;
                $subdata[] = currency($row->harga);
                $subdata[] = $row->id_member;
                $subdata[] = $row->nama_member;
                $subdata[] = ($row->id_stokis == '' ? 'BY ADMIN' : $row->id_stokis.'<br>'.$row->nama_stokis);
                $subdata[] = status_aktivasi($row->status_aktivasi);
                $subdata[] = $aksi;
                $data[]    = $subdata;
            }
            

            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "total"             =>  rp($total),
                "pending"           =>  rp($pending),
                "aktif"             =>  rp($aktif),
                "data"              =>  $data
            );
            return $json_data;
        }
        
        public function datatable_history($request){
            $sort_column =array(
                'k.id',
                'h.created_at',
                'pl.nama_plan',
                // 'k.kode_aktivasi',
                'k.harga',
                'm.id_member',
                'm.nama_member',
                'k.status_aktivasi',
                'k.id',
                );

            $data_search =array(
                'k.id',
                'h.created_at',
                'pl.nama_plan',
                'k.kode_aktivasi',
                'm.id_member',
                'm.nama_member',
                );

                $sql  = "SELECT 
                            k.id,
                            h.created_at,
                            k.kode_aktivasi,
                            k.id_member AS member_id,
                            k.harga AS harga,
                            k.jumlah_hu,
                            k.bonus_sponsor,
                            k.bonus_cashback,
                            k.bonus_generasi,
                            k.bonus_upline,
                            k.jenis_aktivasi,
                            k.status_aktivasi,
                            m.id_member,
                            m.nama_member,
                            pl.nama_plan,
                            pj.name
                        FROM mlm_kodeaktivasi_history h
                        LEFT JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                        LEFT JOIN mlm_member m ON h.id_member = m.id
                        LEFT JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE k.deleted_at IS NULL AND h.deleted_at IS NULL";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;

            if(is_numeric($request['jenis_aktivasi'])){
                $sql.=" AND k.jenis_aktivasi = '".$request['jenis_aktivasi']."' ";
            }
            if(is_numeric($request['jenis_produk'])){
                $sql.=" AND k.jenis_produk = '".$request['jenis_produk']."' ";
            }
            if(!empty($request['start_date'])){
                $start_date = $request['start_date'];
                $sql.=" AND LEFT(h.created_at, 10) >= '$start_date' ";
            }
            if(!empty($request['end_date'])){
                $end_date = $request['end_date'];
                $sql.=" AND LEFT(h.created_at, 10) <= '$end_date' ";
            }
            if(is_numeric($request['berbayar'])){
                if($request['berbayar'] == '1'){
                    $sql.=" AND k.harga > 0";
                } else {
                    $sql.=" AND k.harga <= 0 ";
                }
            }

            if(!empty($request['keyword'])){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$request['keyword']."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }

            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir'];
            if($request['length'] > 0){
                $sql.="  LIMIT ". $request['start'].",".$request['length']."  ";
            }
            // echo $sql;
            $query 	= $c->_query($sql);
            $data=array();
            $no = $request['start'];
            while($row = $query->fetch_object()){
                $aksi = '<a href="?go=kodeaktivasi_detail&id='.$row->id.'" class="btn btn-xs btn-default"><i class="fa fa-receipt"></i> Lihat Detail</a>';
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = $row->created_at;
                $subdata[] = $row->id;
                $subdata[] = $row->nama_plan;
                $subdata[] = $row->name;
                $subdata[] = currency($row->harga);
                $subdata[] = $row->id_member;
                $subdata[] = $row->nama_member;
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

        public function create()
        {
            $sql 	= "INSERT INTO mlm_kodeaktivasi(
                            kode_aktivasi, 
                            jumlah_hu,  
                            poin_reward, 
                            harga, 
                            bonus_sponsor,
                            bonus_cashback,
                            bonus_generasi, 
                            bonus_upline, 
                            bonus_sponsor_monoleg, 
                            bonus_poin_cashback,
                            jenis_aktivasi, 
                            jenis_produk, 
                            status_aktivasi, 
                            id_member, 
                            id_stokis, 
                            id_jual_pin, 
                            reposisi, 
                            founder, 
                            created_at
                        ) 
                        values (
                            '".$this->get_kode_aktivasi()."', 
                            '".$this->get_jumlah_hu()."', 
                            '".$this->get_poin_reward()."', 
                            '".$this->get_harga()."', 
                            '".$this->get_bonus_sponsor()."',
                            '".$this->get_bonus_cashback()."',
                            '".$this->get_bonus_generasi()."',
                            '".$this->get_bonus_upline()."',
                            '".$this->get_bonus_sponsor_monoleg()."',
                            '".$this->get_bonus_poin_cashback()."',
                            '".$this->get_jenis_aktivasi()."', 
                            '".$this->get_jenis_produk()."', 
                            '".$this->get_status_aktivasi()."', 
                            '".$this->get_id_member()."', 
                            '".$this->get_id_stokis()."', 
                            '".$this->get_id_jual_pin()."', 
                            '".$this->get_reposisi()."', 
                            '".$this->get_founder()."', 
                            '".$this->get_created_at()."'
                            )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }  

        public function update($kode_aktivasi){
            $sql  = "UPDATE mlm_kodeaktivasi SET
                        jumlah_hu = CASE WHEN LENGTH('".$this->get_jumlah_hu()."') > 0 THEN '".$this->get_jumlah_hu()."'  ELSE jumlah_hu END,
                        harga = CASE WHEN LENGTH('".$this->get_harga()."') > 0 THEN '".$this->get_harga()."'  ELSE harga END,
                        bonus_generasi = CASE WHEN LENGTH('".$this->get_bonus_generasi()."') > 0 THEN '".$this->get_bonus_generasi()."'  ELSE bonus_generasi END,
                        bonus_upline = CASE WHEN LENGTH('".$this->get_bonus_upline()."') > 0 THEN '".$this->get_bonus_upline()."'  ELSE bonus_upline END,
                        status_aktivasi = CASE WHEN LENGTH('".$this->get_status_aktivasi()."') > 0 THEN '".$this->get_status_aktivasi()."'  ELSE status_aktivasi END,
                        id_member = CASE WHEN LENGTH('".$this->get_id_member()."') > 0 THEN '".$this->get_id_member()."'  ELSE id_member END,
                        id_stokis = CASE WHEN LENGTH('".$this->get_id_stokis()."') > 0 THEN '".$this->get_id_stokis()."'  ELSE id_stokis END,
                        updated_at = CASE WHEN LENGTH('".$this->get_updated_at()."') > 0 THEN '".$this->get_updated_at()."'  ELSE updated_at END
                        WHERE kode_aktivasi = '$kode_aktivasi'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            if($query){
                $kode = $this->check_code($kode_aktivasi);
                if($kode){
                    return $kode->id;
                }
            }
            return false;
        }

        public function generate_code($len){
            $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $result = '';

            $charArray = str_split($charset);
            for($i = 0; $i < $len; $i++){
                $randItem = array_rand($charArray);
                $result .= "".$charArray[$randItem];
            }

            $cek = $this->check_code($result);
            if($cek == 1){
                return $this->generate_code(12);
            }else{
                return $result;
            }    
        }
    
        public function check_code($code){
            $sql  = "SELECT id, kode_aktivasi from mlm_kodeaktivasi where kode_aktivasi = '$code' and deleted_at is null";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query;
        }  

        public function delete($id){
            $sql  = "DELETE FROM mlm_kodeaktivasi WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_kodeaktivasi WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function detail($id){
            $sql  = "SELECT k.*, pl.nama_plan FROM mlm_kodeaktivasi k 
                     LEFT JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id 
                     WHERE k.id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function history($id){
            $sql  = "SELECT h.created_at, m.id_member, m.nama_member, s.id_member as id_sponsor, s.nama_member as nama_sponsor 
                        FROM mlm_kodeaktivasi_history h LEFT JOIN mlm_member m ON h.id_member = m.id
                        LEFT JOIN mlm_member s ON m.sponsor = s.id WHERE h.id_kodeaktivasi = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function total_aktivasi($start_date, $end_date){
            $sql  = "SELECT COALESCE(SUM(k.jumlah_hu), 0) AS total FROM mlm_kodeaktivasi_history h
                        LEFT JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                        LEFT JOIN mlm_plan pl ON h.jenis_aktivasi = pl.id
                        WHERE h.created_at >= '$start_date'
                        AND h.created_at < '$end_date' 
                        AND pl.pasangan = '1'
                        AND h.deleted_at IS NULL";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->total;
        }
        
        public function index_member_new($id, $jenis_plan, $jenis_produk = ''){
            $sql  = "SELECT MIN(a.id) AS id, 
                        a.jenis_aktivasi,
                        pl.nama_plan,
                        pj.name,
                        (CASE WHEN a.reposisi = 1 THEN 'Reposisi' ELSE '' END) AS reposisi,
                        fs.name as founder
                        FROM mlm_kodeaktivasi a 
                        LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                        LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
                        LEFT JOIN mlm_bonus_founder_setting fs
                        ON a.founder = fs.id 
                        WHERE a.id_member='$id' 
                        AND pl.jenis_plan='$jenis_plan'
                        AND CASE WHEN LENGTH('$jenis_produk') THEN a.jenis_produk > 0 = '$jenis_produk' ELSE 1 END
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null
                        GROUP BY a.jenis_produk, a.jenis_aktivasi, a.jenis_produk, a.reposisi, a.founder";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        
        public function index_member_ro($id, $jenis_plan){
    		$sql  = "SELECT MIN(a.id) AS id, 
                        a.jenis_aktivasi,
                        pl.nama_plan,
                        pj.name,
                        (CASE WHEN a.reposisi = 1 THEN 'Reposisi' ELSE '' END) AS reposisi,
                        fs.name as founder,
                        pj.name
                        FROM mlm_kodeaktivasi a 
                        LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                        LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
                        LEFT JOIN mlm_bonus_founder_setting fs
                        ON a.founder = fs.id 
                        WHERE a.id_member='$id' 
                        AND pl.jenis_plan >= '$jenis_plan'
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null
                        GROUP BY a.jenis_produk, a.jenis_aktivasi, a.reposisi, a.founder";
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
    		return $query;
        }
        
        public function index_member_upgrade($id, $jenis_plan, $jenis_aktivasi){
    		$sql  = "SELECT MIN(a.id) AS id, 
                        a.jenis_aktivasi,
                        pl.nama_plan,
                        (CASE WHEN a.reposisi = 1 THEN 'Reposisi' ELSE '' END) AS reposisi,
                        fs.name as founder,
                        pj.name
                        FROM mlm_kodeaktivasi a 
                        LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                        LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
                        LEFT JOIN mlm_bonus_founder_setting fs
                        ON a.founder = fs.id 
                        WHERE a.id_member='$id' 
                        AND pl.jenis_plan = '$jenis_plan'
                        AND a.jenis_aktivasi = '$jenis_aktivasi'
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null
                        GROUP BY a.jenis_aktivasi, a.jenis_produk, a.reposisi, a.founder";
                        // echo $sql;
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
    		return $query;
        }

        public function get_kodeaktivasi($id_member, $id, $jenis_plan){
            $sql  = "SELECT a.*,
                        pl.nama_plan,
                        pl.pasangan,
                        pl.parent_pasangan,
                        pl.pasangan_level, 
                        pl.parent_pasangan_level,
                        pl.reward,
                        pl.parent_reward,
                        pl.reward_sponsor,
                        pl.parent_reward_sponsor,
                        pl.tingkat,
                        pl.reward_wajib_ro,
                        pl.saldo_wd,
                        pl.nominal_balik_modal,
                        pj.name,
                        pj.nama_reward,
                        pj.promo_reward_sponsor,
                        pj.poin_reward_promo 
                    FROM mlm_kodeaktivasi a
                    LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                    LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
            		WHERE a.id_member='$id_member' 
                        AND a.id = '$id' 
                        AND pl.jenis_plan='$jenis_plan'
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null LIMIT 1";
    		$c    = new classConnection();
    		$query  = $c->_query_fetch($sql);
    		return $query;
        }

        public function get_kodeaktivasi_fix(){
            $sql  = "SELECT a.*,
                        h.id_member as member_id,
                        h.created_at as tgl_posting,
                        pl.nama_plan,
                        pl.pasangan,
                        pl.parent_pasangan,
                        pl.pasangan_level, 
                        pl.parent_pasangan_level,
                        pl.reward,
                        pl.parent_reward,
                        pl.reward_sponsor,
                        pl.parent_reward_sponsor,
                        pl.tingkat,
                        pl.reward_wajib_ro,
                        pl.saldo_wd,
                        pj.name,
                        pj.nama_reward,
                        pj.promo_reward_sponsor,
                        pj.poin_reward_promo 
                    FROM mlm_kodeaktivasi a
                    JOIN mlm_kodeaktivasi_history h ON a.id = h.id_kodeaktivasi
                    JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                    JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
            		WHERE a.id IN ('73073')
                        AND a.status_aktivasi='1' 
                        AND a.deleted_at is null";
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
    		return $query;
        }

        public function get_kodeaktivasi_ro_reseller(){
            $sql  = "SELECT 
                        a.*, 
                        h.id_member AS member_id,
                        h.created_at as tgl_posting,
                        pl.nama_plan,
                        pl.pasangan,
                        pl.parent_pasangan,
                        pl.pasangan_level, 
                        pl.parent_pasangan_level,
                        pl.reward,
                        pl.parent_reward,
                        pl.reward_sponsor,
                        pl.parent_reward_sponsor,
                        pl.tingkat,
                        pl.reward_wajib_ro,
                        pl.saldo_wd,
                        pj.name,
                        pj.nama_reward,
                        pj.promo_reward_sponsor,
                        pj.poin_reward_promo
                    FROM 
                        mlm_kodeaktivasi a
                    JOIN 
                        mlm_kodeaktivasi_history h 
                        ON a.id = h.id_kodeaktivasi
                    JOIN 
                        mlm_produk_jenis pj 
                        ON a.jenis_produk = pj.id
                    JOIN 
                        mlm_plan pl 
                        ON a.jenis_aktivasi = pl.id
                    LEFT JOIN 
                        (SELECT id_kodeaktivasi 
                         FROM mlm_member_poin_pasangan 
                         WHERE type != 'migrasi'
                         GROUP BY id_kodeaktivasi) mpp 
                        ON mpp.id_kodeaktivasi = h.id_kodeaktivasi
                    WHERE 
                        a.jenis_aktivasi = '13'
                        AND a.status_aktivasi = '1'
                        AND h.created_at >= '2024-10-03 19:34:09'
                        AND a.deleted_at IS NULL
                        AND mpp.id_kodeaktivasi IS NULL";
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
    		return $query;
        }

        public function get_kodeaktivasi_ro($id_member, $id, $jenis_plan){
            $sql  = "SELECT a.*,
                        pl.nama_plan,
                        pl.pasangan,
                        pl.parent_pasangan,
                        pl.pasangan_level, 
                        pl.parent_pasangan_level,
                        pl.reward,
                        pl.parent_reward,
                        pl.reward_sponsor,
                        pl.parent_reward_sponsor,
                        pl.tingkat,
                        pl.reward_wajib_ro,
                        pl.saldo_wd,
                        pj.name,
                        pj.nama_reward,
                        pj.promo_reward_sponsor,
                        pj.poin_reward_promo 
                    FROM mlm_kodeaktivasi a
                    LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                    LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
            		WHERE a.id_member='$id_member' 
                        AND a.id = '$id' 
                        AND pl.jenis_plan >= '$jenis_plan'
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null LIMIT 1";
    		$c    = new classConnection();
    		$query  = $c->_query_fetch($sql);
    		return $query;
        }

        public function get_kodeaktivasi_reseller($id_member, $id, $jenis_plan){
            $sql  = "SELECT a.*,
                        pl.nama_plan,
                        pl.pasangan,
                        pl.parent_pasangan,
                        pl.pasangan_level, 
                        pl.parent_pasangan_level,
                        pl.reward,
                        pl.parent_reward,
                        pl.reward_sponsor,
                        pl.parent_reward_sponsor,
                        pl.tingkat,
                        pl.reward_wajib_ro,
                        pl.saldo_wd,
                        pj.name,
                        pj.nama_reward,
                        pj.promo_reward_sponsor,
                        pj.poin_reward_promo 
                    FROM mlm_kodeaktivasi a
                    LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                    LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
            		WHERE a.id_member='$id_member' 
                        AND a.id = '$id' 
                        AND pl.jenis_plan = '$jenis_plan'
                        AND a.status_aktivasi='0' 
                        AND a.deleted_at is null LIMIT 1";
    		$c    = new classConnection();
    		$query  = $c->_query_fetch($sql);
    		return $query;
        }
        
        
        public function get_kodeaktivasi_fixing($id_kodeaktivasi){
            $sql  = "SELECT a.*,
                            h.id_member AS member_id,
                            pl.nama_plan,
                            pl.pasangan,
                            pl.parent_pasangan,
                            pl.pasangan_level, 
                            pl.parent_pasangan_level,
                            pl.reward,
                            pl.parent_reward,
                            pl.reward_sponsor,
                            pl.parent_reward_sponsor,
                            pl.tingkat,
                            pl.reward_wajib_ro,
                            pl.saldo_wd,
                            pj.name,
                            pj.nama_reward,
                            pj.promo_reward_sponsor,
                            pj.poin_reward_promo 
                    FROM mlm_kodeaktivasi_history h
                    JOIN mlm_kodeaktivasi a ON h.id_kodeaktivasi = a.id
                    JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                    JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
            		WHERE a.id = '$id_kodeaktivasi' 
                        AND a.status_aktivasi = '1'
                        AND a.deleted_at is null 
                    LIMIT 1";
    		$c    = new classConnection();
    		$query  = $c->_query_fetch($sql);
    		return $query;
        }

        public function cek_duplikat($id, $kode_aktivasi){
            $sql  = "SELECT COUNT(id) AS total
            FROM mlm_member
            WHERE kode_aktivasi = '$kode_aktivasi'";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total;
        }
	
        public function update_aktivasi($id, $status_aktivasi, $updated_at){
            $sql  = "UPDATE mlm_kodeaktivasi 
                        SET status_aktivasi = '$status_aktivasi', 
                        updated_at = '$updated_at' 
                        WHERE id = '$id'";
            
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        
        public function create_history($id_kodeaktivasi, $id_member, $jenis_aktivasi, $created_at){
            $sql = "SELECT COUNT(*) as total FROM mlm_kodeaktivasi_history 
                 WHERE id_kodeaktivasi = '$id_kodeaktivasi' AND id_member = '$id_member'";
            
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            $total = $query->total;
            
            if($total == 0){
                $sql  = "INSERT mlm_kodeaktivasi_history (
                    id_kodeaktivasi,
                    id_member,
                    jenis_aktivasi,
                    created_at
                ) VALUES (
                    '$id_kodeaktivasi',
                    '$id_member',
                    '$jenis_aktivasi',
                    '$created_at'
                )";
                $query  = $c->_query($sql);
                return $query;
            } else {
                return true;
            }
        }

        public function stok_pin_new($id_member){
            $sql  = "SELECT COUNT(k.id) AS total, k.reposisi, pj.name as jenis_produk, pl.nama_plan, pl.gambar, f.name as founder_name
                        FROM mlm_kodeaktivasi k 
                        LEFT JOIN mlm_plan pl
                        ON k.jenis_aktivasi = pl.id 
                        LEFT JOIN mlm_bonus_founder_setting f
                        ON k.founder = f.id
                        LEFT JOIN mlm_produk_jenis pj
                        ON k.jenis_produk = pj.id
                        WHERE k.id_member='$id_member' 
                        AND k.id <> 1
                        AND k.status_aktivasi = '0'
                        AND k.deleted_at is null 
                        GROUP BY pl.id, pj.id, f.id, k.reposisi
                        ORDER BY k.id, pj.id, f.id, k.reposisi ASC";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function stok_pin($id_member, $jenis_plan){
            $sql  = "SELECT k.*, pl.nama_plan
                        FROM mlm_kodeaktivasi k 
                        LEFT JOIN mlm_plan pl
                        ON k.jenis_aktivasi = pl.id 
                        WHERE k.id_member='$id_member' 
                        AND pl.jenis_plan='$jenis_plan'
                        AND k.id <> 1
                        AND k.deleted_at is null ORDER BY k.id DESC";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
    
        public function stok_pin_plan($id_member, $jenis_aktivasi){
            $sql  = "SELECT COUNT(*) AS total
                        FROM mlm_kodeaktivasi k 
                        WHERE k.id_member='$id_member' 
                        AND k.jenis_aktivasi='$jenis_aktivasi'
                        AND k.status_aktivasi = '0'
                        AND k.id <> 1
                        AND k.deleted_at is null";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total;
        }
    
        public function jumlah_pin($id_member, $jenis_plan, $status_aktivasi = ''){
            $sql  = "SELECT COUNT(*) AS total 
                        FROM mlm_kodeaktivasi k 
                        LEFT JOIN mlm_plan pl
                        ON k.jenis_aktivasi = pl.id 
                        WHERE k.id_member='$id_member' 
                        AND pl.jenis_plan='$jenis_plan'
                        AND k.id <> 1
                        AND CASE WHEN LENGTH('$status_aktivasi') > 0 THEN k.status_aktivasi = '$status_aktivasi' ELSE 1 END
                        AND k.deleted_at is null ORDER BY k.id DESC ";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total;
        }

        public function cek_pin_upgrade($id_member, $id_plan){
            $sql  = "SELECT a.*, 
                            pl.nama_plan,
                            pl.pasangan,
                            pl.parent_pasangan,
                            pl.pasangan_level, 
                            pl.parent_pasangan_level,
                            pl.reward,
                            pl.parent_reward,
                            pl.reward_sponsor,
                            pl.parent_reward,
                            pl.parent_reward_sponsor,
                            pl.tingkat,
                            pl.reward_wajib_ro 
                    FROM mlm_kodeaktivasi a
                    LEFT JOIN mlm_plan pl
                        ON a.jenis_aktivasi = pl.id 
                    WHERE a.id_member='$id_member' 
                        AND a.jenis_aktivasi = '$id_plan'
                        AND a.status_aktivasi='0' 
                        AND a.reposisi = '0'
                        AND a.founder = '0'
                        AND a.deleted_at is null LIMIT 1";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query;
        }

        public function index_riwayat_aktivasi($id_member){
            $sql  = "SELECT h.id, h.id_member, h.created_at, pl.nama_plan, k.harga, k.reposisi, k.founder, pj.name 
                        FROM mlm_kodeaktivasi_history h
                        LEFT JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                        LEFT JOIN mlm_plan pl ON h.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE h.id_member = '$id_member'
                        AND h.deleted_at IS NULL
                        ORDER BY h.created_at DESC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function total_kode_aktivasi($id_member, $status_aktivasi = ''){
            $sql  = "SELECT COUNT(*) as total_kode_aktivasi 
                        FROM mlm_kodeaktivasi k 
                        WHERE k.id_member='$id_member' 
                        AND CASE WHEN LENGTH('$status_aktivasi') > 0 THEN k.status_aktivasi='$status_aktivasi' ELSE 1 END 
                        AND k.deleted_at is null";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_kode_aktivasi;
        }
    
        public function index_group($id_member, $id_plan = '', $jenis_produk = '', $reposisi = '', $founder = ''){
            $sql  = "SELECT k.jenis_aktivasi as id, k.jenis_produk, pl.nama_plan, pj.name, k.reposisi, k.founder,  COUNT(*) AS total
                        FROM mlm_kodeaktivasi k
                        LEFT JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE k.id_member='$id_member' 
                        AND  k.status_aktivasi='0' 
                        AND CASE WHEN LENGTH('$id_plan') > 0 THEN k.jenis_aktivasi = '$id_plan' ELSE 1 END
                        AND CASE WHEN LENGTH('$jenis_produk') > 0 THEN k.jenis_produk = '$jenis_produk' ELSE 1 END
                        AND CASE WHEN LENGTH('$reposisi') > 0 THEN k.reposisi = '$reposisi' ELSE 1 END
                        AND CASE WHEN LENGTH('$founder') > 0 THEN k.founder = '$founder' ELSE 1 END
                        AND k.deleted_at is null
                        GROUP BY k.jenis_aktivasi, k.jenis_produk, k.reposisi, k.founder";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function index_group_transfer($id_member, $id_plan, $jenis_produk, $reposisi, $founder, $qty){
            $sql  = "SELECT k.*,pl.nama_plan, pj.name
                        FROM mlm_kodeaktivasi k
                        LEFT JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE k.id_member='$id_member' 
                        AND  k.status_aktivasi='0' 
                        AND k.jenis_aktivasi = '$id_plan'
                        AND k.jenis_produk = '$jenis_produk'
                        AND k.reposisi = '$reposisi'
                        AND k.founder = '$founder'
                        AND k.deleted_at is null
                        ORDER BY k.id ASC
                        LIMIT $qty";
            // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
	
        public function update_transfer($id){
            $sql  = "UPDATE mlm_kodeaktivasi SET
                            id_member = '".$this->get_id_member()."'
                            WHERE
                            id = '$id'";
            
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

        public function riwayat_terima($id_member, $bulan=''){
            $sql  = "SELECT a.id, a.harga, a.status_aktivasi, a.id_stokis,  
                        t.id_member_lama, 
                        (CASE 
                            WHEN t.id_member_lama IS NULL THEN a.created_at
                            ELSE t.created_at
                        END)
                        as tanggal, 
                        (CASE 
                            WHEN t.id_member_lama IS NULL THEN 'stokis'
                            ELSE 'member'
                        END)
                        as idpengirim,
                        (CASE 
                            WHEN t.id_member_lama IS NULL THEN CONCAT(s.id_stokis,' <br> ', s.nama_stokis) 
                            ELSE CONCAT(m.id_member,' - ', m.nama_member)
                        END)
                        as pengirim,
                        pl.nama_plan,
                        pj.name,
                        a.reposisi,
                        a.founder 
                        FROM mlm_kodeaktivasi a 
                        LEFT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_baru = '$id_member'
                        LEFT JOIN mlm_member m ON m.id = t.id_member_lama
                        LEFT JOIN mlm_stokis_member s ON s.id = a.id_stokis
                        LEFT JOIN mlm_plan pl ON a.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                        WHERE a.id_member='$id_member' AND (LEFT(a.created_at, 7) = '$bulan' OR LEFT(t.created_at, 7) = '$bulan')
                        AND a.deleted_at is null ORDER BY tanggal DESC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
    
        public function total_terima($id_member, $bulan=''){
            $sql  = "SELECT SUM(a.harga) as total_harga
                        FROM mlm_kodeaktivasi a LEFT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_baru = '$id_member'
                        WHERE a.id_member='$id_member' AND (LEFT(a.created_at, 7) = '$bulan' OR LEFT(t.created_at, 7) = '$bulan')
                        AND a.deleted_at is null ORDER BY a.id DESC";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_harga;
        }
    
        public function total_pin_terima($id_member, $bulan=''){
            $sql  = "SELECT COUNT(*) as total_pin
                        FROM mlm_kodeaktivasi a LEFT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_baru = '$id_member'
                        WHERE a.id_member='$id_member' AND (LEFT(a.created_at, 7) = '$bulan' OR LEFT(t.created_at, 7) = '$bulan')
                        AND a.deleted_at is null ORDER BY a.id DESC";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_pin;
        }
    
        public function riwayat_kirim($id_member, $bulan=''){
            $sql  = "SELECT a.id, a.harga, '2' as status_aktivasi, a.id_stokis, 
                        t.created_at as tanggal, m.id as idpengirim, CONCAT(m.id_member,'<br>', m.nama_member) as pengirim,
                        t.id_member_baru,
                        pl.nama_plan,
                        pj.name,
                        a.reposisi,
                        a.founder
                        FROM mlm_kodeaktivasi a 
                        RIGHT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_lama = '$id_member'
                        LEFT JOIN mlm_member m ON m.id = t.id_member_baru
                        LEFT JOIN mlm_plan pl ON a.jenis_aktivasi = pl.id
                        LEFT JOIN mlm_produk_jenis pj ON a.jenis_produk = pj.id
                        WHERE t.id_member_lama='$id_member' AND LEFT(t.created_at, 7) = '$bulan'
                        AND a.deleted_at is null ORDER BY t.created_at DESC";
                        // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        
        public function total_kirim($id_member, $bulan=''){
            $sql  = "SELECT SUM(a.harga) as total_harga
                        FROM mlm_kodeaktivasi a RIGHT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_lama = '$id_member'
                        LEFT JOIN mlm_member m ON m.id = t.id_member_baru
                        WHERE t.id_member_lama='$id_member' AND LEFT(t.created_at, 7) = '$bulan'
                        AND a.deleted_at is null ORDER BY a.id DESC";
                        // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_harga;
        }
        public function total_pin_kirim($id_member, $bulan=''){
            $sql  = "SELECT COUNT(*) as total_pin
                        FROM mlm_kodeaktivasi a RIGHT JOIN mlm_kodeaktivasi_transfer t 
                        ON a.id = t.id_kodeaktivasi AND t.id_member_lama = '$id_member'
                        LEFT JOIN mlm_member m ON m.id = t.id_member_baru
                        WHERE t.id_member_lama='$id_member' AND LEFT(t.created_at, 7) = '$bulan'
                        AND a.deleted_at is null ORDER BY a.id DESC";
                        // echo $sql;
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_pin;
        }
        
        public function header_omset(){
            $sqlPlanJenis = "SELECT DISTINCT nama_plan FROM mlm_plan_jenis WHERE hitung_omset = '1'";
            $c    = new classConnection();
            $query = $c->_query($sqlPlanJenis);
            return $query;
        }
        
        public function omset_bulanan(){
            // Buat query untuk mendapatkan semua jenis plan dari tabel mlm_plan_jenis
            $sqlPlanJenis = "SELECT DISTINCT nama_plan FROM mlm_plan_jenis WHERE hitung_omset = '1'";
            $c    = new classConnection();
            $plans = $c->_query($sqlPlanJenis); // Eksekusi query untuk mendapatkan semua jenis plan
        
            // Bangun bagian CASE WHEN secara dinamis berdasarkan nama_plan
            $caseStatements = [];
            foreach ($plans as $plan) {
                $planName = $plan['nama_plan'];
                $caseStatements[] = "SUM(CASE WHEN pj.nama_plan = '{$planName}' THEN k.harga ELSE 0 END) AS `{$planName}`";
            }
            $casePart = implode(", ", $caseStatements);
        
            // Bangun query utama dengan dynamic columns
            $sql  = "SELECT LEFT(k.updated_at, 7) AS bulan, 
                        {$casePart}, 
                        SUM(k.harga) AS Total
                    FROM mlm_kodeaktivasi k
                    JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id
                    JOIN mlm_plan_jenis pj ON pl.jenis_plan = pj.id
                    WHERE k.status_aktivasi = '1'
                    AND k.deleted_at IS NULL
                    GROUP BY LEFT(k.updated_at, 7)
                    ORDER BY LEFT(k.updated_at, 7) DESC";
            // Eksekusi query akhir
            $query 	= $c->_query($sql);
            return $query;
        }
        

        public function total_aktivasi_harian($jenis_aktivasi, $tanggal){
            $sql  = "SELECT COUNT(*) AS total FROM mlm_kodeaktivasi k
                        WHERE k.jenis_aktivasi = '$jenis_aktivasi'
                        AND k.status_aktivasi = '1'
                        AND LEFT(k.updated_at, 10) = '$tanggal'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->total;
        }

        public function get_aktivasi_ro_aktif($bulan, $jenis_aktivasi){
            $sql  = "SELECT 
                        k.id, 
                        k.bonus_generasi, 
                        k.bonus_upline, 
                        k.harga,
                        m.id AS member_id,
                        m.id_member, 
                        m.nama_samaran,
                        pl.nama_plan,
                        pj.name
                        FROM mlm_kodeaktivasi_history h
                        JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                        JOIN mlm_member m ON h.id_member = m.id
                        JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id 
                        JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE h.jenis_aktivasi = '$jenis_aktivasi'
                        AND LEFT(h.created_at, 7) = '$bulan'
                        AND k.bonus_upline > 0";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function get_aktivasi_ro_aktif_reward($bulan, $jenis_aktivasi){
            $sql  = "SELECT 
                        k.id, 
                        k.poin_reward, 
                        k.harga,
                        m.id AS member_id,
                        m.id_member, 
                        m.nama_samaran,
                        pl.nama_plan,
                        pl.reward,
                        pl.parent_reward,
                        pj.name
                        FROM mlm_kodeaktivasi_history h
                        JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                        JOIN mlm_member m ON h.id_member = m.id
                        JOIN mlm_plan pl ON k.jenis_aktivasi = pl.id 
                        JOIN mlm_produk_jenis pj ON k.jenis_produk = pj.id
                        WHERE h.jenis_aktivasi = '$jenis_aktivasi'
                        AND LEFT(h.created_at, 7) = '$bulan'
                        AND k.poin_reward > 0";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>