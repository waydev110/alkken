<?php
    require_once 'classConnection.php';
    class classPlan{

        public function index($jenis_plan = ''){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE CASE WHEN LENGTH('$jenis_plan') > 0 THEN p.jenis_plan = '$jenis_plan' ELSE 1 END
                        AND p.tampilkan = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function produk_plan($id_plan, $id_produk){
            $sql  = "SELECT COUNT(*) AS total FROM mlm_produk_plan 
                        WHERE id_plan = '$id_plan' 
                        AND id_produk = '$id_produk'";
                        // echo $sql.'<br>';
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->total;

        }

        public function plan_kode_aktivasi(){
            $sql  = "SELECT p.*, j.nama_plan as jenis_plan
                        FROM mlm_plan p 
                        LEFT JOIN mlm_plan_jenis j ON p.jenis_plan = j.id
                        WHERE p.deleted_at IS NULL 
                        AND p.tampilkan = '1'
                        AND p.jenis_plan <= 2
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_upgrade($id_plan, $tingkat){
            $sql  = "SELECT pl.* 
                        FROM mlm_plan pl
                        WHERE pl.jenis_plan = '0'
                        AND pl.tingkat > '$tingkat'
                        AND pl.deleted_at IS NULL 
                        AND pl.tampilkan = '1'
                        ORDER BY pl.tingkat ASC";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_plan WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function show_by_tingkat($tingkat){
            $sql  = "SELECT * FROM mlm_plan WHERE tingkat = '$tingkat' LIMIT 1";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function plan_register(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.jenis_plan = '0'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_pasangan(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.pasangan = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_pasangan_level(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.pasangan_level = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.reward = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward_sponsor(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.reward_sponsor = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward_pribadi(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan p 
                        WHERE p.reward_pribadi = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function get_plan_reward(){
            $sql  = "SELECT p.id 
                        FROM mlm_plan p 
                        WHERE p.reward = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC 
                        LIMIT 1";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->id;
        }

        public function get_plan_reward_pribadi(){
            $sql  = "SELECT p.id 
                        FROM mlm_plan p 
                        WHERE p.reward_sponsor = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC 
                        LIMIT 1";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->id;
        }

        public function index_reward(){
            $sql  = "SELECT pl.id, pl.nama_reward as nama_reward, 'klaim_reward' as alias
                        FROM mlm_plan pl 
                        WHERE pl.reward = '1'
                        AND pl.deleted_at IS NULL 

                    UNION
                    SELECT pl.id, pl.nama_reward_sponsor as nama_reward, 'klaim_reward_pribadi' as alias
                        FROM mlm_plan pl 
                        WHERE pl.reward_sponsor = '1'
                        AND pl.deleted_at IS NULL 
                    ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_reward_pribadi(){
            $sql  = "SELECT pl.* 
                        FROM mlm_plan pl 
                        WHERE pl.reward_sponsor = '1'
                        AND pl.deleted_at IS NULL 
                        ORDER BY pl.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>