<?php
    require_once 'classConnection.php';

    class classStokisJualPinDetail{
        private $id_jual_pin;
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

        public function get_id_jual_pin(){
            return $this->id_jual_pin;
        }
    
        public function set_id_jual_pin($id_jual_pin){
            $this->id_jual_pin = $id_jual_pin;
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

        public function create()
        {
            $sql 	= "INSERT INTO mlm_stokis_jual_pin_detail(
                            id_jual_pin,
                            id_produk,
                            nama_produk,
                            hpp,
                            harga,
                            qty,
                            jumlah,
                            fee_stokis,
                            created_at
                        ) 
                        values (
                            '".$this->get_id_jual_pin()."',
                            '".$this->get_id_produk()."',
                            '".$this->get_nama_produk()."',
                            '".$this->get_hpp()."',
                            '".$this->get_harga()."',
                            '".$this->get_qty()."',
                            '".$this->get_jumlah()."',
                            '".$this->get_fee_stokis()."',
                            '".$this->get_created_at()."'
                        )";
            $c 		= new classConnection();
            $query 	= $c->_query_insert($sql);
            return $query;
        }
        
        public function index($id_jual_pin){
            $sql  = "SELECT dt.*,
                        p.gambar,
                        j.name,
                        p.sku,
                        p.qty as qty_produk,
                        p.qty*dt.qty as total_produk,
                        p.satuan,
                        CONCAT_WS(' ', j.name, ' - ', p.nama_produk, p.qty, p.satuan) AS nama_produk_detail
                        FROM mlm_stokis_jual_pin_detail dt
                        LEFT JOIN mlm_produk p ON dt.id_produk = p.id 
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id 
                        WHERE dt.id_jual_pin = '$id_jual_pin'
                        AND dt.deleted_at IS NULL
                        ORDER BY dt.id ASC";
            $c    = new classConnection();
            $query  = $c->_query($sql);
            return $query;
        }
        public function total_hu($id_jual_pin){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS total_hu
                        FROM mlm_stokis_jual_pin_detail
                        WHERE id_jual_pin = '$id_jual_pin'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query->total_hu;
        }
        public function benefit_produk($id_jual_pin){
            $sql  = "SELECT COALESCE(SUM(total_hu), 0) AS jumlah_hu,
                        COALESCE(SUM(bonus_sponsor), 0) AS bonus_sponsor,
                        COALESCE(SUM(bonus_cashback), 0) AS bonus_cashback,
                        COALESCE(SUM(bonus_generasi), 0) AS bonus_generasi,
                        COALESCE(SUM(bonus_poin), 0) AS bonus_poin
                        FROM mlm_stokis_jual_pin_detail
                        WHERE id_jual_pin = '$id_jual_pin'
                        AND deleted_at IS NULL";
            $c    = new classConnection();
            $query  = $c->_query_fetch($sql);
            return $query;
        }


        public function delete($id_jual_pin){
            $sql  = "DELETE FROM mlm_stokis_jual_pin WHERE id_jual_pin = '$id_jual_pin'";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>