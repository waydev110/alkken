<?php
    require_once 'classConnection.php';
    class classPaket{
        private $id;
    	private $gambar;
        private $nama_paket;
    	private $poin;
        private $sponsori;
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
    	public function get_gambar(){
    		return $this->gambar;
    	}
    	public function set_gambar($gambar){
    		$this->gambar = $gambar;
    	}  
        #---------------------------------------------------------------------------------#   
        public function get_nama_paket(){
            return $this->nama_paket;
        } 

        public function set_nama_paket($nama_paket){
            $this->nama_paket = $nama_paket;
        }  
        #---------------------------------------------------------------------------------#   
    	public function get_poin(){
    		return $this->poin;
    	}
    	public function set_poin($poin){
    		$this->poin = $poin;
    	}
        #---------------------------------------------------------------------------------#
        public function get_sponsori(){
            return $this->sponsori;
        }

        public function set_sponsori($sponsori){
            $this->sponsori = $sponsori;
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
            $sql 	= "INSERT INTO mlm_paket(
                nama_paket, 
                gambar, 
                poin, 
                sponsori, 
                created_at) 
            values (
                '".$this->get_nama_paket()."', 
                '".$this->get_gambar()."',
                '".$this->get_poin()."',  
                '".$this->get_sponsori()."',
                '".$this->get_created_at()."'
                )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_paket set 
            nama_paket = '".$this->get_nama_paket()."', 
            gambar = '".$this->get_gambar()."', 
            poin = '".$this->get_poin()."',  
            sponsori = '".$this->get_sponsori()."',
            updated_at = '".$this->get_updated_at()."'
            where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT p.* FROM mlm_paket p WHERE p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_paket WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>