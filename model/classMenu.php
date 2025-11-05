<?php
    require_once 'classConnection.php';
    class classMenu{
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
            $sql = "INSERT INTO mlm_menu ($columns) VALUES ($values)";
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
                $updates[] = "$column = '" . addslashes($value) . "'"; // Sanitization using addslashes
            }
            
            // Convert the updates array into a string for the SQL query
            $updates_str = implode(", ", $updates);
            
            // SQL query for updating the record with the specified ID
            $sql = "UPDATE mlm_menu SET $updates_str WHERE id = '" . addslashes($id) . "'";
            
            // Execute the query
            $c = new classConnection();
            $query = $c->_query($sql);
            
            return $query;
        }
        

        public function index(){
            $sql  = "SELECT m.*, km.kategori
                        FROM mlm_menu m JOIN mlm_menu_kategori km ON m.id_kategori = km.id
                        WHERE m.deleted_at IS NULL 
                        ORDER BY m.created_at DESC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT m.*, km.kategori
                        FROM mlm_menu m JOIN mlm_menu_kategori km ON m.id_kategori = km.id
                        WHERE m.deleted_at IS NULL
                        AND m.id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function home_menu($show_modul = true){
            if($show_modul) {
                $sql  = "SELECT *
                        FROM mlm_menu 
                        WHERE home_menu = '1'
                        AND deleted_at IS NULL 
                        ORDER BY ordering ASC";
            } else {
                $sql  = "SELECT *
                            FROM mlm_menu 
                            WHERE home_menu = '1'
                            AND show_netspin = '1'
                            AND deleted_at IS NULL 
                            ORDER BY ordering ASC";
            }
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function kategori_menu(){
            $sql  = "SELECT *
                        FROM mlm_menu_kategori 
                        WHERE deleted_at IS NULL 
                        ORDER BY ordering ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function menu_by_kategori($id_kategori, $show_modul = true){
            if($show_modul) {
                $sql  = "SELECT *
                        FROM mlm_menu 
                        WHERE id_kategori = '$id_kategori'
                        AND deleted_at IS NULL 
                        ORDER BY ordering ASC";
            } else {
                $sql  = "SELECT *
                        FROM mlm_menu 
                        WHERE id_kategori = '$id_kategori'
                        AND show_netspin = '1'
                        AND deleted_at IS NULL 
                        ORDER BY ordering ASC";
            }
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.reward = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward_pribadi(){
            $sql  = "SELECT p.* 
                        FROM mlm_produk_jenis p 
                        WHERE p.promo_reward_sponsor = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>