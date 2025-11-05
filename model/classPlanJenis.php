<?php
    require_once 'classConnection.php';
    class classPlanJenis{

        public function index(){
            $sql  = "SELECT p.* 
                        FROM mlm_plan_jenis p
                        WHERE p.status = '1' 
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_deposit($status = '', $bisa_deposit = ''){
            $sql  = "SELECT p.* 
                        FROM mlm_plan_jenis p 
                        WHERE CASE WHEN LENGTH('$status') > 0 THEN p.status = '$status' ELSE 1 END
                        AND CASE WHEN LENGTH('$bisa_deposit') > 0 THEN p.bisa_deposit = '$bisa_deposit' ELSE 1 END
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function index_jual_pin($status = '', $bisa_dijual = ''){
            $sql  = "SELECT p.* 
                        FROM mlm_plan_jenis p 
                        WHERE CASE WHEN LENGTH('$status') > 0 THEN p.status = '$status' ELSE 1 END
                        AND CASE WHEN LENGTH('$bisa_dijual') > 0 THEN p.bisa_dijual = '$bisa_dijual' ELSE 1 END
                        ORDER BY p.id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

        public function show($id){
            $sql  = "SELECT * FROM mlm_plan_jenis WHERE id = '$id'";
            $c    = new classConnection();
            $query 	= $c->_query_fetch($sql);
            return $query;
        }
    }
?>