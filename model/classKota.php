<?php 
    require_once 'classConnection.php';

    class classKota{
    	public function index(){
    		$sql  = "SELECT * FROM mlm_kota WHERE nama_kota != '' ORDER BY nama_kota ASC";
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
            return $query;
    	}

    	public function get_kota($id_provinsi){
    		$sql  = "SELECT * FROM mlm_kota WHERE id_provinsi = '$id_provinsi' ORDER BY nama_kota ASC";
    		$c    = new classConnection();
    		$query  = $c->_query($sql);
            return $query;
    	}

    }
?>