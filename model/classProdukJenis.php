<?php
    require_once 'classConnection.php';
    class classProdukJenis{

        public function index($id_plan_jenis = ''){
            $sql  = "SELECT * FROM mlm_produk_jenis 
                        WHERE CASE WHEN LENGTH('$id_plan_jenis') > 0 THEN id_plan_jenis = '$id_plan_jenis' ELSE 1 END
                        AND deleted_at IS NULL
                        ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward(){
            $sql  = "SELECT p.* 
                        FROM mlm_produk_jenis p 
                        WHERE p.reward = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function plan_reward_sponsor(){
            $sql  = "SELECT p.* 
                        FROM mlm_produk_jenis p 
                        WHERE p.reward_sponsor = '1'
                        AND p.deleted_at IS NULL 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT p.* 
                        FROM mlm_produk_jenis p 
                        WHERE p.id = '$id'
                        AND p.deleted_at IS NULL";
                        // echo $sql;
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }

        public function multiplication($id){
            $sql  = "SELECT COALESCE(multiplication, 1) AS multiplication
                        FROM mlm_produk_jenis
                        WHERE id = '$id'
                        UNION
                        SELECT 1 AS multiplication
                        LIMIT 1";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query->multiplication;
        }
    }
?>