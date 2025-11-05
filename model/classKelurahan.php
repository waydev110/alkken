<?php 
require_once 'classConnection.php';

class classKelurahan{
	
	public function index(){
		$sql  = "SELECT * FROM mlm_kelurahan WHERE nama_kelurahan != '' ORDER BY nama_kelurahan ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function get_kelurahan($id_kecamatan){
		$sql  = "SELECT * FROM mlm_kelurahan WHERE id_kecamatan = '$id_kecamatan' ORDER BY nama_kelurahan ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}
}