<?php
    require_once 'classConnection.php';
    class classProduk{
        private $id;
        private $id_produk_jenis;
        private $nama_produk;
    	private $gambar;
    	private $slug;
    	private $qty;
    	private $satuan;
        private $hpp;
        private $keterangan;
        private $harga;
        private $nilai_produk;
        private $poin_pasangan;
        private $poin_reward;
        private $bonus_sponsor;
        private $bonus_cashback;
        private $bonus_generasi;
        private $bonus_upline;
        private $fee_stokis;
        private $fee_founder;
        private $tampilkan;
        private $created_at;
        private $updated_at;
        private $deleted_at;


        #---------------------------------------------------------------------------------#
        public function get_id(){
            return $this->id;
        }

        public function set_id($id){
            $this->id = $id;
        } 
        #---------------------------------------------------------------------------------#   
        public function get_id_produk_jenis(){
            return $this->id_produk_jenis;
        } 

        public function set_id_produk_jenis($id_produk_jenis){
            $this->id_produk_jenis = $id_produk_jenis;
        } 
        #---------------------------------------------------------------------------------#   
    	public function get_gambar(){
    		return $this->gambar;
    	}
    	public function set_gambar($gambar){
    		$this->gambar = $gambar;
    	}  
        #---------------------------------------------------------------------------------#   
        public function get_nama_produk(){
            return $this->nama_produk;
        } 

        public function set_nama_produk($nama_produk){
            $this->nama_produk = $nama_produk;
        }  
        #---------------------------------------------------------------------------------#   
    	public function get_slug(){
    		return $this->slug;
    	}
    	public function set_slug($slug){
    		$this->slug = $slug;
    	}
        #---------------------------------------------------------------------------------#   
    	public function get_qty(){
    		return $this->qty;
    	}
    	public function set_qty($qty){
    		$this->qty = $qty;
    	}
        #---------------------------------------------------------------------------------#   
    	public function get_satuan(){
    		return $this->satuan;
    	}
    	public function set_satuan($satuan){
    		$this->satuan = $satuan;
    	}
        #---------------------------------------------------------------------------------#
        public function get_hpp(){
            return $this->hpp;
        }

        public function set_hpp($hpp){
            $this->hpp = $hpp;
        }
        #---------------------------------------------------------------------------------#
        public function get_keterangan(){
            return $this->keterangan;
        }

        public function set_keterangan($keterangan){
            $this->keterangan = $keterangan;
        }
        #---------------------------------------------------------------------------------#
        public function get_harga(){
            return $this->harga;
        }

        public function set_harga($harga){
            $this->harga = $harga;
        }
        
        public function get_nilai_produk(){
            return $this->nilai_produk;
        }

        public function set_nilai_produk($nilai_produk){
            $this->nilai_produk = $nilai_produk;
        }
        
        public function get_poin_pasangan(){
            return $this->poin_pasangan;
        }

        public function set_poin_pasangan($poin_pasangan){
            $this->poin_pasangan = $poin_pasangan;
        }
        
        public function get_poin_reward(){
            return $this->poin_reward;
        }

        public function set_poin_reward($poin_reward){
            $this->poin_reward = $poin_reward;
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
        
        public function get_fee_stokis(){
            return $this->fee_stokis;
        }

        public function set_fee_stokis($fee_stokis){
            $this->fee_stokis = $fee_stokis;
        }
        
        public function get_tampilkan(){
            return $this->tampilkan;
        }

        public function set_tampilkan($tampilkan){
            $this->tampilkan = $tampilkan;
        }
        
        public function get_fee_founder(){
            return $this->fee_founder;
        }

        public function set_fee_founder($fee_founder){
            $this->fee_founder = $fee_founder;
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
    
        #---------------------------------------------------------------------------------#

        public function datatable($request){
            $sort_column =array(
                'p.id',
                'p.id',
                'p.sku',
                'p.nama_produk',
                'p.harga',
                'p.nilai_produk',
                'p.poin_pasangan',
                'p.poin_reward',
                'plan_produk',
                'p.tampilkan',
                'p.id',
                );

            $data_search =array(
                'p.id',
                'p.sku',
                'p.nama_produk',
                );

            $sql  = "SELECT 
                        p.*, 
                        pj.code,
                        pj.name,
                        COALESCE(GROUP_CONCAT(pl.nama_plan SEPARATOR ', '), '') AS plan_produk
                    FROM mlm_produk p 
                    LEFT JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    LEFT JOIN mlm_plan pl ON pp.id_plan = pl.id 
                    LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id 
                    WHERE p.deleted_at IS NULL AND p.id_produk_jenis <> 201
                    AND pp.id_plan <> 201";
            
            $sql_group = " GROUP BY p.id ";

            $c = new classConnection();
            $query = $c->_query($sql.$sql_group);
            $totalData=$query->num_rows;
            if(is_numeric($request['id_plan'])){
                $sql.=" AND pp.id_plan = '".$request['id_plan']."' ";
            }
            if(is_numeric($request['jenis_produk'])){
                $sql.=" AND p.id_produk_jenis = '".$request['jenis_produk']."' ";
            }
            if(is_numeric($request['tampilkan'])){
                $sql.=" AND p.tampilkan = '".$request['tampilkan']."' ";
            }

            // if(!empty($request['search']['value'])){
            //     $sql.=" AND (";
            //     foreach ($data_search as $key => $value) {
            //         if($key > 0){
            //             $sql.=" OR ";
            //         }
            //         $sql.="$value LIKE '%".$request['search']['value']."%'";
            //     }
            //     $sql.=")";
            // }

            if(!empty($request['keyword'])){
                $array_search = array();
                foreach ($data_search as $key => $value) {
                    $array_search[] ="$value LIKE '%".$request['keyword']."%'";
                }
                $sql_search = implode(' OR ', $array_search);
                $sql.=" AND (".$sql_search.")";
            }

            $sql = $sql.$sql_group;
            $query 	= $c->_query($sql);
            $totalFilter = $query->num_rows;
            $sql.=" ORDER BY ".$sort_column[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ". $request['start'].",".$request['length']."  ";
            $query 	= $c->_query($sql);
            $data=array();
            $no = 0;
            while($row = $query->fetch_object()){
                
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = '<img src="../images/produk/'.$row->gambar.'" height="30">';
                $subdata[] = $row->sku;
                $subdata[] = $row->nama_produk.' ['.$row->name.'] ('.$row->qty.' '.$row->satuan.')';
                $subdata[] = currency($row->harga);
                $subdata[] = currency($row->bonus_sponsor);
                $subdata[] = currency($row->nilai_produk);
                $subdata[] = currency($row->poin_pasangan);
                $subdata[] = currency($row->poin_reward);
                $subdata[] = $row->plan_produk;
                $subdata[] = $row->tampilkan == '1' ? 'Ya' : 'Tidak';
                $subdata[] = '<div class="btn-group">
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_item('."'".$row->id."'".', this)"><i class="fas fa-times"></i> </button>
                                <a href="index.php?go=produk_edit&id='.$row->id.'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                              </div>';
                $data[]    =$subdata;
            }
        
            $json_data = array(
                "draw"              =>  intval($request['draw']),
                "recordsTotal"      =>  intval($totalData),
                "recordsFiltered"   =>  intval($totalFilter),
                "data"              =>  $data
            );
            return json_encode($json_data);
        }

        public function create()
        {
            $sql 	= "INSERT INTO mlm_produk(
                id_produk_jenis, 
                gambar, 
                nama_produk, 
                slug, 
                hpp, 
                qty, 
                satuan, 
                keterangan, 
                harga, 
                nilai_produk, 
                poin_pasangan, 
                poin_reward, 
                bonus_sponsor, 
                bonus_cashback, 
                bonus_generasi, 
                bonus_upline, 
                fee_founder, 
                tampilkan, 
                created_at) 
            values (
                '".$this->get_id_produk_jenis()."',
                '".$this->get_gambar()."',
                '".$this->get_nama_produk()."', 
                '".$this->get_slug()."', 
                '".$this->get_hpp()."',
                '".$this->get_qty()."', 
                '".$this->get_satuan()."', 
                '".$this->get_keterangan()."',
                '".$this->get_harga()."',
                '".$this->get_nilai_produk()."',
                '".$this->get_poin_pasangan()."',
                '".$this->get_poin_reward()."',
                '".$this->get_bonus_sponsor()."',
                '".$this->get_bonus_cashback()."',
                '".$this->get_bonus_generasi()."',
                '".$this->get_bonus_upline()."',
                '".$this->get_fee_founder()."',
                '".$this->get_tampilkan()."',
                '".$this->get_created_at()."'
                )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_produk set 
                        id_produk_jenis = '".$this->get_id_produk_jenis()."', 
                        gambar = '".$this->get_gambar()."', 
                        nama_produk = '".$this->get_nama_produk()."', 
                        slug = '".$this->get_slug()."', 
                        hpp = '".$this->get_hpp()."', 
                        harga = '".$this->get_harga()."', 
                        nilai_produk = '".$this->get_nilai_produk()."', 
                        poin_pasangan = '".$this->get_poin_pasangan()."', 
                        poin_reward = '".$this->get_poin_reward()."',
                        bonus_sponsor = '".$this->get_bonus_sponsor()."', 
                        bonus_cashback = '".$this->get_bonus_cashback()."', 
                        bonus_generasi = '".$this->get_bonus_generasi()."', 
                        bonus_upline = '".$this->get_bonus_upline()."', 
                        fee_founder = '".$this->get_fee_founder()."', 
                        tampilkan = '".$this->get_tampilkan()."', 
                        qty = '".$this->get_qty()."', 
                        satuan = '".$this->get_satuan()."', 
                        keterangan = '".$this->get_keterangan()."',
                        updated_at = '".$this->get_updated_at()."'
                        where id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT p.*
                        FROM mlm_produk p
                        WHERE p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_produk_reseller(){
            $sql  = "SELECT p.*
                        FROM mlm_produk p
                        WHERE p.deleted_at IS NULL 
                        AND id_produk_jenis = 201
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_populer(){
            $sql  = "SELECT p.*, COALESCE(SUM(dt.qty), 0) AS total
                        FROM mlm_produk p LEFT JOIN mlm_stokis_jual_pin_detail dt ON dt.id_produk = p.id
                        WHERE p.deleted_at IS NULL AND dt.deleted_at IS NULL 
                        AND p.tampilkan = '1'
						GROUP BY p.id
                        ORDER BY total DESC
                        LIMIT 5";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_reseller(){
            $sql  = "SELECT p.*
                        FROM mlm_produk p
                        WHERE p.deleted_at IS NULL
                        AND p.id_produk_jenis IN (201)
                        AND p.tampilkan = '1'
                        ORDER BY id DESC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        
        public function show($id){
            $sql  = "SELECT p.*
                        FROM mlm_produk p  
                        WHERE p.id = '$id'";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
        
        public function detail($id){
            $sql  = "SELECT p.*, pj.name
                        FROM mlm_produk p  
                        LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id
                        WHERE p.id = '$id'";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function url_slug($slug)
        {
            $sql  = "SELECT p.*, pj.name 
                            FROM mlm_produk p 
                            LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id
                            WHERE p.deleted_at IS NULL 
                            AND p.slug = '$slug'";
            $c    = new classConnection();
            $query     = $c->_query_fetch($sql);
            return $query;
        }
        
        public function show_produk($slug){
            $sql  = "SELECT p.*, pj.name
                        FROM mlm_produk p  
                        LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id
                        WHERE p.slug = '$slug'";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
        

        function insertOrUpdateAndDelete($selectedIdPlans, $id_produk) {

            // Menyiapkan array untuk nilai-nilai id_plan yang akan diolah
            $valuesToInsert = array();

            // Memproses setiap nilai id_plan dalam array
            foreach ($selectedIdPlans as $id_plan) {
                $valuesToInsert[] = "('$id_plan', '$id_produk')";
            }

            // Menggabungkan nilai-nilai id_plan menjadi satu string untuk digunakan dalam query
            $valuesToInsertString = implode(',', $valuesToInsert);

            // Membuat query SQL untuk INSERT ... ON DUPLICATE KEY UPDATE
            $sql = "INSERT INTO mlm_produk_plan (id_plan, id_produk)
                          VALUES $valuesToInsertString
                          ON DUPLICATE KEY UPDATE
                          id_plan = VALUES(id_plan), id_produk = VALUES(id_produk)";
                        //   echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            // Menjalankan query INSERT ... ON DUPLICATE KEY UPDATE
            if (!$query) {
                return false;
            }

            // Membuat query SQL untuk DELETE data yang tidak dicentang
            $selectedIdPlansString = implode(',', $selectedIdPlans);
            $sql = "DELETE FROM mlm_produk_plan
                          WHERE id_produk = '$id_produk' AND id_plan NOT IN ($selectedIdPlansString)";

            $query 	= $c->_query($sql);
            return $query;
        }

        public function delete($id){
            $sql  = "DELETE FROM mlm_produk
                        WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function deleteProdukPlan($id_produk){
            $sql  = "DELETE FROM mlm_produk_plan
                        WHERE id_produk = '$id_produk'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function get_produk($jenis_produk, $keyword){
            $sql  = "SELECT 
                        p.*, 
                        pj.name,
                        COALESCE(GROUP_CONCAT(pl.nama_plan SEPARATOR ', '), '') AS plan_produk
                    FROM mlm_produk p 
                    LEFT JOIN mlm_produk_plan pp ON pp.id_produk = p.id
                    LEFT JOIN mlm_plan pl ON pp.id_plan = pl.id 
                    LEFT JOIN mlm_produk_jenis pj ON p.id_produk_jenis = pj.id 
                    WHERE CASE WHEN LENGTH('$jenis_produk') > 0 THEN p.id_produk_jenis = '$jenis_produk' ELSE 1 END 
                    AND p.nama_produk LIKE '%$keyword%' 
                    AND p.tampilkan = '1'
                    AND p.deleted_at IS NULL
                    GROUP BY p.id 
                    ORDER BY p.nama_produk ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function get_jenis_produk($id_plan){
            $sql  = "SELECT j.*
                    FROM mlm_produk_jenis j
                    JOIN mlm_plan pl ON j.id_plan_jenis = pl.jenis_plan 
                    WHERE pl.id = '$id_plan' 
                    AND pl.tampilkan = '1'
                    AND pl.deleted_at IS NULL
                    ORDER BY j.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_image($id_produk)
        {
            $sql  = "SELECT pi.*
                            FROM mlm_produk_image pi
                            WHERE pi.deleted_at IS NULL 
                            AND pi.id_produk = '$id_produk'
                            ORDER BY pi.sorting ASC";
            $c    = new classConnection();
            $query     = $c->_query($sql);
            return $query;
        }
        
        public function index_produk_plan($id_produk)
        {
            $sql  = "SELECT pl.id, pl.nama_plan, ppl.id_produk
                            FROM mlm_plan pl
                            LEFT JOIN mlm_produk_plan ppl ON ppl.id_plan = pl.id AND ppl.id_produk = '$id_produk'
                            WHERE ppl.deleted_at IS NULL 
                            AND pl.tampilkan = '1'
                            ORDER BY pl.id ASC";
            $c    = new classConnection();
            $query     = $c->_query($sql);
            return $query;
        }
    }
?>