<?php
    require_once 'classConnection.php';
    class classBonusGenerasiSetting{
        private $id_plan;
        private $max;        
        private $created_at;
        private $updated_at;
        private $deleted_at;    
        
        public function get_id_plan(){
            return $this->id_plan;
        }
    
        public function set_id_plan($id_plan){
            $this->id_plan = $id_plan;
        }
        
        public function get_max(){
            return $this->max;
        }
    
        public function set_max($max){
            $this->max = $max;
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
            $sql 	= "INSERT INTO mlm_bonus_generasi_setting(
                            id_plan, 
                            max,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_plan()."', 
                            '".$this->get_max()."',                              
                            '".$this->get_created_at()."'
                            )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_bonus_generasi_setting SET  
                        id_plan = '".$this->get_id_plan()."', 
                        max = '".$this->get_max()."', 
                        updated_at = '".$this->get_updated_at()."'
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT s.*, pl.nama_plan
                        FROM mlm_bonus_generasi_setting s
                        LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                        WHERE s.deleted_at IS NULL 
                        ORDER BY s.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_bonus_generasi_setting WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

    }
?>