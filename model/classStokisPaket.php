<?php
    require_once 'classConnection.php';
    class classStokisPaket{
        private $id;
        private $nama_paket;
        private $harga_paket;
        private $kode_id;
        private $persentase_fee;
        private $created_at;
        private $updated_at;
        private $deleted_at;

        public function get_id(){
            return $this->id;
        }
    
        public function set_id($id){
            $this->id = $id;
        }
        
        public function get_nama_paket(){
            return $this->nama_paket;
        }
    
        public function set_nama_paket($nama_paket){
            $this->nama_paket = $nama_paket;
        }
        
        public function get_harga_paket(){
            return $this->harga_paket;
        }
    
        public function set_harga_paket($harga_paket){
            $this->harga_paket = $harga_paket;
        }
        
        public function get_kode_id(){
            return $this->kode_id;
        }
    
        public function set_kode_id($kode_id){
            $this->kode_id = $kode_id;
        }
        
        public function get_persentase_fee(){
            return $this->persentase_fee;
        }
    
        public function set_persentase_fee($persentase_fee){
            $this->persentase_fee = $persentase_fee;
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
            $sql 	= "INSERT INTO mlm_stokis_paket(
                            nama_paket,
                            harga_paket,
                            kode_id,
                            persentase_fee,
                            created_at
                        ) 
                        values (
                            '".$this->get_nama_paket()."', 
                            '".$this->get_harga_paket()."', 
                            '".$this->get_kode_id()."', 
                            '".$this->get_persentase_fee()."', 
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }

        public function update($id){
            $sql  = "UPDATE mlm_stokis_paket set 
                        nama_paket = '".$this->get_nama_paket()."', 
                        harga_paket = '".$this->get_harga_paket()."', 
                        kode_id = '".$this->get_kode_id()."', 
                        persentase_fee = '".$this->get_persentase_fee()."', 
                        updated_at = '".$this->get_updated_at()."'
                        where id='$id'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index(){
            $sql  = "SELECT * FROM mlm_stokis_paket WHERE deleted_at IS NULL ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_stokis_paket WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function prefix($id){
            $sql  = "SELECT kode_id FROM mlm_stokis_paket WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->kode_id;
        }

        public function fee_stokis($id_paket_stokis, $jumlah){
            $paket_stokis = $this->show($id_paket_stokis);
            if($paket_stokis){
                $fee_stokis = floor($paket_stokis->persentase_fee/100*$jumlah);
                return $fee_stokis;
            }
            return 0;
        }

        public function jumlah_fee_stokis($id_paket_stokis, $id_paket_stokis_tujuan, $jumlah){
            $paket_stokis = $this->show($id_paket_stokis);
            $persentase_stokis_tujuan = 0;
            $persentase_stokis = 0;
            if($paket_stokis){
                $persentase_stokis = $paket_stokis->persentase_fee;
            }
            $paket_stokis_tujuan = $this->show($id_paket_stokis_tujuan);
            if($paket_stokis_tujuan){
                $persentase_stokis_tujuan = $paket_stokis_tujuan->persentase_fee;
            }
            if($persentase_stokis_tujuan > 0){
                $persentase = $persentase_stokis_tujuan-$persentase_stokis;
            } else {
                $persentase = $persentase_stokis;
            }
            $fee_stokis = floor($persentase/100*$jumlah);
            return $fee_stokis;
        }

    }
?>