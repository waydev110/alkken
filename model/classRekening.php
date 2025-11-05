<?php
    require_once 'classConnection.php';
    class classRekening{
        private $id_bank;
        private $atas_nama_rekening;
        private $no_rekening;
        private $cabang_rekening;
        private $status;
        private $created_at;
        private $updated_at;
        private $deleted_at;
        
        public function get_id_bank(){
            return $this->id_bank;
        }
    
        public function set_id_bank($id_bank){
            $this->id_bank = $id_bank;
        }
        
        public function get_atas_nama_rekening(){
            return $this->atas_nama_rekening;
        }
    
        public function set_atas_nama_rekening($atas_nama_rekening){
            $this->atas_nama_rekening = $atas_nama_rekening;
        }
        
        public function get_no_rekening(){
            return $this->no_rekening;
        }
    
        public function set_no_rekening($no_rekening){
            $this->no_rekening = $no_rekening;
        }
        
        public function get_cabang_rekening(){
            return $this->cabang_rekening;
        }
    
        public function set_cabang_rekening($cabang_rekening){
            $this->cabang_rekening = $cabang_rekening;
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
    
    
        #---------------------------------------------------------------------------------#

        public function create()
        {
            $sql 	= "INSERT INTO mlm_rekening_perusahaan(
                        id_bank,
                        atas_nama_rekening,
                        no_rekening,
                        cabang_rekening,
                        status,
                        created_at
                        ) 
                        values (
                            '".$this->get_id_bank()."', 
                            '".$this->get_atas_nama_rekening()."', 
                            '".$this->get_no_rekening()."', 
                            '".$this->get_cabang_rekening()."', 
                            '".$this->get_status()."', 
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_rekening_perusahaan set 
                        id_bank = '".$this->get_id_bank()."', 
                        atas_nama_rekening = '".$this->get_atas_nama_rekening()."', 
                        no_rekening = '".$this->get_no_rekening()."', 
                        cabang_rekening = '".$this->get_cabang_rekening()."', 
                        status = '".$this->get_status()."', 
                        updated_at = '".$this->get_updated_at()."'
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT r.*, b.logo, b.kode_bank, b.nama_bank 
                        FROM mlm_rekening_perusahaan r
                        LEFT JOIN mlm_bank b
                        ON r.id_bank = b.id
                        WHERE r.deleted_at IS NULL ORDER BY r.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT r.*, b.logo, b.kode_bank, b.nama_bank
                        FROM mlm_rekening_perusahaan r
                        LEFT JOIN mlm_bank b
                        ON r.id_bank = b.id
                        WHERE r.id = '$id' AND r.deleted_at IS NULL";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

    }
?>