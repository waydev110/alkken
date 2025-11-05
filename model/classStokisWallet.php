<?php
    require_once 'classConnection.php';
    class classStokisWallet{
        private $id_stokis;
        private $jenis;
        private $type;
        private $status;
        private $nominal;
        private $id_relasi;
        private $asal_tabel;
        private $keterangan;
        private $created_at;
        private $updated_at;
        private $deleted_at;
        

        public function get_id(){
            return $this->id;
        }
    
        public function set_id($id){
            $this->id = $id;
        }
        
        public function get_id_stokis(){
            return $this->id_stokis;
        }
    
        public function set_id_stokis($id_stokis){
            $this->id_stokis = $id_stokis;
        }
        
        public function get_jenis(){
            return $this->jenis;
        }
    
        public function set_jenis($jenis){
            $this->jenis = $jenis;
        }
        
        public function get_type(){
            return $this->type;
        }
    
        public function set_type($type){
            $this->type = $type;
        }
        
        public function get_status(){
            return $this->status;
        }
    
        public function set_status($status){
            $this->status = $status;
        }
        
        public function get_nominal(){
            return $this->nominal;
        }
    
        public function set_nominal($nominal){
            $this->nominal = $nominal;
        }

        public function get_id_relasi(){
            return $this->id_relasi;
        }
    
        public function set_id_relasi($id_relasi){
            $this->id_relasi = $id_relasi;
        }
        
        public function get_asal_tabel(){
            return $this->asal_tabel;
        }
    
        public function set_asal_tabel($asal_tabel){
            $this->asal_tabel = $asal_tabel;
        }
        
        public function get_keterangan(){
            return $this->keterangan;
        }
    
        public function set_keterangan($keterangan){
            $this->keterangan = $keterangan;
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
            $sql 	= "INSERT INTO mlm_stokis_wallet(
                            id_stokis, 
                            jenis, 
                            type, 
                            status,
                            nominal, 
                            id_relasi, 
                            asal_tabel, 
                            keterangan, 
                            created_at
                        ) 
                        values (
                            '".$this->get_id_stokis()."', 
                            '".$this->get_jenis()."', 
                            '".$this->get_type()."', 
                            '".$this->get_status()."', 
                            '".$this->get_nominal()."', 
                            '".$this->get_id_relasi()."', 
                            '".$this->get_asal_tabel()."', 
                            '".$this->get_keterangan()."', 
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function delete($id){
            $sql = "DELETE FROM mlm_stokis_wallet WHERE id = '$id'";
            $c 		= new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>