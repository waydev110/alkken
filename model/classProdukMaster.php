<?php
    require_once("classConnection.php");
    class classProdukMaster{
        
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
                $sanitized_values[] = "'" . $value . "'"; // Sanitasi dengan addslashes
            }
            
            // Gabungkan nilai-nilai tersebut untuk dimasukkan ke dalam query
            $values = implode(", ", $sanitized_values);
            
            // Query SQL untuk insert
            $sql = "INSERT INTO mlm_produk ($columns) VALUES ($values)";
            // Koneksi ke database
            $c = new classConnection();
            // echo $sql;
            $query = $c->_query_insert($sql);
            
            return $query;
        }

        public function update($id) {
            // Create an array for storing the sanitized columns and their corresponding values
            $updates = [];
            
            // Loop through each attribute and sanitize the value
            foreach ($this->attributes as $column => $value) {
                $updates[] = "$column = '" . $value . "'"; // Sanitization using addslashes
            }
            
            // Convert the updates array into a string for the SQL query
            $updates_str = implode(", ", $updates);
            
            // SQL query for updating the record with the specified ID
            $sql = "UPDATE mlm_produk SET $updates_str WHERE id = '" . addslashes($id) . "'";
            
            // Execute the query
            $c = new classConnection();
            $query = $c->_query($sql);
            
            return $query;
        }

        public function datatable($request){
            $sort_column =array(
                'p.id',
                'p.id',
                'pm.nama_produk',
                'p.jenis_produk',
                'p.harga',
                'p.jumlah_hu',
                'p.bonus_sponsor',
                'p.bonus_cashback',
                'p.bonus_generasi',
                'p.poin_belanja_group',
                'p.poin_belanja_pribadi',
                'p.bonus_sponsor_stokis',
                'p.fee_stokis',
                'p.id',
                );

            $data_search =array(
                'p.id',
                'p.id_produk',
                'pm.nama_produk',
                );

                $sql  = "SELECT 
                            p.*, 
                            pm.nama_produk,
                            pm.gambar
                        FROM mlm_produk p
                        LEFT JOIN mlm_produk_master pm ON p.id_produk = pm.id
                        WHERE p.deleted_at IS NULL";

            $c = new classConnection();
            $query = $c->_query($sql);
            $totalData=$query->num_rows;
                
            if(isset($request['jenis_produk'])){
                $sql.=" AND p.jenis_produk = '".$request['jenis_produk']."' ";
            }
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
            $sql .= " ORDER BY " . $sort_column[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
        if($request['length'] > 0){
            $sql .="  LIMIT ". $request['start'].",".$request['length']."  ";
        }
        
            $query 	= $c->_query($sql);
            $data=array();
            $no = 0;
            while($row = $query->fetch_object()){
                $no++;
                $subdata=array();
                $subdata[] = $no;
                $subdata[] = '<img src="../images/produk/'.$row->gambar.'" height="30">';
                $subdata[] = $row->nama_produk;
                $subdata[] = jenis_produk($row->jenis_produk);
                $subdata[] = currency($row->harga);
                $subdata[] = currency($row->jumlah_hu);
                $subdata[] = currency($row->bonus_sponsor);
                $subdata[] = currency($row->bonus_cashback);
                $subdata[] = currency($row->bonus_generasi);
                $subdata[] = currency($row->poin_belanja_group);
                $subdata[] = currency($row->poin_belanja_pribadi);
                $subdata[] = currency($row->bonus_sponsor_stokis);
                $subdata[] = currency($row->fee_stokis);
                $subdata[] = "<a href='index.php?go=produk_edit&id=".base64_encode($row->id)."' class='btn btn-primary btn-xs'><i class='fas fa-edit'></i></a>";
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

        public function index(){
            $sql  = "SELECT p.*, pm.gambar, pm.nama_produk, pm.jumlah_stock 
                        FROM mlm_produk p 
                        LEFT JOIN mlm_produk_master pm
                        ON p.id_produk = pm.id
                        WHERE p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        
        public function show($id){
            $sql  = "SELECT p.*, pm.gambar, pm.nama_produk, pm.jumlah_stock 
                        FROM mlm_produk p 
                        LEFT JOIN mlm_produk_master pm
                        ON p.id_produk = pm.id
                        WHERE p.deleted_at IS NULL 
                        AND p.id = '$id'
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>