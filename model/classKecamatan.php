<?php 
require_once 'classConnection.php';

class classKecamatan{

	public function index(){
		$sql  = "SELECT * FROM mlm_kecamatan WHERE nama_kecamatan != '' ORDER BY nama_kecamatan ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function semua_kecamatan(){
		$sql  = "SELECT * FROM mlm_kecamatan WHERE nama_kecamatan != '' ORDER BY nama_kecamatan ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}

	public function get_kecamatan($id_kota){
		$sql  = "SELECT * FROM mlm_kecamatan WHERE id_kota = '$id_kota' ORDER BY nama_kecamatan ASC";
		$c    = new classConnection();
		$query  = $c->_query($sql);
        return $query;
	}
}