<?php
    require_once 'classConnection.php';
    class classSatuan{

        public function index(){
            $sql  = "SELECT * FROM mlm_satuan ORDER BY satuan ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }
    }
?>