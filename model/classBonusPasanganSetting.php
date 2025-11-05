<?php
    require_once 'classConnection.php';
    class classBonusPasanganSetting{
        private $id_paket;
        private $nominal_bonus;   
        private $max_pasangan;        
        private $created_at;
        private $updated_at;
        private $deleted_at;    
        
        public function get_id_paket(){
            return $this->id_paket;
        }
    
        public function set_id_paket($id_paket){
            $this->id_paket = $id_paket;
        }
        
        public function get_nominal_bonus(){
            return $this->nominal_bonus;
        }
    
        public function set_nominal_bonus($nominal_bonus){
            $this->nominal_bonus = $nominal_bonus;
        }  
        
        public function get_max_pasangan(){
            return $this->max_pasangan;
        }
    
        public function set_max_pasangan($max_pasangan){
            $this->max_pasangan = $max_pasangan;
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
            $sql 	= "INSERT INTO mlm_bonus_pasangan_setting(
                            id_paket, 
                            nominal_bonus,
                            max_pasangan,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_paket()."', 
                            '".$this->get_nominal_bonus()."',    
                            '".$this->get_max_pasangan()."',                              
                            '".$this->get_created_at()."'
                            )";
            $c 		= new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_bonus_pasangan_setting SET  
                        nominal_bonus = '".$this->get_nominal_bonus()."', 
                        max_pasangan = '".$this->get_max_pasangan()."', 
                        updated_at = '".$this->get_updated_at()."'
                    where id_paket='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT s.*, p.nama_paket 
                        FROM mlm_bonus_pasangan_setting s
                        LEFT JOIN mlm_paket p
                        ON s.id_paket = p.id
                        WHERE s.deleted_at IS NULL 
                        ORDER BY s.id_paket ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_bonus_pasangan_setting WHERE id_paket = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

    }
?>