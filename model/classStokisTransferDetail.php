<?php
    require_once 'classConnection.php';

    class classStokisTransferDetail{
        private $id;
        private $id_transfer;
        private $id_produk;
        private $nama_produk;
        private $hpp;
        private $harga;
        private $qty;
        private $jumlah;
        private $fee_stokis;
        private $created_at;
        private $updated_at;
        private $deleted_at;

        public function get_id(){
            return $this->id;
        }
    
        public function set_id($id){
            $this->id = $id;
        }
        
        public function get_id_transfer(){
            return $this->id_transfer;
        }
    
        public function set_id_transfer($id_transfer){
            $this->id_transfer = $id_transfer;
        }
        
        public function get_id_produk(){
            return $this->id_produk;
        }
    
        public function set_id_produk($id_produk){
            $this->id_produk = $id_produk;
        }
        
        public function get_nama_produk(){
            return $this->nama_produk;
        }
    
        public function set_nama_produk($nama_produk){
            $this->nama_produk = $nama_produk;
        }
        
        public function get_hpp(){
            return $this->hpp;
        }
    
        public function set_hpp($hpp){
            $this->hpp = $hpp;
        }
        
        public function get_harga(){
            return $this->harga;
        }
    
        public function set_harga($harga){
            $this->harga = $harga;
        }
        
        public function get_qty(){
            return $this->qty;
        }
    
        public function set_qty($qty){
            $this->qty = $qty;
        }
        
        public function get_jumlah(){
            return $this->jumlah;
        }
    
        public function set_jumlah($jumlah){
            $this->jumlah = $jumlah;
        }
        
        public function get_fee_stokis(){
            return $this->fee_stokis;
        }
    
        public function set_fee_stokis($fee_stokis){
            $this->fee_stokis = $fee_stokis;
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
        
        
        // public function create($id_stokis, $id_stokis_tujuan, $id_transfer, $persentase_fee, $created_at){
            public function create(){    
            // $sql = "INSERT INTO mlm_stokis_transfer_detail (
            //             id_transfer, 
            //             id_produk, 
            //             nama_produk, 
            //             hpp, 
            //             harga, 
            //             qty, 
            //             jumlah, 
            //             fee_stokis, 
            //             created_at
            //         ) SELECT 
            //             '$id_transfer',
            //             c.id_produk,
            //             p.nama_produk,
            //             p.hpp,
            //             p.harga,
            //             c.qty,
            //             p.harga*c.qty,
            //             (p.fee_stokis*c.qty)*$persentase_fee,
            //             '$created_at'
            //         FROM mlm_stokis_transfer_cart c
            //         LEFT JOIN mlm_produk p ON c.id_produk = p.id
            //         
            //         WHERE c.id_stokis = '$id_stokis'
            //         AND c.id_stokis_tujuan = '$id_stokis_tujuan'
            //         AND c.status = '0'
            //         AND c.deleted_at IS NULL
            //         ";
            $sql = "INSERT INTO mlm_stokis_transfer_detail (
                        id_transfer, 
                        id_produk, 
                        nama_produk, 
                        hpp, 
                        harga, 
                        qty, 
                        jumlah, 
                        fee_stokis, 
                        created_at
                    ) VALUES ( 
                        '".$this->get_id_transfer()."',
                        '".$this->get_id_produk()."',
                        '".$this->get_nama_produk()."',
                        '".$this->get_hpp()."',
                        '".$this->get_harga()."',
                        '".$this->get_qty()."',
                        '".$this->get_jumlah()."',
                        '".$this->get_fee_stokis()."',
                        '".$this->get_created_at()."'
                    )";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        
        public function index($id_transfer){
            $sql  = "SELECT dt.*,
                        p.sku,
                        p.qty*dt.qty as total_produk,
                        p.satuan,
                        CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail
                        FROM mlm_stokis_transfer_detail dt
                        LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE dt.id_transfer = '$id_transfer'
                        AND dt.deleted_at IS NULL
                        ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }

    }
?>