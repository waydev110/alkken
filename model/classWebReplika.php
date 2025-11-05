<?php
    require_once 'classConnection.php';
    class classWebReplika{

        public function index(){
            $sql  = "SELECT * FROM mlm_web_replika ORDER BY id ASC";
            $c    = new classConnection();
            $query 	= $c->_query($sql);
            return $query;
        }

    }
?>