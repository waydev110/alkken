<?php
    require_once 'classConnection.php';
    class classRekeningPerusahaan{

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
            $sql  = "SELECT * FROM mlm_stokis_rekening WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

    }
?>