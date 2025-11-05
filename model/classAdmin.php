<?php
    require_once 'classConnection.php';
    class classAdmin{
        private $nama_admin;
        private $user_admin;
        private $pass_admin;
        private $level_admin;
        private $status_admin;
        private $created_at;
        private $updated_at;

        
        public function get_nama_admin(){
            return $this->nama_admin;
        }
    
        public function set_nama_admin($nama_admin){
            $this->nama_admin = $nama_admin;
        }
        
        public function get_user_admin(){
            return $this->user_admin;
        }
    
        public function set_user_admin($user_admin){
            $this->user_admin = $user_admin;
        }
        
        public function get_pass_admin(){
            return $this->pass_admin;
        }
    
        public function set_pass_admin($pass_admin){
            $this->pass_admin = $pass_admin;
        }
        
        public function get_level_admin(){
            return $this->level_admin;
        }
    
        public function set_level_admin($level_admin){
            $this->level_admin = $level_admin;
        }
        
        public function get_updated_at(){
            return $this->updated_at;
        }
    
        public function set_updated_at($updated_at){
            $this->updated_at = $updated_at;
        }
        
        public function get_status_admin(){
            return $this->status_admin;
        }
    
        public function set_status_admin($status_admin){
            $this->status_admin = $status_admin;
        }  
        public function get_created_at(){
            return $this->created_at;
        }
    
        public function set_created_at($created_at){
            $this->created_at = $created_at;
        }

        public function index(){
            $sql  = "SELECT * FROM mlm_admin 
                        WHERE deleted_at IS NULL 
                        ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
  

        public function create()
        {
            $sql 	= "INSERT INTO mlm_admin(
                            nama_admin,
                            user_admin,
                            pass_admin,
                            level_admin,
                            status_admin,
                            created_at
                        ) 
                        values (
                            '".$this->get_nama_admin()."', 
                            '".$this->get_user_admin()."', 
                            '".$this->get_pass_admin()."', 
                            '".$this->get_level_admin()."', 
                            '".$this->get_status_admin()."', 
                            '".$this->get_created_at()."'
                            )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_admin set 
                        nama_admin = '".$this->get_nama_admin()."', 
                        user_admin = '".$this->get_user_admin()."', 
                        pass_admin = '".$this->get_pass_admin()."', 
                        level_admin = '".$this->get_level_admin()."', 
                        status_admin = '".$this->get_status_admin()."', 
                        updated_at = '".$this->get_updated_at()."'
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function delete($id){
            $sql  = "UPDATE mlm_admin SET 
                        deleted_at = NOW()'
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function restore($id){
            $sql  = "UPDATE mlm_admin set 
                        deleted_at = NULL
                    where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
        public function show($id){
            $sql  = "SELECT * FROM mlm_admin WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

    }
?>